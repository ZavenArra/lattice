<?
require('/home/deepwinter/dev/deepwinter/yaml/lib/sfYaml.php');
require('/home/deepwinter/dev/deepwinter/yaml/lib/sfYamlParser.php');
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

		$yaml = new sfYamlParser();
		try {
			$configArray = $yaml->parse(file_get_contents('application/config/frontend.yaml'));
		}
		catch (InvalidArgumentException $e) {
			// an error occurred during parsing
			echo "Unable to parse the YAML string: ".$e->getMessage();
			flush();
			ob_flush();
			exit;
		}
		$newConfig = $configArray;
		$newConfig['views'] = array();
		foreach($configArray['views'] as $view){
			$newConfig['views'][$view['view']] = $view;	
		}
		$configArray = $newConfig;




		$page = ORM::Factory('page', $pageidorslug);
		//some access control
		if($page->loaded){
			if($page->published==false || $page->activity!=null){
				throw new Kohana_User_Exception('Page not availabled', 'The page with identifier '.$id.' is does not exist or is not available');
			}

			//keep this first line for backwards compatibility
			$this->content = array_merge($this->content, $page->getPageContent());
			//but this is the real deal
			$this->content['main'] = $page->getPageContent();

      //look for the template, if it's not there just print out all the data raw
      $view = 'site/'.$page->template->templatename;
      if(Kohana::find_file('views', $view)){
        $this->view = new View( 'site/'.$page->template->templatename);
      } else {
        $this->view = new View( 'site/default');
      }

      $this->view->content = $this->content;

		} else {
			//check for a virtual page specified in frontend.yaml
			if(!isset($configArray['views'][$page->template->templatename])){
				throw new Kohana_User_Exception('Page not availabled', 'The page with identifier '.$id.' is does not exist or is not available');
			}
		}

				//look for the template, if it's not there just print out all the data raw
		if(!$this->template){
			$this->template = new View( 'site/default');
		}


		$this->template->content = $this->content;
		
		if(isset($configArray['views'][$page->template->templatename])){
			foreach($configArray['views'][$page->template->templatename]['extendeddata'] as $edata){
				
				$objects = ORM::Factory('page');

				//apply optional parent filter
				if(isset($edata['parent'])){
					$parent = ORM::Factory('page', $edata['parent']);
					$objects->where('parentid', $parent->id);	
				}

				//apply optional template filter
				if(isset($edata['templatename'])){
					if(is_array($edata['templatename'])){
						$tIds = array();
						foreach($edata['templatename'] as $tname){
							$t = ORM::Factory('template', $edata['templatename']);
							$tIds[] = $t->id;
						}
						$objects->in('template_id', $tIds);
					} else if ($edata['templatename'] == 'all'){
						//set no filter
					} else {
						$t = ORM::Factory('template', $edata['templatename']);
						$objects->where('template_id', $t->id);
					}
				}
				$objects = $objects->find_all();

				//apply optional SQL where filter
				if(isset($edata['where'])){
					$objects->where($edata['where']);
				}

				$this->template->content[$edata['label']] = array();
				foreach($objects as $object){
					$this->template->content[$edata['label']][] = $object->getContent();
				}
			}

			if(isset($configArray['views'][$page->template->templatename]['subviews'])){
				foreach($configArray['views'][$page->template->templatename]['subviews'] as $subview){
					$this->buildModule(array('modulename'=>$subview['view']/*, 'controllertype'=>'object'*/), $subview['label']);
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

	/*
	 * Function: getChildrenContent($pageid, & $content)
	 * Deprecated function to load content of children.  Use $page->getPublishedChildren() instead
	 */
	public function getChildrenContent($pageid, & $content){
		$page = ORM::Factory('page', $pageid);
		$pages = $page->getPublishedChildren;

		$content = array();
		foreach($pages as $page){
			$pagecontent = $page->getPageContent();
			$content[$page->slug] = $pagecontent;
		}
	}


	/*
	 * Function: getContentsByPageId($pageid)
	 * Deprecated function used to build content array for a given page.
	 * The correct way to do this now is to call getPageContent on a loaded Page model
	 */
	protected function getContentsByPageId($pageid){
		return ORM::Factory('page', $pageid)->getPageContent();
	}

	/*
	 * Function: getContentsByPageIdentifier($pageid)
	 * Deprecated function used to build content array for a given page.
	 * The correct way to do this now is to call getPageContent on a loaded Page model
	 */
	protected function getContentsByPageIdentifier($identifier){
		return ORM::Factory('page', $pageid)->getPageContent();
	}

	/*
	 * Function: getListData($instance, $pagid=null)
	 * Deprecated function used to build content array for a given list.
	 * The correct way to do this now is to call getListData a loaded Page model
	 * Soon we'll get away from the page vs. list content and this function will
	 * completely disappear
	 */
	protected function getListData($instance, $pageid){
			return ORM::Factory('page', $pageid)->getListData();
	}

}
