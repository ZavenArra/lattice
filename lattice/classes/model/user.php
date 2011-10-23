<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Auth_User {

	// This class simply overrides the necessity of a password_confirm field
	// OK for the time being, but either we should have the field
	// or implement a MOP specific driver to override this

   public static function get_password_validation($values)
	{
		return Validation::factory($values)
			->rule('password', 'min_length', array(':value', 8));
	//		->rule('password_confirm', 'matches', array(':validation', ':field', 'password'));
	}

   
   
} // End User Model
