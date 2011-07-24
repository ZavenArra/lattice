<?php


class FrontendRouting {

   public static function routeSlug($uri) {
      $segments = explode('/', $uri);

      $slug = $segments[0];
      $object = null;
      foreach($segments as $slug){
         $object = ORM::Factory('object')->getPublishedObjectBySlug($slug);
         if(!$object->loaded()){
            return;
         }
   
      }
      if ($object) {
           return array(
               'controller'=>'mopfrontend',
               'action'=>'getView',
               'objectidorslug'=>$object->slug
            );
      }
   }

}
 


Route::set('mopCmsSlugs', array('FrontendRouting', 'routeSlug'));

 

