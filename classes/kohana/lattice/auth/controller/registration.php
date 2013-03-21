<?php

Class Kohana_Lattice_Auth_Controller_Registration extends Controller_Layout {

  protected $_actions_that_get_layout = array(
    'index',
    'create',
    'confirmed',
  );

  protected $errors = array();
  protected $user_id = NULL;

  public function action_index()
  {
    $this->registration_view();
  }

  public function action_create()
  {
    // run form validation

    $validation = Validation::factory($_POST)
      ->rule('password', 'not_empty')
      ->rule('password', 'min_length', array(':value', 8))
      ->rule('password', 'matches', array($_POST, 'password', 'passwordconfirm')) 
      ->rule('username', 'not_empty')
      ->rule('username', 'min_length', array(':value', 4))
      ->rule('email', 'not_empty')
      ->rule('email', 'min_length', array(':value', 4))
      ->rule('email', 'email')
      ->rule('firstname', 'not_empty')
      ->rule('firstname', 'min_length', array(':value', 3))
      ->rule('lastname', 'not_empty')
      ->rule('lastname', 'min_length', array(':value', 3));


    if ($validation->check() AND ! count($this->errors))
    {
      $user = $this->create_user($_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['email']);
    } else {
      $this->errors = array_merge($this->errors, $validation->errors('validation/registration'));
    }


    if (count($this->errors))
    {
      $this->registration_view($this->errors);
    } else {
      $confirmation = new Confirmation('registration'
        , $_POST['email'],
        'registration',
        'confirmed', 
        array($this->user_id)
      );
      $confirmation->send();

      $view = new View('confirmation_required');
      $this->response->body($view->render());
    }
  } 

  public function action_confirmed($user_id)
  {
    $user = ORM::Factory('user',$user_id);
    if ( ! $user->loaded())
    {
      $this->response->body('Invalid Confirmation - User Does Not Exist');
      return;
    }
    $user->status = 'ACTIVE';
    $user->save();

    $view = new View('registration_confirmed');
    $this->response->body($view->render());
  }

  protected function registration_view($errors=NULL)
  {
    $view = new View('registration');
    $view->errors = $this->errors;
    isset(    $_POST['username'] ) ? $view->username = $_POST['username'] : $view->username = '';
    isset(    $_POST['password'] ) ? $view->password = $_POST['password'] : $view->password = '';
    isset(    $_POST['passwordconfirm'] ) ? $view->passwordconfirm = $_POST['passwordconfirm'] : $view->passwordconfirm = '';
    isset(    $_POST['email'] ) ? $view->email = $_POST['email'] : $view->email = '';
    isset(    $_POST['firstname'] ) ? $view->firstname = $_POST['firstname'] : $view->firstname = '';
    isset(    $_POST['lastname'] ) ? $view->lastname = $_POST['lastname'] : $view->lastname = '';
    $this->response->body($view->render());
  }

  protected function create_user($username, $password, $firstname, $lastname, $email)
  {

    try {
      $user = ORM::factory('user');
      $user->status = 'NEEDSCONFIRMATION'; // TODO: This is the problem..
      $user->username = $username;
      $user->password = $password;
      $user->firstname = $firstname;
      $user->lastname = $lastname;
      $user->email = $email;
      $user->save();
      $this->user_id = $user->id;
    }
   /**/ catch (Exception $e)
    {
      $errors = array();
      $model_errors = $e->errors('validation');
      if (isset($model_errors['_external']))
      {
        $model_errors = array_values($model_errors['_external']);
      } 
      $this->user_id = NULL;
      $this->errors = array_merge($errors, $model_errors);
      return FALSE;
    }
    /**/

    // add the login role
    $user->add('roles', ORM::Factory('role', array('name'=>'login')));
    if (is_array(Kohana::config('registration.default.roles')))
    {
      foreach (Kohana::config('registration.default.roles') as $role)
      {
        $user->add('roles', ORM::Factory('role', array('name'=>$role)));
      }
    }
    //  //Other roles from config
    $user->save();

    return $user;

  }
}
