<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Footer extends Controller {
	protected $viewPrefix = 'footer';

	public function action_build($viewSuffix)
	{
		$view = new View($this->viewPrefix.'_'.$viewSuffix);
		$this->response->body($view->render());
	}

} // End Welcome
