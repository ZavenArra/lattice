<?

Class LatticeAuth_Controller_Registration extends Controller_Layout {

  protected $_actionsThatGetLayout = array(
    'index',
    'create',
    'confirmed',
  );

  protected $errors = NULL;
  protected $user_id = NULL;

  public function action_index(){
    $this->registrationView();
  }

  public function action_create(){
    //run form validation

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

   
    if($validation->check()){
      $user = $this->createUser($_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['email']);
    } else {
      $this->errors = $validation->errors('validation/registration');
    }


    if($this->errors){
      $this->registrationView($this->errors);
    } else {
      $confirmation = new Confirmation('registration'
        , $_POST['email'],
        'registration',
        'confirmed', 
        array($this->user_id)
      );
      $confirmation->send();

      $view = new View('confirmationRequired');
      $this->response->body($view->render());
    }
  } 

  public function action_confirmed($user_id){
    $user = ORM::Factory('user',$user_id);
    if(!$user->loaded()){
      $this->response->body('Invalid Confirmation - User Does Not Exist');
      return;
    }
    $user->status = 'ACTIVE';
    $user->save();

    $view = new View('registrationConfirmed');
    $this->response->body($view->render());
  }

  protected function registrationView($errors=NULL){
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

  protected function createUser($username, $password, $firstname, $lastname, $email){

    try {
      $user = ORM::factory('user');
      $user->status = 'INCOMPLETE';
      $user->username = $username;
      $user->password = $password;
      $user->firstname = $firstname;
      $user->lastname = $lastname;
      $user->email = $email;
      $user->save();
      $this->user_id = $user->id;
    }
   /**/ catch (Exception $e){
     $errors = array();
      $modelErrors = $e->errors('validation/user');
      if(isset($modelErrors['_external'])){
        $modelErrors = array_values($modelErrors['_external']);
      } 
      $this->user_id = NULL;
      $this->errors = array_merge($errors, $modelErrors);
      return false;
   }
    /**/

    //add the login role
    $user->add('roles', ORM::Factory('role', array('name'=>'login')));
    if(is_array(Kohana::config('registration.default.roles'))){
      foreach(Kohana::config('registration.default.roles') as $role){
        $user->add('roles', ORM::Factory('role', array('name'=>$role)));
      }
    }
    // //Other roles from config
    $user->save();

    return $user;

  }
}
