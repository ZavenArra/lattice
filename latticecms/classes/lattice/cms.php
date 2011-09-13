<?
/**
 * Class: CMS_Controller
 * The main CMS class, handling add, delete, and retrieval of objects
 * @author Matthew Shultz
 * @version 1.0
 * @package Kororor
 */


class Lattice_CMS extends Lattice_CMSInterface {

		
	protected $_actionsThatGetLayout = array(
		'index',
	);


		/*
	*  Variable: object_id
	*  static int the global object id when operating within the CMS submodules get the object id
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

	protected $defaultobjectType='lattice_cms';

	/*
		Function: __constructor
		Loads subModules to build from config	
	*/
	public function __construct($request, $response){
		parent::__construct($request, $response);
     
		$this->modules = Kohana::config('cms.subModules');

		$this->loadResources('lattice_cms');

		lattice::config('objects', 'objectTypes');

	}

	public function getRootNode(){
		throw new Kohana_Exception('Child class must implement getRootNode()');
	}

	public function action_index(){
		$this->view = new View('lattice_cms');
		if(Auth::instance()->logged_in('superuser')){
			$this->view->userlevel = 'superuser';
		} else {
			$this->view->userlevel = 'basic';
		}	
      
      
		//get the root noode

		$rootObject = $this->getRootObject();
		$this->view->rootObjectId = $rootObject->id;
      
		
		//basically this is an issue with wanting to have multiple things going on
		//with the same controller as a parent at runtime
		$this->view->navigation = Request::factory(Kohana::config($this->controllerName.'.navigationRequest'))->execute()->body();

		//get all the languages
		$languages = ORM::Factory('language')->find_all();
		$this->view->languages = $languages;
		
		$this->response->body($this->view->render());
		//$this->outputLayout();  //consider using AFTER for this, but need to know whats up with ajax, etc
		//can we route through a layout controller???
	}

	/*
	 * Function: setPageId($object_id)
	 * Sets the object id of the object currently being edited
	 * Parameters:
	 * object_id  - the object id
	 * Returns: nothing 
	 */
	private function setPageId($object_id){
		if(self::$objectId == NULL){
			self::$objectId = $object_id;
		}
	}

	/*
	 * Function: getPageId() 
	 * Returns the object id of the object currently being edited
	 * Parameters: none
	 * Returns: object id
	 */
	public static function getPageId(){
		return self::$objectId;
	}

	/*
	Function: getPage(id)
	Builds the editing object for the object currenlty being edited
	Parameters: 
	id - the object id to be retrieved
	Returns: array('html'=>html, 'js'=>js, 'css'=>css)
	*/
	public function action_getPage($id, $languageCode = null){

      if(!$languageCode){
   		$object = Graph::object($id);
      } else {
         $object = Graph::object($id)->translate($languageCode);
      }

		self::$objectId = $id;


      /*
       * If the request is actually for a module, instead of a object, build
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
      
      
		
		if($object->id == 0){
			throw new Kohana_Exception('Invalid Page Id '.$id);
		}
		
		//new generation of object
		//1 grap cms_nodetitle
		$this->nodetitle = new View('lattice_cms_nodetitle');
		$this->nodetitle->title = $object->contenttable->title; //this should change to object table
		$this->nodetitle->slug = $object->slug;
		$this->nodetitle->id = $object->id;
		$this->nodetitle->allowDelete = $object->objecttype->allowDelete;
		$this->nodetitle->allowTitleEdit = ($object->objecttype->allowTitleEdit == "true" ? true : false);


		$settings = Kohana::config('cms.defaultsettings');
		if(is_array($settings)){
			foreach($settings as $key=>$value){
				$this->nodetitle->$key = $value;
			}
		}
		//and get settings for specific objectType
		$settings = Kohana::config('cms.'.$object->objecttype->objecttypename.'.defaultsettings');
		if(is_array($settings)){
			foreach($settings as $key=>$value){
				$this->nodetitle->$key = $value;
			}
		}
      if($languageCode){
         $this->nodetitle->translationModifier = '_'.$languageCode;
      } else {
         $this->nodetitle->translationModifier = '';
      }
		
		$nodetitlehtml = $this->nodetitle->render();

		$customview = 'objectTypes/'.$object->objecttype->objecttypename; //check for custom view for this objectType
		$htmlChunks = latticecms::buildUIHtmlChunksForObject($object, $languageCode);

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

		$this->response->data($object->getPageContent());	
		$this->response->body($html);

	}
   
   
   public function action_getTranslatedPage($objectId, $languageCode){
      return $this->action_getPage($objectId, $languageCode);
   }

	public function action_addchild($id, $objecttype_id){
		$data = $_POST;

    //add the file keys in so that we can look them up in the FILES array laster
    //consider just combining POST and FILES here
    $fileKeys = array_keys($_FILES);
    foreach($fileKeys as $fk){
      $data[$fk] = null; 
    }
    Kohana::$log->add(Log::INFO, var_export($data, true));
    Kohana::$log->add(Log::INFO, var_export($_FILES, true));
		$newId = Graph::object($id)->addObject($objecttype_id, $data);
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
	objecttype_id - the type of object to add
	title - optional title for initialization
	$_POST - possible array of keys and values to initialize with
	Returns: nav controller node object
	*/
	public function action_addObject($parentId, $objectTypeId){      
      $newId = $this->cms_addObject($parentId, $objectTypeId, $_POST);
      $this->response->data( $this->cms_getNodeInfo($newId) );	
      $this->response->body( $this->cms_getNodeHtml($newId));
	
   }
   
	public function assignObjectId(){

   }

   
  
}

?>
