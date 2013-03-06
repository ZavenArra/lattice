<?php
/*
 * Class: Lattice_Auth_Controller
 * Reponsible for the 'logged in as' object on the MOP backend objects
 */
class Controller_Auth_status extends Controller {

  /*
   * Function: create_index_view()
   * Implements abstract function in base assigning the main view 
   */
  public function action_index()
  {
    $view = new View('logged_in_as');
    if (Auth::instance()->get_user())
    {
      $view->username = Auth::instance()->get_user()->username;
    }
    $this->response->body($view->render());
  }
}
