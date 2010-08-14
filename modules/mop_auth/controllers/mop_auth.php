<?
/*
 * Class: MOP_Auth_Controller
 * Reponsible for the 'logged in as' object on the MOP backend pages
 */
class MOP_Auth_Controller extends Controller {

	/*
	 * Function: createIndexView()
	 * Implements abstract function in base assigning the main view 
	 */
	public function createIndexView(){
		$this->template = new View('logged_in_as');
		if(Session::instance()->get('auth_user')){
			$this->template->username = $_SESSION['auth_user']->username;
		}
	}
}
