<?php

/**
 * Description of initializer
 *
 * @author deepwinter
 */
class Lattice_Controller_Initializer extends Controller {
	
  public function action_reinitialize($module)
  {
    Lattice_Initializer::reinitialize($module);
  }
  
}

?>
