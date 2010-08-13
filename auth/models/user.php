<?php defined('SYSPATH') or die('No direct script access.');

class User_Model extends Auth_User_Model {

	// This class can be replaced or extended
	//

	public function __get($column){
		$value = parent::__get($column);
		if(strpos($value, 'PLACEHOLDER_')===0){
			return null;
		}
		return $value;

	}

	public function __unique_username($validation, $field){
		$dup = ORM::Factory('user')->where('username', $validation[$field])->where('id !=', $this->id)->find();
		if($dup->loaded){
			$validation->add_error($field, 'user_exists');
		}
	}

	public function __unique_email($validation, $field){
		$dup = ORM::Factory('user')->where('email', $validation[$field])->where('id !=', $this->id)->find();
		if($dup->loaded){
			$validation->add_error($field, 'email_exists');
		}
	}


	public function checkValue($field, $value){

		$validation = new Validation(array($field=>$value));
		
		switch($field){
			case 'username':
				//make sure there's no duplicate
				$validation->add_callbacks('username', array($this, '__unique_username'));
				$validation->add_rules('username','required', 'length[3,20]');
				break;

			case 'password':
				$validation->add_rules('password','required', 'length[5,20]');
				break;

			case 'email':
				$validation->add_callbacks('email', array($this, '__unique_email'));
				$validation->add_rules('email', 'required', 'valid::email');

				break;
		}
		if($validation->validate()){
			return false;
		} else {
			return $validation->errors('form_errors');
		}

	}
	
} // End User Model
