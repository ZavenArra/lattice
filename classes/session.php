<?php defined('SYSPATH') or die('No direct script access.');
/* @package Lattice */

abstract class Session extends Kohana_Session {
   
   
   public static function instance($type=null, $id=null){
      if (isset($_POST['cookie'])){
         return parent::instance($type, $_POST['cookie']);
      } else {
         return parent::instance($type, $id);
      }
   }
   
   
}
