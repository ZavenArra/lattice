<?

Class Controller_Registration extends Controller_Lattice {

  protected $_actionsThatGetLayout = array(
    'index',
  );

  protected $errors = NULL;
  private $user_id = NULL;

  public function action_index(){
    $this->registrationView();
  }

  public function action_create(){
    //run form validation

    $errors = $this->createUser($_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['email']);
    if($this->errors){
      $this->registrationView();
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
    $user->status = 'ACTIVE';
    $user->save();

    $view = new View('registrationConfirmed');
    $this->response->body($view->render());
  }

  protected function registrationView($errors=NULL){
    $view = new View('registration');
    $view->errors = $this->errors;
    $this->response->body($view->render());
  }

  protected function createUser($username, $password, $firstname, $lastname, $email){

    try {
      $user = ORM::factory('user');
      $user->status = 'INCOMPLETE';
      $user->username = $username;
      $user->password = $password;
     // $user->firstname = $firstname;
      //$user->lastname = $lastname;
      $user->email = $email;
      $user->save();
      $this->user_id = $user->id;
    }
   /**/ catch (Exception $e){
     $errors = array();
      $modelErrors = $e->errors('validation');
      if(isset($modelErrors['_external'])){
        $modelErrors = array_values($modelErrors['_external']);
      } 
      $this->errors = array_merge($errors, $modelErrors);
      return;
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

    return true;

  }
}
