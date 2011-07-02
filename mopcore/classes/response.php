<?php defined('SYSPATH') or die('No direct script access.');

class Response extends Kohana_Response {

	protected $_data;

	public function data($value=null){
		if($value){
			$this->_data = $value;
		}	
		return $this->_data;

	}


}
