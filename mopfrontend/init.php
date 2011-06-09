<?php


class FrontendRouting {

   public static function routeSlug($uri) {
      $segments = explode('/', $uri);

      $slug = $segments[0];
      $object = ORM::Factory('object')->getPublishedObjectBySlug($slug);
      if ($object->loaded()) {
           return array(
               'controller'=>'mopfrontend',
               'action'=>'getView',
               'pageidorslug'=>$slug
            );
      }
   }

}
 


Route::set('mopCmsSlugs', array('FrontendRouting', 'routeSlug'));

 

