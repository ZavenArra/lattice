<?
/*
 * Class: UserManagement_Controllers
 * Controller for usermangement module within MoPCMS, allows for settings up users
 * and passwords.  Can be configured deal with roles using the managedroles variables.
 */

Class UserManagement_Controller extends Controller {

	/*
	 * Variable: model
	 * Defines the database table where users are stored
	 */
	protected $table = 'user'; 

	/*
	 * Variable: viewName 
	 * Name of the main view to load, also used for javascript class and instance.
	 */
	protected $viewName = 'usermanagement';

	/*
	 * Variable: managedRoles
	 * Roles set up in the config file are loaded into this class variable
	 */
	protected $managedRoles;

	/*
	 * Function: __construct()
	 * Loads managedRoles and calls the parent constructor
	 */
	public function __construct(){
		parent::__construct();

		$this->managedRoles = Kohana::config(strtolower($this->controllername).'.managedRoles');
		
	}

	/*
	 * Function: createIndexView()
	 * Subclassed function to build the top view
	 * Parameters: none
	 * Returns: nothing, sets up view to render in this->template
	 */
	public function createIndexView(){
		//cleanup on an initial load
		$incompletes = ORM::Factory($this->table)->where('status', 'INCOMPLETE')->find_all();
		foreach($incompletes as $incomplete){
			$incomplete->delete();
		}

		$this->template = new View($this->viewName);
		$this->template->instance = $this->viewName;
		$this->template->class = $this->viewName;

		$users = ORM::Factory($this->table)->find_all();
		$html = '';
		foreach($users as $user){
			$usertemplate = new View($this->viewName.'_item');
			$data['id'] = $user->id;
			$data['username'] = $user->username;
			$data['email'] = $user->email;

			if(strlen($user->password)){
				$data['password'] = '******';
			} else {
				$data['password'] = '';
			}

			//find role'] = null;
			foreach($this->managedRoles as $label=>$role){
				if($user->has(ORM::Factory('role', $role))){
					$data['role'] = $role;
				}
			}

			$usertemplate->data = $data;

			$usertemplate->managedRoles = $this->managedRoles;
			$html .= $usertemplate->render();
		}

		$this->template->items = $html;

	}	

	/*
	 * Function: addItem($pageid)
	 * Ajax interface to add a new user object to the users table.
	 * Parameters:
	 * $pageid - unused variable, interface needs to be updated
	 * Returns: Rendered html editing page for new user object
	 */
	public function addItem($pageid){
		$user = $this->createUser();
		$data = $user->as_array();
	
		//set no managedRole
		$data['role'] = null;

		$this->template = new View($this->viewName.'_item');
		$this->template->data = $data;
		$this->template->managedRoles = $this->managedRoles;
		return $this->template->render();
	}

	/*
	 * Function: createUser()
	 * Utility function to create an empty user object in the database, with status INCOMPLETE
	 * and placeholder content for username and email
	 * Parameters: none
	 * Returns: User ORM Object, pre-saved
	 */
	protected function createUser(){
		$user = ORM::factory($this->table);
		$user->status = 'INCOMPLETE';
		$user->username = 'PLACEHOLDER_'.microtime();
		$user->email = 'PLACEHOLDER_'.microtime();
		$user->save();

		//add the login role
		$user->add(ORM::Factory('role', 'login'));
		$user->save();

		return $user;

	}

	/*
	 * Function: deleteItem($id)
	 * Deletes a user from the database
	 * Parameters:
	 * $id - the unique key id of the record to delete
	 * Returns: nothing
	 */
	public function deleteItem($id){
		$user = ORM::factory($this->table, $id);
		$user->delete($id);

	}

	/*
	 * Function: saveField($id)
	 * Ajax interface to update a field in the database table with a new value
	 * Parameters:
	 * $id - the unique key id of the record to update
	 * $_POST['field'] - the field to update
	 * $_POST['value'] - the new value to save
	 * Returns: array('value'=>{value})
	 */ 
	public function saveField($id){
		$user = ORM::factory($this->table, $id);

		switch($_POST['field']){
		case 'role':
			//first remove other managedRoles
			foreach($this->managedRoles as $label => $role){
				$roleObj = ORM::Factory('role', $role);
				if($user->has($roleObj)){
					$user->remove($roleObj);
				}
			}
			$user->add(ORM::Factory('role', $_POST['value']));	
			$user->save();
			$return = array('value'=>$_POST['value']);
			break;

		default:

			$errors = $user->checkValue($_POST['field'], $_POST['value']);
			Kohana::log('info', 'return from errors '.var_export($errors, true) );
			if(!$errors){
				$user->$_POST['field'] = $_POST['value'];
				$user->save();

				//this might be the first edit on a new record
				//so set the record to active status
				$this->activateRecord($user);
				

				if($_POST['field'] == 'password'){
					$body = new View('usermanagement_passwordchangeemail');
					$body->username = $user->username;
					$body->password = $_POST['value'];	

					mail($user->email, Kohana::config('usermanagement.passwordchangeemail.subject'), $body->render());
					$md5 = $user->password;
					$return = array('value'=>$md5);
				} else {
					$return = array('value'=>$_POST['value']);
				}
			} else {
				$firstkey = array_keys($errors);
				$firstkey = $firstkey[0];
				if($_POST['field']=='password'){
					$rval = null;
				} else {
					$rval = $_POST['value'];
				}
				$return = array('value'=>$rval, 'error'=>'true', 'message'=>$errors[$firstkey]);
			}
			break;
		}
		return $return;

	}

	/*
	 * Function: activateRecord(& $user)
	 * Switches a user record from status INCOMPLETE to status ACTIVE
	 * Parameters: 
	 * $user - an ORM object to update
	 * Returns: nothing
	 */
	protected function activateRecord(& $user){
		if($user->status == 'INCOMPLETE'){
			$user->status = 'ACTIVE';
			$user->save();
		}
	}

}
