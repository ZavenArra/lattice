<?
/**
 * Class: CMS_Controller
 * The main CMS class, handling add, delete, and retrieval of pages
 * @author Matthew Shultz
 * @version 1.0
 * @package Kororor
 */


class CMS_Controller extends Controller {

	/*
	*  Variable: page_id
	*  static int the global page id when operating within the CMS submodules get the page id
	*  we could just reference the primaryId attribute of Display as well...
	*/
	private static $page_id = NULL;


	/*
	 * Variable: unique
	 * Used to provide unique ids for radio buttons and other input elements
	 */
	private static $unique = 1;

	/*
		Variable: model
		The main data model for content stored by this module
	*/
	private $model = 'page';

	/*
	*
	* Variable: modules
	* Build the cms's included modules
	*
	*/
	public $subModules =  array();

	/*
		Function: __constructor
		Loads subModules to build from config	
	*/
	public function __construct(){
		parent::__construct();

		$this->modules = Kohana::config('cms.subModules');

	}

	/*
	 * Function: setPageId($page_id)
	 * Sets the page id of the object currently being edited
	 * Parameters:
	 * page_id  - the page id
	 * Returns: nothing 
	 */
	private function setPageId($page_id){
		if(self::$page_id == NULL){
			self::$page_id = $page_id;
		}
	}

	/*
	 * Function: getPageId() 
	 * Returns the page id of the object currently being edited
	 * Parameters: none
	 * Returns: page id
	 */
	public static function getPageId(){
		return self::$page_id;
	}

	/*
	Function: getPage(id)
	Builds the editing page for the object currenlty being edited
	Parameters: 
	id - the page id to be retrieved
	Returns: array('html'=>html, 'js'=>js, 'css'=>css)
	*/
	public function getPage($id){
		
		self::$page_id = $id;
		
		$page = ORM::factory('page', $id);
		if($page->id == 0){
			throw new Kohana_User_Exception('Invalid Id', 'Invalid Page Id '.$id);
		}
		
		//new generation of page
		//1 grap cms_nodetitle
		$this->nodetitle = new View('cms_nodetitle');
		$this->nodetitle->loadResources();
		$this->nodetitle->title = $page->contenttable->title; //this should change to page table
		$this->nodetitle->allow_delete = $page->template->allow_delete;

		$settings = Kohana::config('cms.defaultsettings');
		if(is_array($settings)){
			foreach($settings as $key=>$value){
				$this->nodetitle->$key = $value;
			}
		}
		//and get settings for specific template
		$settings = Kohana::config('cms.'.$page->template->templatename.'.defaultsettings');
		if(is_array($settings)){
			foreach($settings as $key=>$value){
				$this->nodetitle->$key = $value;
			}
		}
		
		$nodetitlehtml = $this->nodetitle->render();

		$customview = 'templates/'.$page->template->templatename; //check for custom view for this template
		$usecustomview = false;
		if(Kohana::find_file('views', $customview)){
			$usecustomview = true;	
		}

    $htmlChunks = cms::buildUIHtmlChunksForObject($page);

		if(!$usecustomview){
			$html = $nodetitlehtml.implode($htmlChunks);
		} else {
			$html = $nodetitlehtml;
			$view = new View($customview);
			$view->loadResources();
			foreach($htmlChunks as $key=>$value){
				$view->$key = $value;
			}
			$html .= $view->render();
		}

	

		$js = array();
		foreach(Display_Controller::getJS() as $ajs){
			$js[] = Kohana::config('config.site_domain').$ajs;
		}
		$css = array();
		foreach(Display_Controller::getCSS() as $acss){
			$css[] = Kohana::config('config.site_domain').$acss;
		}


		$return = array(
			'html'=>$html,
			'js'=>$js,
			'css'=>$css,
		);
		return $return;

	}

