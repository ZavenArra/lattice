<?php
/* @package Lattice */

Class Latticeurl {

  public static function site($url)
  {
    return url::site($url, NULL, FALSE);
  }
}
