<?
/**
 * Class: CMS_Controller
 * The main CMS class, handling add, delete, and retrieval of pages
 * @author Matthew Shultz
 * @version 1.0
 * @package Kororor
 */


class CMS_Controller extends CMS_Interface_Controller {

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
	public function __construct(){
		parent::__construct();

		$this->modules = Kohana::config('cms.subModules');

	}

	public function createIndexView(){
		parent::createIndexView();
		if(Auth::instance()->logged_in('superuser')){
			$this->view->userlevel = 'superuser';
		} else {
			$this->view->userlevel = 'basic';
		}	
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
	public function getPage($id){
		
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
		$this->nodetitle->loadResources();
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
    	$htmlChunks = cms::buildUIHtmlChunksForObject($page);

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
	 * Function: associate
	 * Associate an object to another object
	 */
	public function associate($objectId){
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
	public function addObject($id, $template_id, $title=null){
		$data = $_POST;

		if($title){
			$data['title'] = $title;
		}
		$newid = cms::addObject($id, $template_id, $data);

		//Dial up associated navi and ask for details
		$nav_controller = ucfirst($this->modules['navigation']).'_Controller';
		$nav_controller = new $nav_controller();
		return $nav_controller->getNode($newid);
	}

	public function toWebpage(){

		//get the default 
		if(!self::$objectId){ //this allows for the controller to force it, 
			//but the below initialization should happen first in the future
			if(!count(Router::$arguments) || !Router::$arguments[0]){
				self::$objectId = null;
			} else {
				self::$objectId = Router::$arguments[0];
			}
		}

		$page = ORM::Factory('page', self::$objectId);
		self::$objectId = $page->id; //make sure we're storing id and not slug

		$this->view->objectId = $page->id;
		parent::toWebpage();
	}

}

?>
