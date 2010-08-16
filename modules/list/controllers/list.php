<?
/*
	Class: ListModule_Controller
	Not doing a 2nd pass on this for documentation, since it's very near to being reimplemented with
	object paradigm.
*/

class List_Controller extends Controller{

	/*
	*  Variable: page_id
	*  static int the global page id when operating within the CMS submodules get the page id
	*  we could just reference the primaryId attribute of Display as well...
	*/
	private static $page_id = NULL;


	/*
	Variable: model
	Main model for items content managed by this class
	*/
	protected $model = 'page'; 

	/*
	 * Variable: containerObject
	 * The parent object of the lists children
	 */
	protected $containerObject;


	/*
	  Function:  construct();
		Parameters:
			containerObject - The object that contains the items for the list.  This should not be null, 
			 but we allow it for call_user_func_array workaround
	*/
	public function __construct($containerObject = null){
		parent::__construct();

		$this->containerObject = $containerObject;

		//for now the isntance is just the name of this thing
		$this->listClass = strtolower(substr(get_class($this), 0, -11));

		//support for custom listmodule item templates, but might not be necessary
		$custom = $this->listClass.'_list_item';
		Kohana::log('info', 'list: looking for '.$custom);
		if(Kohana::find_file('views', $custom)){
			$this->itemview = $custom;
		} else {
			$this->itemview = 'list_item';
		}

		//get the dbmap
		if(! $this->sortdirection = Kohana::config('cms.lists.'.$this->listClass.'.sortdirection')) {
			$this->sortdirection = Kohana::config('list.sortdirection');
		}

		//TODO:read the config and setupd
	}


	public function createIndexView(){
		$custom = $this->listClass.'_list';
		if(Kohana::find_file('views', $custom)){
			$this->view = new View($custom);
		} else {
			$this->view = new View('list');		
		}

		$this->view->label = Kohana::config('cms.lists.'.$this->listClass.'.label'); //how do we know what object we are in

		$this->buildIndexData();
		return $this->render();
	}


	public function buildIndexData(){

		$listMembers = ORM::Factory('page', $this->containerObject->id)->getPublishedChildren();

		$html = '';
		foreach($listMembers as $object){

			$htmlChunks = cms::buildUIHtmlChunks(Kohana::config('cms.templates.'.$object->template->templatename.'.parameters'), $object);
			$itemt = new View($this->itemview);
			$itemt->uiElements = $htmlChunks;

			$data = array();
			$data['id'] = $this->containerObject->id;
			$data['page_id'] = $object->id;
			$data['instance'] = $this->listClass;
			$itemt->data = $data;

			$html.=$itemt->render();
		}
	
		$this->view->label = Kohana::config('cms.lists.'.$this->listClass.'.label');
		$this->view->class =  Kohana::config('cms.lists.'.$this->listClass.'.cssClasses') . ' sortDirection-'.$this->sortdirection;
		$this->view->items = $html;
		$this->view->instance = $this->listClass;

	}

	/*
	Function: saveIPE($itemid)
	Wrapper to saveIPE in CMS_Services_Controller
	*/
	public function saveFieldMapping($itemid){
		$object = ORM::Factory($this->model, $itemid);
		return $object->saveFieldMapping($_POST['field'], $_POST['value']);
	}

	//this is the new one
	public function saveField($itemid){
		$object = ORM::Factory($this->model, $itemid);
		return $object->saveField($_POST['field'], $_POST['value']);
	}



