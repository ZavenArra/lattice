<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Lattice_auth
 * @author     Deepwinter
 */
class Controller_Auth extends Controller_Layout {

	protected $_actions_that_get_layout = array(
                                         'index',
                                         'login',
                                         'logout',
                                         'noaccess',
                                         'forgot',
       );


	// Use the default Kohana object_type
	public $defaultobject_type = 'auth/object_type';

	public $message = '';

	public function __construct($request, $response){
		parent::__construct($request, $response);

		I18n::lang('en');
	}

	public function action_index()
	{
		$this->action_login();
	}

	/*
	 * Currently not supporting public creation of users
	public function action_create()
	{
		$this->view->title = 'Create User';

		$form = new Forge('auth/create');
		$form->input('email')->label(TRUE)->rules('required|length[4,32]|valid_email');
		$form->input('username')->label(TRUE)->rules('required|length[4,32]');
		$form->password('password')->label(TRUE)->rules('required|length[5,40]');
		$form->submit('Create New User');

		if ($form->validate())
		{
			// Create new user
			$user = ORM::factory('user');

			if ( ! $user->username_exists($form->username->value))
			{
				foreach ($form->as_array() as $key => $val)
				{
					// Set user data
					$user->$key = $val;
				}

				if ($user->save() AND $user->add(ORM::factory('role', 'login')))
				{
					Auth::instance()->login($user, $form->password->value);

					// Redirect to the login object
					Request::current()->redirect('auth/login');
				} 

			} else {
			}
		}

		$this->view = new View('auth/create');
		$this->view->content = $form->render();
	}
	 */

	public function action_login($redirect = null)
	{


		$error = null;

		/*
		 * Switch to validate library
		 $form->input('username')->label(TRUE)->rules('required|length[4,32]');
		$form->password('password')->label(TRUE)->rules('required|length[5,40]');
		 */

		$form_values = $_POST;
 		if (isset($form_values['submit']) )
		{
			// Load the user
			if (Auth::instance()->login($form_values['username'], $form_values['password']))
			{
				// Login successful, redirect
				//somewhere in here we can hang extra values for user roles
				//just override auth.redirect or something
				$authredirect =  Kohana::config('auth.redirect');
				
				if($form_values['redirect']){
					Request::current()->redirect(url::site($form_values['redirect'],Request::current()->protocol(),false));
				} else if($redirect = $authredirect){
					Request::current()->redirect(url::site($redirect,Request::current()->protocol(),false));
				} else {
					Request::current()->redirect(url::site('auth/login',Request::current()->protocol(),false));
				}
				return;
			}
			else
			{
				$error = 'Invalid username or password.';
			}
		}

    if (isset($_GET["redirect"])){
      $redirect = $_GET["redirect"];
    }

		$view = new View('auth/login');

		if($redirect == 'reset_password_success'){
			$view->message = I18n::get('reset_password_success');
			$redirect = null;
		} else if($error){
			$view->message = $error;
		}
		$view->title = 'User Login';

		if(!$redirect){
			if(isset($form_values['redirect'])){
				$redirect = $form_values['redirect'];
			}
		}
		$view->redirect = $redirect;
		$this->response->body($view->render());

	}

	public function action_logout()
	{
		// Force a complete logout
		Auth::instance()->logout(TRUE);

		// Redirect back to the login object
		Request::current()->redirect(url::site('auth/login',Request::current()->protocol(),false));

	}

	public function action_noaccess($controller = NULL){
		$this->message = 'You do not have access to the requested object';
		$this->login($controller);
	}

	public function action_forgot(){
		if(isset($_POST['email'])){
			$user = ORM::Factory('user')->where('email', '=', $_POST['email'])->find();
			if($user->loaded() ){
				$password = Utility_Auth::random_password();
				$user->password = $password;
				$user->save();
				$body = I18n::get('forgot_password_email_body');
				$body = str_replace('___Lattice___username___Lattice___', $user->username, $body);
				$body = str_replace('___Lattice___password___Lattice___', $password, $body);

				mail($user->email, I18n::get('forgot_password_email_subject'), $body);
				Request::current()->redirect('auth/login/reset_password_success');
				
			} else {
				$view = new View('auth/forgot');
				$view->message = I18n::get('reset_password_failed');

			}
		} else {
			$view = new View('auth/forgot');
		}
		$this->response->body($view);
	}

	

} // End Auth Controller
