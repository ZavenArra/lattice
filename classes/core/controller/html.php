<?php
/*
 * Class: Core_Controller_Html
 * This controller provides a simple manual override to the auto layout wrapping
 * implemented in Core_Controller_Layout subclasses. 
 */

Class Core_Controller_Html extends Core_Controller_Lattice {

  public function action_html($uri)
  {

    $sub_request = Request::Factory($uri)->execute();
    $this->response->body($sub_request->body());
  }

}
