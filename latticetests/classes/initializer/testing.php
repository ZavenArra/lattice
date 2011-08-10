<?php

/*
 * To change this objectType, choose Tools | Templates
 * and open the objectType in the editor.
 */

/**
 * Description of mopauth
 *
 * @author deepwinter
 */
class Initializer_Testing {
   
   public function initialize() {

			 $role = ORM::Factory('role')->where('name', '=', 'editor')->find();
			 if(!$role->loaded()){
				 $sqlFile = Kohana::find_file('config', 'testing-mysql', $ext = 'sql');
				 $sql = file_get_contents( $sqlFile[0]);
         $rval = mysql_multiquery($sql);

         MOP_Initializer::addMessage('Initialized testing data');
      }
   }
}

?>
