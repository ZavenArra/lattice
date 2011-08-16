<?php defined('SYSPATH') or die('No direct script access.');

class Controller_HeaderFooter extends Controller {
	protected $viewPrefix = '';

	public function action_build($viewSuffix)
	{
		$view = new View($this->viewPrefix.'_'.$viewSuffix);
		$this->response->body($view->render());
	}

} // End Welcome
