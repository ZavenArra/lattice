<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Test extends Controller_Lattice {

	public function action_index()
	{
		$this->response->body('this is the outpu');
		//print_r(self::$topController->resources['js']);
		$this->response->body($this->outputLayout());
	}


} // End Welcome
