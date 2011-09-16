<?php


class FrontendRouting {

   public static function routeSlug($uri) {
      $segments = explode('/', $uri);

    
      if(Kohana::find_file('classes/controller', $segments[0])){
         return;
      }
      
      $slug = $segments[0];
      $object = null;
      foreach ($segments as $segment) {
         
         $slug = strtok($segment, '_');
         $languageCode = strtok('_');
				 if(latticeutil::checkAccess('admin')){
					 $object = Graph::object($slug);
				 } else {
					 $object = Graph::object()->getPublishedObjectBySlug($slug);
				 }
         if ($languageCode) {
            $object = $object->translate($languageCode);
         }

         if (!$object->loaded()) {
            return;
         }
      }
      if ($object) {
         return array(
             'controller' => 'latticeviews',
             'action' => 'getView',
             'objectidorslug' => $object->slug
         );
      }
   }

}

Route::set('latticeCmsSlugs', array('FrontendRouting', 'routeSlug'));

Route::set('defaultLatticeFrontend', '(<controller>)',
	array(
		'controller'=>'',
	))
	->defaults(array(
		'controller' => 'latticeviews',
		'action' => 'getView',
		'id'     => 'home',
	));


Route::set('preview', 'preview/<id>',
	array(
		 'id' => '[A-z\-]+',
	 ))
	->defaults(array(
		'controller' => 'preview',
		'action' => 'preview',
	));



 

