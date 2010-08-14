<?php defined('SYSPATH') or die('No direct script access.');

/*
Class: View
MY_View - Application level view, which can be customized for specific applications
*/

class View extends MOP_View_Core{

	public function __construct($name = NULL, $data = NULL, $type = NULL){
		parent::__construct($name, $data, $type);
	}


}
?>
