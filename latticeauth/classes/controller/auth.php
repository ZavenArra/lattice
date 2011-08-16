<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Auth module demo controller. This controller should NOT be used in production.
 * It is for demonstration purposes only!
 *
 * $Id: auth_demo.php 3267 2008-08-06 03:44:02Z Shadowhand $
 *
 * @package    MopAuth
 * @author     Deepwinter
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Controller_Auth extends Controller_Layout {

	protected $_actionsThatGetLayout = array(
                                         'index',
                                         'login',
                                         'logout',
                                         'noaccess',
                                         'forgot',
       );


	// Use the default Kohana objectType
	public $defaultobjectType = 'auth/objectType';

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

		$formValues = $_POST;

		if (isset($formValues['submit']) )
		{
			// Load the user
			if (Auth::instance()->login($formValues['username'], $formValues['password']))
			{
				// Login successful, redirect
				if($formValues['redirect']){
					Request::current()->redirect(url::site($formValues['redirect'],Request::current()->protocol(),false));
				} else if($redirect = Kohana::config('auth.redirect')){
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


		$view = new View('auth/login');

		if($redirect == 'resetPasswordSuccess'){
			$view->message = I18n::get('resetPasswordSuccess');
			$redirect = null;
		} else if($error){
			$view->message = $error;
		}
		$view->title = 'User Login';

		if(!$redirect){
			if(isset($formValues['redirect'])){
				$redirect = $formValues['redirect'];
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
				$password = Utility_Auth::randomPassword();
				$user->password = $password;
				$user->save();
				$body = I18n::get('forgotPasswordEmailBody');
				$body = str_replace('___Lattice___username___Lattice___', $user->username, $body);
				$body = str_replace('___Lattice___password___Lattice___', $password, $body);
die($password . '-'.$user->password);

				mail($user->email, I18n::get('forgotPasswordEmailSubject'), $body);
				Request::current()->redirect('auth/login/resetPasswordSuccess');
				
			} else {
				$view = new View('auth/forgot');
				$view->message = I18n::get('resetPasswordFailed');

			}
		} else {
			$view = new View('auth/forgot');
		}
		$this->response->body($view);
	}

	

} // End Auth Controller
