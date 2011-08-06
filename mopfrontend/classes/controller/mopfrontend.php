<?
/*
 * Class: Site_Controller
 * Responsible for handing default behaviour of CMS driven sites,
 * using slugs or ids to navigate between objects.  Works hand in
 * hand with the slugs hook
 */
Class Controller_MopFrontend extends Controller_Layout{

  protected $_actionsThatGetLayout = array(
    'getView',
  );
   
	public static $slug;

	/*
	 * Variable: $content
	 * Holds the content for a object
	 */
	protected $content = array();

	/*
	 * Function: index
	 * Wrapper to object that uses the controller as the slug
	 */
	public function action_index(){
		$this->action_object(substr(get_class($this), 0, -11));
	}
        
        public function validSlug($uri){
            
            echo 'made it here!!!';
        }

	

	/*
	 * Function: object($objectidorslug)
	 * By default called after a rewrite of routing by slugs hooks, gets all content
	 * for an object and loads view
	 * Parameters:
	 * $objectidorslug - the id or slug of the object to display, null is allowed but causes exception
	 * Returns: nothing, renders full webobject to browser or sents html if AJAX request
	 */

	public function action_getView($objectidorslug=null) {
	
		$access = Kohana::config('mopfrontend.access.'.$objectidorslug);
		if(!moputil::checkAccess($access)){
			Request::current()->redirect(url::site('auth/login/',Request::current()->protocol(),false).'/'.Request::initial()->uri());
		}

		self::$slug = $objectidorslug;

      $object = Graph::object($objectidorslug);
		//some access control
		$viewName = null;
		if ($object->loaded()) {
			if ($object->published == false || $object->activity != null) {
				throw new Kohana_User_Exception('Page not availabled', 'The object with identifier ' . $id . ' is does not exist or is not available');
			}
			//look for the objectType, if it's not there just print out all the data raw
			$viewName = $object->objecttype->objecttypename;
			if (file_exists('application/views/frontend/' . $viewName . '.php')) {
				$viewPath = 'frontend/'.$viewName;
			} else if(file_exists('application/views/generated/' . $viewName . '.php')) {
				$viewPath = 'generated/'.$viewName;
			} else {
				$viewPath = 'default';
			}
			$this->view = new View($viewPath);
		} else {
			//check for a virtual object specified in frontend.xml
			//a virtual object will be one that does not match a objectType
			$viewName = $objectidorslug;
			$this->view = new View('frontend/'.$viewName);
		}

		//call this->view load data
		//get all the data for the object
		$viewContent = mop::getViewContent($viewName, $objectidorslug);
		foreach ($viewContent as $key => $value) {
			$this->view->$key = $value;
		}

		//possible hook for processing content	

		$this->response->body($this->view->render());

	
    }




}
