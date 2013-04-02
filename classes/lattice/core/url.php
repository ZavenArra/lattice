<?php
/* @package Lattice */

Class Lattice_Core_Url {

  public static function site($url)
  {
    return url::site($url, NULL, FALSE);
  }
}
