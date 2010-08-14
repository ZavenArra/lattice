<?php defined('SYSPATH') or die('No direct script access.');
/**
 */
 class ORM extends MOP_ORM_Core { 

	 public function __construct($id=NULL){
		 parent::__construct($id);
		 Kohana::log('info', 'MY_ORM constructor');
	 }

}