	/*
	 * Function:  saveFile($pageid)
	 * Function called on file upload
	 * Parameters:
	 * pageid  - the page id of the object currently being edited
	 * $_POST['field'] - the content table field for the file
	 * $_FILES[{fieldname}] - the file being uploaded
	 * Returns:  array(
		 'id'=>$file->id,
		 'src'=>$this->basemediapath.$savename,
		 'filename'=>$savename,
		 'ext'=>$ext,
		 'result'=>'success',
	 );
	 */
	public function saveFile($pageid){

		$page = ORM::Factory('page', $pageid);

		//check the file extension
		Kohana::log('info', var_export($_POST, true));
		Kohana::log('info', var_export($_FILES, true));
		$filename = $_FILES[$_POST['field']]['name'];
		$ext = substr(strrchr($filename, '.'), 1);
		switch($ext){
		case 'jpeg':
		case 'jpg':
		case 'gif':
		case 'png':
		case 'JPEG':
		case 'JPG':
		case 'GIF':
		case 'PNG':
		case 'tif':
		case 'tiff':
		case 'TIF':
		case 'TIFF':
			Kohana::log('info', $page->template->templatename.$_POST['field']);
			$parameters = Kohana::config('cms_images.'.$page->template->templatename.'.'.$_POST['field'].'.resize');
			$uiimagesize = array('uithumb'=>Kohana::config('cms.uiresize'));

			if($parameters){
				$parameters['imagesizes'] = array_merge($uiimagesize, $parameters['imagesizes']);
			} else {
				$parameters['imagesizes'] = $uiimagesize;
			}

			if($parameters){
				return $page->saveImage($_POST['field'], $_FILES, $parameters);
			} else {
				return $page->saveFile($_POST['field'], $_FILES);
			}
			break;

		default:
			return $page->saveFile($_POST['field'], $_FILES);
		}

	}

	/*
	*
	* Function: savefield()
	* Saves data to a field via ajax.  Call this using /cms/ajax/save/{pageid}/
	* Parameters:
	* $id - the id of the object currently being edited
	* $_POST['field'] - the content table field being edited
	* $_POST['value'] - the value to save
	* Returns: array('value'=>{value})
	 */
	public function savefield($id){
		$page = ORM::Factory('page')->find($id);
		if($_POST['field']=='title'){ //update slug, but actually we may not want to have slug updatable
			$page->slug = cms::createSlug($_REQUEST['value'], $page->id);
			$page->save();
		}


		   
		if(in_array($_POST['field'], array('dateadded'))){
			$page->$_POST['field'] = $_POST['value'];
			$page->save();
		} else if($_POST['field']) {
			$fields = Kohana::config('cms.modules.'.$page->template->templatename); //this is annoying and experimental
      $lookup = array(
        'title'=>'default'
      );
			foreach($fields as $f){
				if(isset($f['field'])){
					$lookup[$f['field']] = $f;
				}
			}
			switch($lookup[$_POST['field']]['type']){
			case 'multiSelect':
				$object = ORM::Factory('page', $_POST['field']);
				if(!$object->loaded){
					$object->template_id = ORM::Factory('template', $lookup[$_POST['field']]['object'])->id;
					$object->save();
					$page->contenttable->$_POST['field'] = $object->id;
					$page->contenttable->save();
				}
				$options = array();
				foreach(Kohana::config('cms.templates.'.$object->template->templatename) as $field){
					if($field['type'] == 'checkbox'){
						$options[] = $field['field'];
					}
				}
				foreach($options as $field){
					$object->contenttable->$field  = 0;
				}

				foreach($_POST['value'] as $value){
					$object->contenttable->$value = 1;
				}
				$object->contenttable->save();
				break;	
			default:
				$page->contenttable->$_POST['field'] = cms::convertNewlines($_POST['value']);
				$page->contenttable->save();
				break;
			}
		} else {
			throw new Kohana_User_Exception('Invalid POST', 'Invalid POST Arguments');
		}

		$page = ORM::Factory('page')->find($id);
		return array('value'=>$page->contenttable->$_POST['field']);
	}

