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

    echo 'Done!';
  }
}
