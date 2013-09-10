<?php defined('SYSPATH') or die('No direct script access.');

class Lattice_Controller_Footer extends Controller {
  protected $view_prefix = 'template/footer';

  public function action_build($view_suffix)
  {
    $view = new View($this->view_prefix.'_'.$view_suffix);
    $this->response->body($view->render());
  }

} //
