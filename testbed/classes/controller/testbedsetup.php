<?

Class Controller_TestBedSetup extends Controller {

  public function action_index(){

    Lattice_Initializer::check(
      array(
        'defaultusers',
        'testing',
      )
    );

  }
}
