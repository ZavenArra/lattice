<?
/*
 * Class: Site_Controller
 * Responsible for handing default behaviour of CMS driven sites,
 * using slugs or ids to navigate between pages.  Works hand in
 * hand with the slugs hook
 */
Class Controller_MopFrontend extends Controller_Layout{

	public static $slug;

	/*
	 * Variable: $content
	 * Holds the content for a page
	 */
	protected $content = array();

	/*
	 * Function: index
	 * Wrapper to page that uses the controller as the slug
	 */
	public function action_index(){
		$this->action_page(substr(get_class($this), 0, -11));
	}
        
        public function validSlug($uri){
            
            echo 'made it here!!!';
        }

	

	/*
	 * Function: page($pageidorslug)
	 * By default called after a rewrite of routing by slugs hooks, gets all content
	 * for an object and loads
	 * Parameters:
	 * $pageidorslug - the id or slug of the object to display, null is allowed but causes exception
	 * Returns: nothing, renders full webpage to browser or sents html if AJAX request
	 */

    public function action_page($pageidorslug=null) {

        self::$slug = $pageidorslug;

        $page = ORM::Factory('page')->where('slug', '=', $pageidorslug)->find();
        //some access control
        $viewName = null;
        if ($page->loaded()) {
            if ($page->published == false || $page->activity != null) {
                throw new Kohana_User_Exception('Page not availabled', 'The page with identifier ' . $id . ' is does not exist or is not available');
            }
            //look for the template, if it's not there just print out all the data raw
            $viewName = $page->template->templatename;
            $viewPath = $viewName;
            if (file_exists('application/views/frontend/' . $viewName . '.php')) {
                $viewPath = 'frontend/'.$viewPath;
            } else if(file_exists('application/views/generated/' . $viewPath . '.php')) {
                $viewPath = 'generated/'.$viewPath;
            } else {
                $viewPath = 'default';
            }
            $this->view = new View($viewPath);
        } else {
            //check for a virtual page specified in frontend.xml
            //a virtual page will be one that does not match a template
            $viewname = $pageidorslug;
            $this->view = new View($viewname);
        }

        //call this->view load data
        //get all the data for the page
        $viewContent = mop::getViewContent($viewName, $pageidorslug);
        foreach ($viewContent as $key => $value) {
            $this->view->$key = $value;
        }

        //possible hook for processing content	

	$this->response->body($this->view->render());

	
    }




}
