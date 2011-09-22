<?
/*
 * Class: Site_Controller
 * Responsible for handing default behaviour of CMS driven sites,
 * using slugs or ids to navigate between objects.  Works hand in
 * hand with the slugs hook
 */
Class Controller_LatticeViews extends Controller_Layout{

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


	/*
	 * Function: object($objectidorslug)
	 * By default called after a rewrite of routing by slugs hooks, gets all content
	 * for an object and loads view
	 * Parameters:
	 * $objectidorslug - the id or slug of the object to display, null is allowed but causes exception
	 * Returns: nothing, renders full webobject to browser or sents html if AJAX request
	 */

	public function action_getView($objectidorslug=null) {

		$access = Kohana::config('latticeviews.access.'.$objectidorslug);
		if(!latticeutil::checkAccess($access)){
			Request::current()->redirect(url::site('auth/login/',Request::current()->protocol(),false).'/'.Request::initial()->uri());
		}

		self::$slug = $objectidorslug;

		$this->view = latticeviews::createView($objectidorslug);

		//possible hook for processing content	

		$this->response->body($this->view->render());


	}


	public function action_getVirtualView($viewName){

		$this->view = latticeviews::createVirtualView($viewName);

		//possible hook for processing content	

		$this->response->body($this->view->render());

	}



}
