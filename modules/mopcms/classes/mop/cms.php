<?
/**
 * Class: CMS_Controller
 * The main CMS class, handling add, delete, and retrieval of pages
 * @author Matthew Shultz
 * @version 1.0
 * @package Kororor
 */


class MOP_CMS extends MOP_CMSInterface {

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
	private $model = 'page';

	/*
	*
	* Variable: modules
	* Build the cms's included modules
	*
	*/
	public $subModules =  array();



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
	 * Function: setPageId($page_id)
	 * Sets the page id of the object currently being edited
	 * Parameters:
	 * page_id  - the page id
	 * Returns: nothing 
	 */
	private function setPageId($page_id){
		if(self::$objectId == NULL){
			self::$objectId = $page_id;
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


		$controller = $id;
		if(Kohana::find_file('controllers', $controller)){
			$controller = $id.'_Controller';
			$controller = new $controller;
			$controller->createIndexView();
			$return = array();
			$return['html']= $controller->render();
			$return['css'] = array_values(array_merge($controller->view->resources['librarycss'], $controller->view->resources['css']));
			$return['js'] = array_values(array_merge($controller->view->resources['libraryjs'], $controller->view->resources['js']));
			return $return;
		}
		
		$page = ORM::factory('page', $id);
		if($page->id == 0){
			throw new Kohana_User_Exception('Invalid Id', 'Invalid Page Id '.$id);
		}
		
		//new generation of page
		//1 grap cms_nodetitle
		$this->nodetitle = new View('mop_cms_nodetitle');
		$this->nodetitle->title = $page->contenttable->title; //this should change to page table
		$this->nodetitle->slug = $page->slug;
		$this->nodetitle->allowDelete = $page->template->allowDelete;
		$this->nodetitle->allowTitleEdit = ($page->template->allowTitleEdit == "true" ? true : false);

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
    	$htmlChunks = mopcms::buildUIHtmlChunksForObject($page);

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


	/*
	 * Function: associate
	 * Associate an object to another object
	 */
	public function function_associate($objectId){
		//gotta issue here
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
	public function function_addObject($id, $template_id, $title=null){
		$data = $_POST;

		if($title){
			$data['title'] = $title;
		}
		$newid = mopcms::addObject($id, $template_id, $data);

		//Dial up associated navi and ask for details
		$nav_controller = ucfirst($this->modules['navigation']).'_Controller';
		$nav_controller = new $nav_controller();
		return $nav_controller->getNode($newid);
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

		$page = ORM::Factory('page', self::$objectId);
		self::$objectId = $page->id; //make sure we're storing id and not slug

		$this->view->objectId = $page->id;
	}

}

?>
