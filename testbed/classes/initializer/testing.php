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
class Initializer_Testing {
   
   public function initialize() {

			 $role = ORM::Factory('role')->where('name', '=', 'editor')->find();
			 if(!$role->loaded()){
				 $sqlFile = Kohana::find_file('sql', 'testing-mysql', $ext = 'sql');
				 $sql = file_get_contents( $sqlFile);
         $rval = mysql_multiquery($sql);

         Lattice_Initializer::addMessage('Initialized testing data');
      }
   }
}

?>
