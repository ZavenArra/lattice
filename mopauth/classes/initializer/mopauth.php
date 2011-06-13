<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mopauth
 *
 * @author deepwinter
 */
class Initializer_Mopauth {
   
   public function initialize() {
		 $admin = ORM::Factory('user')->where('username', '=', 'admin')->find();
		 if($admin->loaded()){
			 $admin->delete();
		 }
      if (!ORM::Factory('user')->where('username', '=', 'admin')->find()->loaded()) {
         $user = ORM::factory('user');
         $user->status = 'ACTIVE';
         $user->username = 'admin';
         $password = Utility_Auth::randomPassword(); 
         $user->password = $password;
         $user->email = 'PLACEHOLDER_' . rand() . '@placeholder.com';
         $user->save();

         //add the login role
         $user->add('roles', ORM::Factory('role', array('name' => 'login')));
         $user->add('roles', ORM::Factory('role', array('name' => 'admin')));
         //$user->add(ORM::Factory('role', 'staging'));
         $user->save();
         
         MOP_Initializer::addMessage('Created admin user with password '.$password);
      }
   }
}

?>
