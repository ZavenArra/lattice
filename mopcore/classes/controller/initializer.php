<?php

/*
 * To change this objectType, choose Tools | Templates
 * and open the objectType in the editor.
 */

/**
 * Description of initializer
 *
 * @author deepwinter
 */
class Controller_Initializer extends Controller {
   public function action_reinitialize($module) {
      MOP_Initializer::reinitialize($module);
   }
}

?>
