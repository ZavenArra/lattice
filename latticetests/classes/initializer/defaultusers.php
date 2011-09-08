<?php

/*
 * To change this objectType, choose Tools | Templates
 * and open the objectType in the editor.
 */

/**
 * Description of latticeauth
 *
 * @author deepwinter
 */
class Initializer_DefaultUsers {
   
   public function initialize() {
      
      $user = ORM::Factory('user');
      $values = array(
        'username'=>'deepwinter',
        'password'=>'likeseverything',
        'email'=>'deepwinter@winterroot.net',
        'status'=>'ACTIVE',
      );
      $user->create_user($values, array_keys($values));

      $user->add('roles', ORM::Factory('role', array('name'=>'login')));
      $user->add('roles', ORM::Factory('role', array('name'=>'admin')));
      $user->add('roles', ORM::Factory('role', array('name'=>'superuser')));
     
      
      $user = ORM::Factory('user');
      $user->username = 'thiago';
      $user->password = 'christ';
      $user->email = 'thiago@thiagodemellobueno.com';
      $user->status = 'ACTIVE';
      $user->save();

      $user->add('roles', ORM::Factory('role', array('name'=>'login')));
      $user->add('roles', ORM::Factory('role', array('name'=>'admin')));
      $user->add('roles', ORM::Factory('role', array('name'=>'superuser')));
     

      Lattice_Initializer::addMessage('Initialized default users');
   }
}

?>
