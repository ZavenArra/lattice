<?php

/*
 * To change this object_type, choose Tools | Templates
 * and open the object_type in the editor.
 */

/**
 * Description of initializer
 *
 * @author deepwinter
 */
class Controller_Initializer extends Controller {
  public function action_reinitialize($module)
  {
    Lattice_Initializer::reinitialize($module);
  }
}

?>
