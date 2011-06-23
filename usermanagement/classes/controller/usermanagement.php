<?
/*
 * Class: UserManagement_Controllers
 * Controller for usermangement module within MoPCMS, allows for settings up users
 * and passwords.  Can be configured deal with roles using the managedroles variables.
 */

Class Controller_UserManagement extends Controller_Layout {

   protected $_actionsThatGetLayout = array('index');

   
   
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
	public function __construct($request, $response){
		parent::__construct($request, $response);

		$this->managedRoles = Kohana::config(strtolower($this->controllerName).'.managedRoles');
		
	}

	/*
	 * Function: createIndexView()
	 * Subclassed function to build the top view
	 * Parameters: none
	 * Returns: nothing, sets up view to render in this->view
	 */
	public function action_index(){
		//cleanup on an initial load
		$incompletes = ORM::Factory($this->table)->where('status', '=', 'INCOMPLETE')->find_all();
		foreach($incompletes as $incomplete){
			$incomplete->delete();
		}

		$this->view = new View($this->viewName);
		$this->view->instance = $this->viewName;
		$this->view->class = $this->viewName;

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
			$data['role'] = null;
			foreach($this->managedRoles as $label=>$role){
				if($user->has(ORM::Factory('role', $role))){
					$data['role'] = $role;
				}
			}

			$usertemplate->data = $data;

			$usertemplate->managedRoles = $this->managedRoles;
			$html .= $usertemplate->render();
		}

		$this->view->items = $html;
		$this->response->body($this->view->render());

	}	

	/*
	 * Function: addItem($objectid)
	 * Ajax interface to add a new user object to the users table.
	 * Parameters:
	 * $objectid - unused variable, interface needs to be updated
	 * Returns: Rendered html editing page for new user object
	 */
	public function action_addItem(){
		$user = $this->createUser();
		$data = $user->as_array();
	
		//set no managedRole
		$data['role'] = null;
      $data['username'] = null;
      $data['password'] = null;
      $data['email'] = null;

		$view = new View($this->viewName.'_item');
		$view->data = $data;
		$view->managedRoles = $this->managedRoles;
		$this->response->body( $view->render() );
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
      $user->password = microtime();
		$user->email = 'PLACEHOLDER_'.microtime().'@madeofpeople.org';
		$user->save();

		//add the login role
		$user->add('roles', ORM::Factory('role', array('name'=>'login')));
		$user->add('roles', ORM::Factory('role', array('name'=>'admin')));
		//$user->add(ORM::Factory('role', 'staging'));
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
	public function action_deleteItem($id){
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
	public function action_saveField($id){
		$user = ORM::factory($this->table, $id);
      
      $field = $_POST['field'];
      $value = $_POST['value'];
      
		switch($field){
		case 'role':
			//first remove other managedRoles
			foreach($this->managedRoles as $label => $role){
				$roleObj = ORM::Factory('role', $role);
				if($user->has($roleObj)){
					$user->remove($roleObj);
				}
			}
			$user->add(ORM::Factory('role', $value));	
			$user->save();
			$return = array('value'=>$value);
			break;

		default:

			//$errors = $user->checkValue($_POST['field'], $_POST['value']);
         $errors  = false;
         
			if(!$errors){
            
				$user->update_user(array($field=>$value), array($field) )->save();
            
            
				//this might be the first edit on a new record
				//so set the record to active status
				$this->activateRecord($user);
				

				if($_POST['field'] == 'password'){
					$body = new View('usermanagement_passwordchangeemail');
					$body->username = $user->username;
					$body->password = $_POST['value'];	

					mail($user->email, Kohana::config('usermanagement.passwordchangeemail.subject'), $body->render());
					$this->response->data(array('value'=>'**********'));
               $this->response->data(array('value'=>$body->password));

				} else {
               $value = $user->{$_POST['field']};
					$this->response->data(array('value' => $value));
				}
			} else {
				$firstkey = array_keys($errors);
				$firstkey = $firstkey[0];
				if($_POST['field']=='password'){
					$rval = null;
				} else {
					$rval = $_POST['value'];
				}
				$return = $this->response->data( array('value'=>$rval, 'error'=>'true', 'message'=>$errors[$firstkey]) );
			}
			break;
		}

	}

	/*
	 * Function: activateRecord(& $user)
	 * Switches a user record from status INCOMPLETE to status ACTIVE
	 * Parameters: 
	 * $user - an ORM object to update
	 * Returns: nothing
	 */
	protected function activateRecord(& $user){
		if($user->status != 'ACTIVE'){
			$user->status = 'ACTIVE';
			$user->save();
		}
	}

}
