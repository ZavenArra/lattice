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
		if($page->loaded){
			if($page->published==false || $page->activity!=null){
				throw new Kohana_User_Exception('Page not availabled', 'The page with identifier '.$id.' is does not exist or is not available');
			}
      //look for the template, if it's not there just print out all the data raw
      $view = $page->template->templatename;
      if(file_exists('application/frontend/'.$view.'.php')){
        $this->view = new View( $view);
      } else {
        $this->view = new View( 'default');
      }

      $this->view->content = $this->content;

			//keep this first line for backwards compatibility
			$this->content = array_merge($this->content, $page->getPageContent());
			//but this is the real deal
			$this->content['main'] = $page->getPageContent();


		} else {
			//check for a virtual page specified in frontend.yaml
			if(! mop::config('frontend', "/view/{$page->template->templatename}")){
				throw new Kohana_User_Exception('Page not availabled', 'The page with identifier '.$id.' is does not exist or is not available');
			}
		}

		//call this->view load data
		
		if($eDataNodes = mop::config('frontend',"//view[@name=\"{$page->template->templatename}\"]/includeData")){
			foreach($eDataNodes as $eDataConfig){
				
				$objects = ORM::Factory('page');

				//apply optional parent filter
				if($from = $eDataConfig->getAttribute('from')){
					if($from=='parent'){
						$objects->where('parentid', $page->id);
					} else {
						$from = ORM::Factory('page', $from);
						$objects->where('parentid', $from->id);	
					}
				}

				//apply optional template filter
				$objects->templateFilter($eDataConfig->getAttribute('templateName'));


				//apply optional SQL where filter
				if($where = $eDataConfig->getAttribute('where')){
					$objects->where($where);
				}

				$objects = $objects->find_all();

				$this->view->content[$eDataConfig->getAttribute('label')] = array();
				foreach($objects as $object){
					$this->view->content[$eDataConfig->getAttribute('label')][] = $object->getContent();
				}
			}
		}

		if($subViews = mop::config('frontend',"//view[@name=\"{$page->template->templatename}\"]/subView")){
				foreach($subViews as $subview){
					$view = $subview->getAttribute('view');
					$label = $subview->getAttribute('label');
					$this->view->$label = mop::buildModule(array('modulename'=>$view/*, 'controllertype'=>'object'*/), $subview->getAttribute('label'));
				}
			}
		}


		


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



	/*
	 * Function: __buildPageContent($content, $page)
	 * Deprecated function used to build content array for a given page.
	 * The correct way to do this now is to call getPageContent on a loaded Page model
	 * */
	protected function __buildPageContent(& $content, & $page){
		if (is_array($content))
			$content = array_merge($content, $page->getPageContent());
		else
			$content = $page->getPageContent();
		return;
	}


}
