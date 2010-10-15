<?
/*
 * Class: Site_Controller
 * Responsible for handing default behaviour of CMS driven sites,
 * using slugs or ids to navigate between pages.  Works hand in
 * hand with the slugs hook
 */
Class Site_Controller extends Controller{

	/*
	 * Variable: $content
	 * Holds the content for a page
	 */
	protected $content = array();

	/*
	 * Function: index
	 * Wrapper to page that uses the controller as the slug
	 */
	public function index(){
		$this->page(substr(get_class($this), 0, -11));
	}

	public function createIndexView(){
		$this->page(substr(get_class($this), 0, -11));
	}


	/*
	 * Function: page($pageidorslug)
	 * By default called after a rewrite of routing by slugs hooks, gets all content
	 * for an object and loads
	 * Parameters:
	 * $pageidorslug - the id or slug of the object to display, null is allowed but causes exception
	 * Returns: nothing, renders full webpage to browser or sents html if AJAX request
	 */
	public function page($pageidorslug=null) {

		/*
		$newConfig = $configArray;
		$newConfig['views'] = array();
		foreach($configArray['views'] as $view){
			$newConfig['views'][$view['view']] = $view;	
		}
		$configArray = $newConfig;
		 */



		$page = ORM::Factory('page', $pageidorslug);
		//some access control
		$viewName = null;
		if($page->loaded){
			if($page->published==false || $page->activity!=null){
				throw new Kohana_User_Exception('Page not availabled', 'The page with identifier '.$id.' is does not exist or is not available');
			}
      //look for the template, if it's not there just print out all the data raw
      $viewName = $page->template->templatename;
      if(!file_exists('application/frontend/'.$viewName.'.php')){
				$viewName = 'default';
			}
			$this->view = new View( $viewName );

    
		} else {
			//check for a virtual page specified in frontend.yaml
			//a virtual page will be one that does not match a template
			$viewname = $pageidorslug;
			$this->view = new View( $viewname );
		}

		//call this->view load data
		//get all the data for the page
		$viewContent = mop::getViewContent($viewName, $pageidorslug);
		foreach($viewContent as $key=>$content){
			$this->view->$key = $content;
		}	


		//possible hook for processing content	


		if($this->responseFormat=='AJAX'){
			return $this->view->render();
		} else {
			$customDisplayController = null;
			if( Kohana::find_file('config', $page->slug)){
				if( Kohana::config($page->slug.'.displaycontroller')){
					$customDisplayController = Kohana::config($page->slug.'.displaycontroller');
				}
			}
			$this->toWebpage($customDisplayController);
		}
	}




}
