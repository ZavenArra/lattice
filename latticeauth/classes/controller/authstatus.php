<?
/*
 * Class: MOP_Auth_Controller
 * Reponsible for the 'logged in as' object on the MOP backend objects
 */
class Controller_AuthStatus extends Controller {

	/*
	 * Function: createIndexView()
	 * Implements abstract function in base assigning the main view 
	 */
	public function action_index(){
		$view = new View('logged_in_as');
		if(Auth::instance()->get_user()){
			$view->username = Auth::instance()->get_user()->username;
		}
      $this->response->body($view->render());
	}
}
