<?php

Class Lattice_Controller_Accessdenied extends Core_Controller_Layout {

  public $_actions_that_get_layout = array('index');

  public function action_index()
  {
    $view = new View('access_denied');
    $this->response->body($view->render());
  }

}
