<?

Class Controller_Setup extends Controller {

  public function action_index(){

    Lattice_Initializer::check(
      array(
        'lattice',
        'latticeauth',
        'cms',
        'usermanagement',
      )
    );

    $view = new View('latticeInstalled');
    $this->response->body($view->render());
  }
}
