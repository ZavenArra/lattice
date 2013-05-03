<?php

class Lattice_Controller_Keepalive extends Controller {

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
