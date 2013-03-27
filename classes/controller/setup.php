<?php

Class Controller_Setup extends Controller {

  public function action_index()
  {

    $initialized = Lattice_Initializer::check(
      array(
        'lattice',
        'latticeauth',
        'cms',
        'usermanagement',
      )
    );

    if ($initialized)
    {
      $view = new View('lattice_installed');
      $this->response->body($view->render());
    } else {
      echo 'A problem occurred';
    }
  }
}
