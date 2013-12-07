<?php defined('SYSPATH') or die('No direct access allowed.');

class Lattice_Controller_Tools extends Controller {

	public function __construct()
	{
		if ( ! cms_util::check_role_access('superuser') AND PHP_SAPI != 'cli' )
		{
			die('Only superuser can access builder tool');
		}
		$this->root_node_object_type = Kohana::config('cms.graph_root_node');
	}

	public function action_frontend()
	{
		$frontend = new Builder_Frontend();
		$frontend->index();
	}

	public function action_regenerate_images()
	{
		try 
		{
			Cms_Core::regenerate_images();
		} 
		catch(Exception $e)
		{
			print_r($e->get_message() . $e->get_trace());
		}
		echo 'Done';
		flush();
		ob_flush();
	}
  
}
