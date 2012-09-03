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

  public function __construct($request, $response){
    parent::__construct($request, $response);
  }

  /*
   * Function: after
   * Calculate layout wrapping for slug
   * Setting latticeviews.layouts.$slug to a layout name will load slug within that layout
   * if there is no view file available for that name, no wrapping occurs
   */
	public function after(){
		if($this->request == Request::initial() ){
      $layoutForSlug = Kohana::config('latticeviews.layouts.'.self::$slug);
      $object = Graph::object(self::$slug);
      $layoutForObjectType = Kohana::config('latticeviews.layoutsForObjectType.'.$object->objecttypename);
      if($layoutForSlug){
        if(Kohana::find_file('views/', $layoutForSlug)){
          $this->wrapWithLayout($layoutForSlug); 
        }
      } else if($layoutForObjectType){
        if(Kohana::find_file('views/', $layoutForObjectType)){
          $this->wrapWithLayout($layoutForObjectType); 
        }
      } else {
        parent::after();
      }
		
		}
	}

	/*
	 * Function: index
	 * Wrapper to object that uses the controller as the slug
	 */
	public function action_index(){
		$this->action_object(substr(get_class($this), 0, -11));
	}


	/*
	 * Function: object($objectIdOrSlug)
	 * By default called after a rewrite of routing by slugs hooks, gets all content
	 * for an object and loads view
	 * Parameters:
	 * $objectIdOrSlug - the id or slug of the object to display, null is allowed but causes exception
	 * Returns: nothing, renders full webobject to browser or sents html if AJAX request
	 */

	public function action_getView($objectIdOrSlug=null) {

		$access = Kohana::config('latticeviews.access.'.$objectIdOrSlug);
		if(!latticeutil::checkAccess($access)){
			Request::current()->redirect(url::site('auth/login/',Request::current()->protocol(),false).'/'.Request::initial()->uri());
		}

		self::$slug = $objectIdOrSlug;

		if(Session::instance()->get('languageCode')){
			$object = Graph::object($objectIdOrSlug);
			if(!$object->loaded()){
				if(!$objectIdOrSlug){
					$objectIdOrSlug = 'No object id or slug specified';
				}
				throw new Kohana_Exception('No object found for id: '.$objectIdOrSlug);
			}
			$translatedObject = $object->translate(Session::instance()->get('languageCode'));
			$objectIdOrSlug = $translatedObject->id;
		}

		$this->viewModel = latticeview::Factory($objectIdOrSlug);

		//possible hook for processing content	

		$this->response->body($this->viewModel->view()->render());
		$this->response->data($this->viewModel->data());


	}


	public function action_getVirtualView($viewName){

		$this->view = new latticeview($viewName);

		//possible hook for processing content	

		$this->response->body($this->view->render());

	}



}