	/*
	 * Function: checkForValidPageId($id) 
	 * Validates the current page id 
	 * Parameters:
	 * $id  - the id to check 
	 * Returns: throws exception on invalid page id
	 */
	public function checkForValidPageId($id){
		if(!ORM::Factory('page')->where('id', $id)->find()->loaded){
			throw new Kohana_User_Exception('Bad Page Id', 'The id '.$id.' is not a key in for an object in the pages table');
		}
	}

	/*
	Function: addObject($id)
	Public interface for adding an object to the cms data
	Parameters:
	id - the id of the parent category
	template_id - the type of object to add
	title - optional title for initialization
	$_POST - possible array of keys and values to initialize with
	Returns: nav controller node object
	*/
	public function addObject($id, $template_id, $title=null){
		$data = $_POST;
		$template_id = ORM::Factory('template', $template_id)->id;
		if($title){
			$data['title'] = $title;
		}
		$newid = $this->__addObject($id, $template_id, $data);

		//Dial up associated navi and ask for details
		$nav_controller = ucfirst($this->modules['navigation']).'_Controller';
		$nav_controller = new $nav_controller();
		return $nav_controller->getNode($newid);
	}

	/*
	Function: __addObject($id)
	Private function for adding an object to the cms data
	Parameters:
	id - the id of the parent category
	template_id - the type of object to add
	$data - possible array of keys and values to initialize with
	Returns: the new page id
	*/
	private function __addObject($id, $template_id = NULL, $data = array() ){
		if($id!=='0'){
			$this->checkForValidPageId($id);
		}
		$newpage = ORM::Factory('page');
		if($template_id){
			$newpage->template_id = $template_id;
		} else {
			$parent = ORM::Factory('page')->find($id);
			if($parent->template->default_add_category == NULL){
				die('no default add category for this category');
			}
			$newpage->template_id = $parent->template->default_add_category;
		}
		//create slug
		if(isset($data['title'])){
			$newpage->slug = cms::createSlug($data['title'], $newpage->id);
		} else {
			$newpage->slug = cms::createSlug();
		}
		$newpage->parentid = $id;
		$newpage->save();
	

		//check for enabled publish/unpublish. 
		//if not enabled, insert as published
		if(!Kohana::config('cms.templates.'.$newpage->template->templatename.'.allow_toggle_publish')){
			$newpage->published = 1;
		}
		$newpage->save();

		//Add defaults to content table
		$newtemplate = ORM::Factory('template', $newpage->template_id);
		/*
		 * this little tidbit is no longer supported
		 * the idea was to be able to configure content defaults on adding
		 * not really used too often
		 */
		/*
		$contentDefaults = Kohana::config('cms.templates.'.$newpage->template->templatename.'.defaults');
		if(is_array($contentDefaults) && count($contentDefaults)){
			foreach($contentDefaults as $field=>$value){
				$newpage->contenttable->$field = $value;
			}
			$newpage->contenttable->save();
		}
		 */

		//add submitted data to content table
		foreach($data as $field=>$value){
			$newpage->contenttable->$field = $data[$field];
		}
		$newpage->contenttable->save();

		//look up any components and add them as well

		//configured components
		$components = mop::config('backend', sprintf('//template[@name="%s"]/component',$newtemplate->templatename));
		foreach($components as $c){
			$template = ORM::Factory('template', $c->getAttribute('templateId'));
			if($c->hasChildNodes()){
				foreach($c->childNodes as $data){
					$arguments[$data->name] = $data->value;
				}
			}
			$this->__addObject($newpage->id, $newtemplate->id, $arguments);
		}

		//containers (list)
		$containers = mop::config('backend', sprintf('//template[@name="%s"]/elements/list',$newtemplate->templatename));
		foreach($containers as $c){
			$template = ORM::Factory('template', $c->getAttribute('family'));
			$arguments['title'] = $c->getAttribute('label');
			$this->__addObject($newpage->id, $template->id, $arguments);
		}

		return $newpage->id;
	}


