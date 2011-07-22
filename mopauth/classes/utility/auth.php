<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of auth
 *
 * @author deepwinter
 */

function make_seed() {
			list($usec, $sec) = explode(' ', microtime());
			return (float) $sec + ((float) $usec * 100000);
}
      
      
class Utility_Auth {
   
   public static function randomPassword(){
		$password_length = 12;

		

		mt_srand(make_seed());

		$alfa = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
		$token = "";
		for($i = 0; $i < $password_length; $i ++) {
			$token .= $alfa[mt_rand(0, strlen($alfa)-1)];
		}    
      
		return $token;


	}
}
