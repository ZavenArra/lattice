<?php

/*
 * To change this object_type, choose Tools | Templates
 * and open the object_type in the editor.
 */

/**
 * Description of latticeauth
 *
 * @author deepwinter
 */
class Lattice_Initializer_Latticeauth {

  public function initialize()
  {

    try {
      ORM::Factory('user');
    } catch (Exception $e)
    {
      if ($e->getCode() == 1146)
      { // code for table doesn't exist
        // install the initializedmodules table
        $sql_file = Kohana::find_file('sql', 'auth-schema-mysql', $ext = 'sql');

        $sql = file_get_contents( $sql_file);
        $rval = mysql_multiquery($sql);
      }
    }


    $admin = ORM::Factory('user')->where('username', '=', 'admin')->find();
    if ($admin->loaded())
    {
      $admin->delete();
    }
    if ( ! ORM::Factory('user')->where('username', '=', 'admin')->find()->loaded())
    {
      $user = ORM::factory('user');
      $user->status = 'ACTIVE';
      $user->username = 'admin';
      $user->firstname = 'Admin';
      $user->lastname = 'Admin';
      $password = Utility_Auth::random_password(); 
      $user->password = $password;
      $user->email = 'PLACEHOLDER_' . rand() . '@placeholder.com';
      $user->save();

      // add the login role
      $user->add('roles', ORM::Factory('role', array('name' => 'login')));
      $user->add('roles', ORM::Factory('role', array('name' => 'admin')));
      $user->add('roles', ORM::Factory('role', array('name' => 'superuser')));
      // $user->add(ORM::Factory('role', 'staging'));
      $user->save();

      Lattice_Initializer::add_message('Created admin user with password '.$password);
    }
  }
}

?>
