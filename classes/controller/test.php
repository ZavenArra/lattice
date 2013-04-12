<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Test extends Core_Controller_Lattice {

  public function action_index()
  {
    $this->response->body('this is the outpu');
    // print_r(self::$top_controller->resources['js']);
    $this->response->body($this->output_layout());
  }


} //  End Welcome
