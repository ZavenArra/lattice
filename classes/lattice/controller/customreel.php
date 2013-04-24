<?php
/* @package usermanagement
 * Class: User_management_Controllers
 * Controller for usermangement module within LatticeCMS, allows for settings up users
 * and passwords.  Can be configured deal with roles using the managedroles variables.
 */

Class Lattice_Controller_Customreel extends Core_Controller_Layout {

  protected $_actions_that_get_layout = array('index');



  /*
   * Variable: model
   * Defines the database table where users are stored
   */
  protected $table = 'user'; 

  /*
   * Variable: view_name 
   * Name of the main view to load, also used for javascript class and instance.
   */
  protected $view_name = 'usermanagement';

  /*
   * Variable: managed_roles
   * Roles set up in the config file are loaded into this class variable
   */
  protected $managed_roles;

  /*
   * Function: __construct()
   * Loads managed_roles and calls the parent constructor
   */
  public function __construct($request, $response)
  {
    parent::__construct($request, $response);

    $this->managed_roles = Kohana::config(strtolower($this->controller_name).'.managed_roles');
    if (Kohana::config(strtolower($this->controller_name).'.superuser_edit')
      AND cms_util::check_role_access('superuser'))
    {
      if (is_array($this->managed_roles))
      {
        $keys = array_keys($this->managed_roles);
        $vals = array_values($this->managed_roles);
        array_unshift($keys,'Superuser');
        array_unshift($vals,'superuser');
        $this->managed_roles = array_combine($keys, $vals);
      }
    }

  }

  /*
   * Function: create_index_view()
   * Subclassed function to build the top view
   * Parameters: none
   * Returns: nothing, sets up view to render in this->view
   */
  public function action_index()
  {
    // cleanup on an initial load
    $incompletes = ORM::Factory($this->table)->where('status', '=', 'INCOMPLETE')->find_all();
    foreach ($incompletes as $incomplete)
    {
      $incomplete->delete();
    }

    $this->view = new View($this->view_name);
    $this->view->instance = $this->view_name;
    $this->view->class = strtolower($this->controller_name);

    $users = ORM::Factory($this->table)->find_all();
    $managed_users = array();
    foreach ($users as $user)
    {
      foreach ($this->managed_roles as $role)
      {
        if ($user->has('roles', ORM::Factory('role', array('name'=>$role))))
        {
          $managed_users[] = $user;
          continue (2);
        }
      }
    }
    $html = '';
    foreach ($managed_users as $user)
    {
      $user_item_view = $this->create_user_item_view($user);	
      $html .= $user_item_view->render();
    }


    $this->view->items = $html;
    $this->response->body($this->view->render());

  }	

  protected function get_user_data($user)
  {
    $data['id'] = $user->id;
    $data['username'] = $user->username;
    $data['firstname'] = $user->firstname;
    $data['lastname'] = $user->lastname;
    $data['email'] = $user->email;

    if (strstr($data['email'], 'PLACEHOLDER'))
    {
      $data['email'] = '';
    }

    if (strlen($user->password))
    {
      $data['password'] = '******';
    } else {
      $data['password'] = '';
    }

    $data['role'] = $this->get_active_managed_role($user);
    if ($user->has('roles', ORM::Factory('role')->where('name','=','superuser')->find()) )
    {
      $data['superuser'] = TRUE;
    } else {
      $data['superuser'] = FALSE;
    }

    return $data;
  }

  protected function create_user_item_view($user)
  {
    $user_item_view = new View($this->view_name.'_item');
    $user_item_view->data = $this->get_user_data($user);
    $user_item_view->managed_roles = $this->managed_roles;
    $user_item_view->view_data = $this->get_user_view_data();
    return $user_item_view;
  }

  /*
   * Function get_view_data()
   * Get data specific for the item view
   */
  protected function get_user_view_data()
  {
    return array();
  }

  private function get_active_managed_role($user)
  {
    $active_role = NULL;
    foreach ($this->managed_roles as $label=>$role)
    {
      if ($user->has('roles', ORM::Factory('role')->where('name','=',$role)->find()) )
      {
        $active_role = $role;
        break;
      }
    }
    return $active_role;
  }

  /*
   * Function: add_item($objectid)
   * Ajax interface to add a new user object to the users table.
   * Parameters:
   * $objectid - unused variable, interface needs to be updated
   * Returns: Rendered html editing object for new user object
   */
  public function action_add_object()
  {
    $user = $this->create_user();
    $data = $user->as_array();

    // set no managed_role
    $data['username'] = NULL;
    $data['password'] = NULL;
    $data['email'] = NULL;
    $data['superuser'] = FALSE;
    $data['role'] = $this->get_active_managed_role($user);
    $data['site'] = NULL;
    $data['user_type'] = NULL;

    $view = new View($this->view_name.'_item');
    $view->data = $data;
    $view->managed_roles = $this->managed_roles;
    $view->view_data = $this->get_user_view_data();
    $this->response->body( $view->render() );
  }

  /*
   * Function: create_user()
   * Utility function to create an empty user object in the database, with status INCOMPLETE
   * and placeholder content for username and email
   * Parameters: none
   * Returns: User ORM Object, pre-saved
   */
  protected function create_user()
  {
    $user = ORM::factory($this->table);
    $user->status = 'INCOMPLETE';
    $user->username = 'PLACEHOLDER_'.Core_Utility_Auth::random_password();;
    $user->password = Core_Utility_Auth::random_password();
    $user->email = 'PLACEHOLDER'.Core_Utility_Auth::random_password().'@madeofpeople.org';
    $user->save();

    // add the login role
    $user->add('roles', ORM::Factory('role', array('name'=>'login')));
    // add the default role
    $user->add('roles', ORM::Factory('role', array('name'=>Kohana::config(strtolower($this->controller_name).'.default_roles') ) ) );
    $user->save();

    return $user;

  }

  /*
   * Function: delete_item($id)
   * Deletes a user from the database
   * Parameters:
   * $id - the unique key id of the record to delete
   * Returns: nothing
   */
  public function action_remove_object($id)
  {
    $user = ORM::factory($this->table, $id);
    $user->delete($id);

  }

  /*
   * Function: save_field($id)
   * Ajax interface to update a field in the database table with a new value
   * Parameters:
   * $id - the unique key id of the record to update
   * $_POST['field'] - the field to update
   * $_POST['value'] - the new value to save
   * Returns: array('value'=>{value})
   */ 
  public function action_save_field($id)
  {

    if ( ! cms_util::check_role_access('admin'))
    {
      throw new Kohana_Exception('Only Admin has access to User Management');
    }

    $user = ORM::factory($this->table, $id);

    $field = $_POST['field'];
    $value = $_POST['value'];

    switch($field)
    {
    case 'role':

      if ($user->has('roles', ORM::Factory('role')->where('name', '=' ,'superuser')->find() ))
      {
        if ( ! cms_util::check_role_access('superuser'))
        {
          throw new Kohana_Exception('Only superuser can change superuser');
        }
      }

      // first remove other managed_roles
      foreach ($this->managed_roles as $label => $role)
      {
        $role_obj = ORM::Factory('role')->where('name','=',$role)->find();
        if ($user->has('roles',$role_obj))
        {
          $user->remove('roles', $role_obj);
          $user->save();
        }
      }
      $role = ORM::Factory('role')->where('name','=',$value)->find();
      if ( ! $role->loaded())
      {
        throw new Kohana_Exception('Role :role not found in database.  Update aborted', array(':role'=>$value));
      }
      $user->add('roles', $role);	
      $user->save();

      if ($value=='superuser')
      {

        if ( ! cms_util::check_role_access('superuser'))
        {
          throw new Kohana_Exception('Updating to superuser not allowed for non-superuser');
        }

        $role = ORM::Factory('role')->where('name','=','admin')->find();
        if ( ! $role->loaded())
        {
          throw new Kohana_Exception('Role :role not found in database.  Update aborted', array(':role'=>'admin'));
        }
        $user->add('roles', $role);	
        $user->save();

      }

      $return = $this->response->data( array('value'=>$value) );
      break;

    default:

      // $errors = $user->check_value($_POST['field'], $_POST['value']);
      $errors  = array();

      if ( ! count($errors))
      {

        try {
          $user->update_user(array($field => $value), array($field))->save();


          // this might be the first edit on a new record
          // so set the record to active status
          $this->activate_record($user);


          if ($_POST['field'] == 'password')
          {
            $body = new View('usermanagement_passwordchangeemail');
            $body->username = $user->username;
            $body->password = $_POST['value'];

            $headers = 'From: '.Kohana::config('usermanagement.password_change_email.from'). "\r\n" .
              'X-Mailer: PHP/' . phpversion();
            mail($user->email, 
              Kohana::config('usermanagement.password_change_email.subject'),
              $body->render(),
              $headers);
            $this->response->data(array('value' => '**********'));
            $this->response->data(array('value' => $body->password));
          } else {
            $value = $user->{$_POST['field']};
            $this->response->data(array('value' => $value));
          }
        } catch (Exception $e)
          {
            $model_errors = $e->errors('validation');
            if (isset($model_errors['_external']))
            {
              $model_errors = array_values($model_errors['_external']);
            } 
            $errors = array_merge($errors, $model_errors);
          }
      }
      if ($errors)
      {
        $firstkey = array_keys($errors);
        $firstkey = $firstkey[0];
        if ($_POST['field'] == 'password')
        {
          $rval = NULL;
        } else {
          $rval = $user->{$_POST['field']};
        }
        $return = $this->response->data(array('value' => $rval, 'error' => 'TRUE', 'message' => $errors[$firstkey]));
      }
      break;
    }

  }

  /*
   * Function: activate_record(& $user)
   * Switches a user record from status INCOMPLETE to status ACTIVE
   * Parameters: 
   * $user - an ORM object to update
   * Returns: nothing
   */
  protected function activate_record(& $user)
  {
    if ($user->status != 'ACTIVE')
    {
      $user->status = 'ACTIVE';
      $user->save();
    }
  }

}
