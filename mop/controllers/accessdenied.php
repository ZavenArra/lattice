<?
/*
 * Class: AccessDenied_Controller
 * Basic view for when use tries to view a page they don't have access to
 */
Class AccessDenied_Controller extends Controller {

	/*
	 * Function: index()
	 * Renders the webpage for accessdenied view
	 */
	public function index(){
		//the default access denied view can be overridden in each application
		$this->template = new View('accessdenied');
		$this->toWebPage();
	}
}
