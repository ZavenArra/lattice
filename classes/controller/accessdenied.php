<?php

Class Controller_Access_denied extends Core_Controller_Layout {

  public $_actions_that_get_layout = array('index');

  public function action_index()
  {
    $view = new View('accessdenied');
    $this->response->body($view->render());
  }

}