	/*
		Function: togglePublish
		Toggles published / unpublished status via ajax. Call as cms/ajax/togglePublish/{id}/
		Parameters:
		id - the id to toggle
		Returns: Published status (0 or 1)
		*/
		public function togglePublish($id){
			$page = ORM::Factory('page')->find($id);
			if($page->published==0){
				$page->published = 1;
			} else {
				$page->published = 0;
			}
			$page->save();

			return $page->published;
		}

		/*
		Function: saveSortOrder
		Saves sort order of some ids
		Parameters:
		$_POST['sortorder'] - array of page ids in their new sort order
		*/
		public function saveSortOrder(){
			$order = explode(',', $_POST['sortorder']);

			for($i=0; $i<count($order); $i++){
				if(!is_numeric($order[$i])){
					throw new Kohana_User_Exception('bad sortorder string', 'bad sortorder string');
				}
				$page = ORM::factory('page', $order[$i]);
				$page->sortorder = $i+1;
				$page->save();
			}

			return 1;
		}

		/*
		 Function: delete
		 deletes a page/category and all categories and leaves underneath
		 Returns: returns html for undelete pane 
		*/
		public function delete($id){
			$this->cascade_delete($id);

			$this->view = new View('cms_undelete');
			$this->view->id=$id;
			return $this->view->render();
		}


		/*
		 Function: undelete
		 Undeletes a page/category and all categories and leaves underneath

		 Returns: 1;
		*/
		public function undelete($id) {
			$this->cascade_undelete($id);
			//should return something about failure...
			return 1;
		}

	
	/*
	 * Function: cascade_delete($id)
	 * Private utility to recursively delete and object and everything beneath a node
	 * Parameters:
	 * id - the id to delete as well as everything beneath it.
	 * Returns: nothing 
	 */
	private function cascade_delete($id){
		$page = ORM::Factory('page')->find($id);
		$page->activity = 'D';
		$page->sortorder = 0;
		$page->slug = null;
		$page->save();
		$page->contenttable->activity = 'D';
		$page->contenttable->save();

		$children = ORM::Factory('page');
		$children->where('parentid = '.$id);
		$iChildren = $children->find_all();
		foreach($iChildren as $child){
			$this->cascade_delete($child->id);
		}
	}

	/*
	 * Function: cascade_undelete($id)
	 * Private utility to recursively undelete and object and everything beneath a node
	 * Parameters:
	 * id - the id to undelete as well as everything beneath it.
	 * Returns: Nothing
	 */
	private function cascade_undelete($page_id){
		$page = ORM::Factory('page')->find($id);
		$page->activity = 'NULL';
		$page->slug = cms::createSlug($page->contenttable->title, $page->id);
		$page->save();
		$page->contenttable->activity = 'NULL';
		$page->contenttable->save();

		$children = ORM::Factory('page');
		$children->where('parentid = '.$id);
		$iChildren = $children->find_all();
		foreach($iChildren as $child){
			$this->cascade_undelete($child->id);
		}

	}

	public function regenerateImages(){
		//find all images
		//calculate resize array for images
		$uiimagesize = array('uithumb'=>Kohana::config('cms.uiresize'));
		$parameters['imagesizes'] = $uiimagesize;

		foreach(Kohana::config('cms.templates') as $templatename => $templateconfig){
			foreach($templateconfig as $field){
				if($field['type'] == 'singleImage'){
					$objects = ORM::Factory('template', $templatename)->getPublishedMembers();
					$fieldname = $field['field'];
					foreach($objects as $object){
						if( $object->contenttable->$fieldname->filename && file_exists(cms::mediapath() . $object->contenttable->$fieldname->filename)){
							$this->processImage($object->contenttable->$fieldname->filename, $parameters);
						}
					}
				}
			}
		}
	}


}

?>
