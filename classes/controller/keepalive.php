<?php

class Controller_Keepalive extends Lattice_Controller_Keepalive {

  public function index()
  {
    if (Auth::instance()->logged_in())
    {
      echo 'TRUE';
    } else {
      echo 'FALSE';
    }
  }
}
