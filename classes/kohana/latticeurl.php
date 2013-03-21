<?php
/* @package Lattice */

Class Kohana_Latticeurl {

  public static function site($url)
  {
    return url::site($url, NULL, FALSE);
  }
}