	/*
	Function: saveFile($itemid)
	Wrapper to saveFile in CMS_Services_Controller

	Parameters:
	$itemid - the id of the item that the file is attached to
	$_POST['field'] - the identifier of the file in this specific list instance 
	(same as a field for ipe)
	$_FILES - the uploaded file gets put here by php
	*/
	public function saveFile($itemid){
		$object = ORM::Factory($this->model, $itemid);

		//check the file extension
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
				$parameters = Kohana::config($this->listClass.'.singleimages.'.$_POST['field'].'.resize');
				$uiimagesize = array('uithumb'=>Kohana::config('listmodule.uiresize'));
				if($parameters){
				$parameters['imagesizes'] = array_merge($uiimagesize, $parameters['imagesizes']);
				} else {
					$parameters['imagesizes'] = $uiimagesize;
				}
				
				if($parameters){
					return $object->saveImage($_POST['field'], $_FILES, $parameters);
				} else {
					return $cmss->saveFile($_POST['field'], $_FILES);
				}
				break;

			default:
				return $cmss->saveFile($_POST['field'], $_FILES);
		}

		
	}

	public function saveMappedPDF($itemid){
		$object = ORM::Factory($this->model, $itemid);
		return $object->saveMappedPDF();
	}

	/*
	Function: addItem()
	Adds a list item

	Returns:
	the rendered template of the new item
	*/
	public function addItem($pageId){
		//read config, make the item, load template
		//config must load instance somehow
		$sort = ORM::Factory($this->model)
		->select('max(sortorder)+1 as newsort')
		->where('instance', $this->listClass)
		->find();

		//insert the collection record if it does not exist already
		$collection = ORM::Factory('collection')
			->where('listClass', $this->listclass)
			->find();
		if(!$collection->loaded){
			$collection = ORM::Factory('collection');
			$collection->listClass = $this->listclass;
			$collection->save();
		}
		
		$item = ORM::Factory($this->model);
		$item->page_id = $pageId;
		$item->collection_id = $collection->id;
		$item->save();

		//save fields into item
		foreach($this->fields as $field=>$type){
			if(isset($_POST[$field])){
				$item->$field = $_POST[$field];
			}
		}
		$item->sortorder = $sort->newsort;
		$item->save();

		//and get data
		$data = array();
		$data['id'] = $item->id;
		$data['page_id'] = $item->page_id;
		$data['instance'] = $item->instance;
		foreach($this->dbmap as $formfield => $dbfield){
			$data[$formfield] = $item->$dbfield;
		}


		$this->view = new View($this->itemview);
		$this->view->instance = $this->listClass;
		$this->view->data = $data;
		$this->view->fields = $this->fields;
		$this->view->labels = $this->labels;
		$this->view->files = array();

		if(count(Kohana::config($this->listClass.'.files'))){
			$this->view->files['file'] = $this->makeFileArgs('file');
		}
		$this->view->singleimages = array();
		if(count(Kohana::config($this->listClass.'.singleimages'))){
			$this->view->singleimages['file'] = $this->makeFileArgs('singleimage');
		}
		return $this->view->render();
	}

	public function makeFileArgs($type, $id=null){
		$maxlength = ini_get('upload_max_filesize');
		if(!strpos($maxlength, 'M')){
			throw new Kohana_User_Exception('invalid upload_max_filesize', 'invalid upload_max_filesize');
		}

		$maxlength = substr($maxlength, 0, -1) * 1024 *1024;
		$args = array();
		$args['id']=null;
		$args['ext'] = '';
		$args['maxlength'] = $maxlength;
		$args['extensions'] = Kohana::config($this->listClass.'.'.$type.'s'.'.file'.'.extensions');
		if($id==null){
			return $args;
		}	
		$file = ORM::Factory('file')->where('id', $id)->find(); //why is this find necessary?
		if($file->loaded==true){
			$args['id'] = $id; 
			$parse = explode('.', $file->filename);
			$args['ext'] = $parse[count($parse)-1];
			$args['filename'] = $file->filename;
			$thumbSrc = 'uithumb_'.$file->filename;
			if(!file_exists('staging/application/media/'.$thumbSrc)){
				$thumbSrc = $file->filename;
			} 
			$args['thumbSrc'] = $thumbSrc;
			$size = @getimagesize($thumbSrc);
			$args['width'] = $size[0];
			$args['height'] = $size[1];
		} 
		return $args;
	}

	/*
	Function: deleteItem()
	Deletes an item (marks as deleted, but does not remove from database. 
	also sets sortorder to 0)

	Parameters:
	$itemid - the id of thd item to delete
	*/
	public function deleteItem($itemid){
		$item = ORM::Factory($this->model, $itemid);
		$item->activity = 'D';
		$item->sortorder = 0;
		$item->save();
		return 1;

	}

	/*
	Function: saveSortOrder
	Saves sort order of some ids
	This is a candidate for going into cms_services, with generalization

	Parameters:
	$_POST['sortorder'] - comma delineated string of ids
	*/
	public function saveSortOrder(){
		$order = explode(',', $_POST['sortorder']);

		for($i=0; $i<count($order); $i++){
			if(!is_numeric($order[$i])){
				throw new Kohana_User_Exception('bad sortorder string', 'bad sortorder string');
			}
			$item = ORM::factory($this->model, $order[$i]);
			$item->sortorder = $i+1;
			$item->save();
		}

	}
}

?>
