<?
/* @package usermanagement
 * Class: UserManagement_Controllers
 * Controller for usermangement module within LatticeCMS, allows for settings up users
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
		if(latticeutil::checkRoleAccess('superuser')){
      $keys = array_keys($this->managedRoles);
      $vals = array_values($this->managedRoles);
			array_unshift($keys,'Superuser');
			array_unshift($vals,'superuser');
      $this->managedRoles = array_combine($keys, $vals);
		}
		
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
			$userobjectType = new View($this->viewName.'_item');
			$data['id'] = $user->id;
			$data['username'] = $user->username;
			$data['firstname'] = $user->firstname;
			$data['lastname'] = $user->lastname;
			$data['email'] = $user->email;

			if(strlen($user->password)){
				$data['password'] = '******';
			} else {
				$data['password'] = '';
			}

			$data['role'] = null;
			foreach($this->managedRoles as $label=>$role){
				if($user->has('roles', ORM::Factory('role')->where('name','=',$role)->find()) ){
					$data['role'] = $role;
				}
			}
			if($user->has('roles', ORM::Factory('role')->where('name','=','superuser')->find()) ){
				$data['superuser'] = true;
			} else {
				$data['superuser'] = false;
			}

			$userobjectType->data = $data;

			$userobjectType->managedRoles = $this->managedRoles;
			$html .= $userobjectType->render();
		}

		$this->view->items = $html;
		$this->response->body($this->view->render());

	}	

	/*
	 * Function: addItem($objectid)
	 * Ajax interface to add a new user object to the users table.
	 * Parameters:
	 * $objectid - unused variable, interface needs to be updated
	 * Returns: Rendered html editing object for new user object
	 */
	public function action_addObject(){
		$user = $this->createUser();
		$data = $user->as_array();
	
		//set no managedRole
		$data['role'] = null;
		$data['username'] = null;
		$data['password'] = null;
		$data['email'] = null;
		$data['superuser'] = false;

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
		$user->username = 'PLACEHOLDER_'.Utility_Auth::randomPassword();;
		$user->password = Utility_Auth::randomPassword();
		$user->email = 'PLACEHOLDER'.Utility_Auth::randomPassword().'@madeofpeople.org';
		$user->save();

		//add the login role
		$user->add('roles', ORM::Factory('role', array('name'=>'login')));
		$user->add('roles', ORM::Factory('role', array('name'=>'admin')));
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
	public function action_removeObject($id){
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

		if(!latticeutil::checkRoleAccess('admin')){
			throw new Kohana_Exception('Only Admin has access to User Management');
		}

		$user = ORM::factory($this->table, $id);

		$field = $_POST['field'];
		$value = $_POST['value'];

		switch($field){
		case 'role':

			if($user->has('roles', ORM::Factory('role')->where('name', '=' ,'superuser')->find() )){
				if(!latticeutil::checkRoleAccess('superuser')){
					throw new Kohana_Exception('Only superuser can change superuser');
				}
			}

			//first remove other managedRoles
			foreach($this->managedRoles as $label => $role){
				$roleObj = ORM::Factory('role')->where('name','=',$role)->find();
				if($user->has('roles',$roleObj)){
					$user->remove('roles', $roleObj);
				}
			}
			$role = ORM::Factory('role')->where('name','=',$value)->find();
			if(!$role->loaded()){
				throw new Kohana_Exception('Role :role not found in database.  Update aborted', array(':role'=>$value));
			}
			$user->add('roles', $role);	
			$user->save();

			if($value=='superuser'){

				if(!latticeutil::checkRoleAccess('superuser')){
					throw new Kohana_Exception('Updating to superuser not allowed for non-superuser');
				}

				$role = ORM::Factory('role')->where('name','=','admin')->find();
				if(!$role->loaded()){
					throw new Kohana_Exception('Role :role not found in database.  Update aborted', array(':role'=>'admin'));
				}
				$user->add('roles', $role);	
				$user->save();

			}

			$return = $this->response->data( array('value'=>$value) );
			break;

		default:

			//$errors = $user->checkValue($_POST['field'], $_POST['value']);
         $errors  = array();
         
			if (!count($errors)) {

               try {
                  $user->update_user(array($field => $value), array($field))->save();


                  //this might be the first edit on a new record
                  //so set the record to active status
                  $this->activateRecord($user);


                  if ($_POST['field'] == 'password') {
                     $body = new View('usermanagement_passwordchangeemail');
                     $body->username = $user->username;
                     $body->password = $_POST['value'];

										 $headers = 'From: '.Kohana::config('usermanagement.passwordChangeEmail.from'). "\r\n" .
													     'X-Mailer: PHP/' . phpversion();
										 mail($user->email, 
											 Kohana::config('usermanagement.passwordChangeEmail.subject'),
                       $body->render(),
                       $headers);
                     $this->response->data(array('value' => '**********'));
                     $this->response->data(array('value' => $body->password));
                  } else {
                     $value = $user->{$_POST['field']};
                     $this->response->data(array('value' => $value));
                  }
               } catch (Exception $e) {
                  $modelErrors = $e->errors('validation');
									if(isset($modelErrors['_external'])){
										$modelErrors = array_values($modelErrors['_external']);
									} 
                  $errors = array_merge($errors, $modelErrors);
               }
         }
         if($errors) {
               $firstkey = array_keys($errors);
               $firstkey = $firstkey[0];
               if ($_POST['field'] == 'password') {
                  $rval = null;
               } else {
                  $rval = $user->{$_POST['field']};
               }
               $return = $this->response->data(array('value' => $rval, 'error' => 'true', 'message' => $errors[$firstkey]));
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
