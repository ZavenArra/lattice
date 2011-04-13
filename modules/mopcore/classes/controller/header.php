<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Header extends Controller {
	protected $viewPrefix = 'header';

	public function action_build($viewSuffix)
	{
		$view = new View($this->viewPrefix.'_'.$viewSuffix);
		$this->response->body($view->render());
	}

} // End Welcome
