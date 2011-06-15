<?
/**
 * Class: CMS_Controller
 * The main CMS class, handling add, delete, and retrieval of pages
 * @author Matthew Shultz
 * @version 1.0
 * @package Kororor
 */


class MOP_CMS extends MOP_CMSInterface {

		
	protected $_actionsThatGetLayout = array(
		'index',
	);


		/*
	*  Variable: page_id
	*  static int the global page id when operating within the CMS submodules get the page id
	*  we could just reference the primaryId attribute of Display as well...
	*/
	private static $objectId = NULL;


	/*
	 * Variable: unique
	 * Used to provide unique ids for radio buttons and other input elements
	 */
	private static $unique = 1;

	/*
		Variable: model
		The main data model for content stored by this module
	*/
	private $model = 'object';

	/*
	*
	* Variable: modules
	* Build the cms's included modules
	*
	*/

	protected $defaulttemplate='mop_cms';

	/*
		Function: __constructor
		Loads subModules to build from config	
	*/
	public function __construct($request, $response){
		parent::__construct($request, $response);
     
		$this->modules = Kohana::config('cms.subModules');

		$this->loadResources('mop_cms');

	}

	public function action_index(){
		$this->view = new View('mop_cms');
		if(Auth::instance()->logged_in('superuser')){
			$this->view->userlevel = 'superuser';
		} else {
			$this->view->userlevel = 'basic';
		}	
		$this->assignObjectId();

		
		//basically this is an issue with wanting to have multiple things going on
		//with the same controller as a parent at runtime
		$this->view->navigation = Request::factory(Kohana::config($this->controllerName.'.navigationRequest'))->execute()->body();

		
		$this->response->body($this->view->render());
		//$this->outputLayout();  //consider using AFTER for this, but need to know whats up with ajax, etc
		//can we route through a layout controller???
	}

	/*
	 * Function: setPageId($object_id)
	 * Sets the page id of the object currently being edited
	 * Parameters:
	 * page_id  - the page id
	 * Returns: nothing 
	 */
	private function setPageId($object_id){
		if(self::$objectId == NULL){
			self::$objectId = $object_id;
		}
	}

	/*
	 * Function: getPageId() 
	 * Returns the page id of the object currently being edited
	 * Parameters: none
	 * Returns: page id
	 */
	public static function getPageId(){
		return self::$objectId;
	}

	/*
	Function: getPage(id)
	Builds the editing page for the object currenlty being edited
	Parameters: 
	id - the page id to be retrieved
	Returns: array('html'=>html, 'js'=>js, 'css'=>css)
	*/
	public function action_getPage($id){
		
		self::$objectId = $id;


      /*
       * If the reqeuest is actually for a module, instead of a page, build
       * the subrequest and set the response body to the request.
       * This should probably be re-engineered to be handled by the navi
       * module only, and cmsModules.xml should also be a navi thing
       * since only the navi needs to know about the modules being loaded as long
       * as the reciever (CMS in this case) has an appropriate container.
       */
		$controller = $id;
		if(Kohana::find_file('classes/controller', $controller)){   
         $route = Request::Factory($controller);
         $this->response->body( $route->execute()->body() );
         return;
		}
      
      
		
		$object = ORM::factory('object', $id);
		if($object->id == 0){
			throw new Kohana_Exception('Invalid Page Id '.$id);
		}
		
		//new generation of page
		//1 grap cms_nodetitle
		$this->nodetitle = new View('mop_cms_nodetitle');
		$this->nodetitle->title = $object->contenttable->title; //this should change to page table
		$this->nodetitle->slug = $object->slug;
		$this->nodetitle->allowDelete = $object->template->allowDelete;
		$this->nodetitle->allowTitleEdit = ($object->template->allowTitleEdit == "true" ? true : false);

		$settings = Kohana::config('cms.defaultsettings');
		if(is_array($settings)){
			foreach($settings as $key=>$value){
				$this->nodetitle->$key = $value;
			}
		}
		//and get settings for specific template
		$settings = Kohana::config('cms.'.$object->template->templatename.'.defaultsettings');
		if(is_array($settings)){
			foreach($settings as $key=>$value){
				$this->nodetitle->$key = $value;
			}
		}
		
		$nodetitlehtml = $this->nodetitle->render();

		$customview = 'templates/'.$object->template->templatename; //check for custom view for this template
    	$htmlChunks = mopcms::buildUIHtmlChunksForObject($object);

		$usecustomview = false;
		if(Kohana::find_file('views', $customview)){
			$usecustomview = true;	
		}
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

	
		$this->response->body($html);

	}

	public function action_addchild($id, $template_id){
		$data = $_POST;

    //add the file keys in so that we can look them up in the FILES array laster
    //consider just combining POST and FILES here
    $fileKeys = array_keys($_FILES);
    foreach($fileKeys as $fk){
      $data[$fk] = null; 
    }
    Kohana::$log->add(Log::INFO, var_export($data, true));
    Kohana::$log->add(Log::INFO, var_export($_FILES, true));
		$newId = mopcms::addObject($id, $template_id, $data);
		$this->response->data($newId);
	}

	



	/*
	 * Function: associate
	 * Associate an object to another object
	 */
	public function action_associate($objectId){
		//gotta issue here
	}

	/*
	Function: action_addObject($id)
	Public interface for adding an object to the cms data
	Parameters:
	id - the id of the parent category
	template_id - the type of object to add
	title - optional title for initialization
	$_POST - possible array of keys and values to initialize with
	Returns: nav controller node object
	*/
	public function action_addObject($parentId, $templateId){
      
      $newId = $this->cms_addObject($parentId, $templateId, $_POST);
      return $this->cms_getNode($newId);	
	
   }
   
   public function cms_addObject($parentId, $templateId, $data) {
         
		$newid = Graph::object($id)->addObject($template_id, $data);

   }
   
   public function cms_getNode($id){
      
      //Dial up associated navi and ask for details
		$navigation = new Navigation();
		return $navigation->getNode($newid);
      
   }

	public function assignObjectId(){

		//get the default 
		if(!self::$objectId){ //this allows for the controller to force it, 
			//but the below initialization should happen first in the future
			if(!Request::initial()->param('id')){
				self::$objectId = null;
			} else {
				self::$objectId = Request::initial()->param('id');
			}
		}

		$object = ORM::Factory('object', self::$objectId);
		self::$objectId = $object->id; //make sure we're storing id and not slug

		$this->view->objectId = $object->id;
	}

}

?>
