<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Footer extends Controller {
  protected $view_prefix = 'footer';

  public function action_build($view_suffix)
  {
    $view = new View($this->view_prefix.'_'.$view_suffix);
    $this->response->body($view->render());
  }

} // End Welcome
