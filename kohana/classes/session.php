<?php defined('SYSPATH') or die('No direct script access.');

abstract class Session extends Kohana_Session {
   
   
   public static function instance($type=null, $id=null){
			Kohana::$log->add(Log::INFO, 'hi'); 
      if(isset($_POST['cookie'])){
				Kohana::$log->add(Log::INFO, 'asdfas'.$_POST['cookie']);
         return parent::instance($type, $_POST['cookie']);
      } else {
         return parent::instance($type, $id);
      }
   }
   
   
}