<?php


class FrontendRouting {

   public static function routeSlug($uri) {
      $segments = explode('/', $uri);

      $slug = $segments[0];
      $object = null;
      foreach($segments as $segment){
				$slug = strtok($segment, '_');
				$languageCode = strtok('_');
				$object = Graph::object()->getPublishedObjectBySlug($slug);
				if($languageCode){
					$object = $object->translate($languageCode);
				}
         
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

Route::set('defaultMopFrontend', '(<controller>)',
	array(
		'controller'=>'',
	))
	->defaults(array(
		'controller' => 'mopfrontend',
		'action' => 'getView',
		'id'     => 'home',
	));


 

