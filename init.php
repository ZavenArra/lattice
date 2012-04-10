<?

require(MODPATH.'lattice/includes/mysqlfuncs.php');



Route::set('navigation', 'navigation/<action>(/<param1>(/<param2>))', array(

	)
)
->defaults(
	array(
		'controller' => 'navigation',
	));


Route::set('authWithRedirect', '<controller>/<action>(/<redirect>)', array(
    'controller' => 'auth',
    'redirect' => '[A-z\/0-9]++',
        )
);




Route::set('cms_save', '<id>/<action>', array(
	'action' => 'save',
)
		)
		->defaults(
			array(
				'controller' => 'cms',
			));



Route::set('list', 'list/<action>(/<param1>(/<param2>))', array(

	)
)
->defaults(
	array(
		'controller' => 'list',
	));


Route::set('cms', 'cms/<action>(/<param1>(/<param2>))', array(

	)
)
->defaults(
	array(
		'controller' => 'cms',
	));

Route::set('associator', 'associator/<action>/<param1>/<param2>/<param3>', array(

	)
)
->defaults(
	array(
		'controller' => 'associator',
	));




Route::set('graph_addChild', '<id>/<action>/<type>', array(
	'action' => 'addChild',
)
		)
		->defaults(
			array(
				'controller' => 'graph',
			));

/*
 * Default path to allow 4 arguments to graph if necessary
 */
Route::set('graph', 'graph/<action>(/<param1>(/<param2>))', array( ))
->defaults(
	array(
		'controller' => 'graph',
	));


Route::set('ajax', 'ajax/(<action>)/(<uri>)', array(
			'controller' => 'ajax',
			'action' => '[A-z]+',
			'uri' => '[A-z\/0-9\-]++',
				)
		)
		->defaults(
				array(
					'controller' => 'ajax',
		));

Route::set('html', '<controller>(/<uri>)', array(
				'controller' => 'html',
					 )
		  )
		  ->defaults(
					 array(
						  'controller' => 'html',
						  'action' => 'html'
		  ));




Route::set('header', 'header(/<id>)')
	->defaults(
		array(
			'controller'=>'header',
			'action'=>'build'
		)
	);

Route::set('footer', 'footer(/<id>)')
	->defaults(
		array(
			'controller'=>'footer',
			'action'=>'build'
		)
	);


if(isset($_SERVER['REQUEST_URI'])
  && (!in_array(str_replace(url::base(), '', $_SERVER['REQUEST_URI']), array('setup', 'index.php/setup')))){
  try {
    ORM::Factory('object')->find_all();
    Graph::getRootNode('cmsRootNode');
  } catch(Exception $e){
    $view = new View('latticeNotInstalled');
    echo $view->render();
    die();
  }
}

/*
Route::set('default4', '(<controller>(/<action>(/<id>(/<thing>))))')
	->defaults(array(
	));
 */

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
					 $object = Graph::object()->publishedFilter()->where('slug', '=', $slug)->find();
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

	 public static function routeVirtual($uri){
		
      $segments = explode('/', $uri);
      if(Kohana::find_file('classes/controller', $segments[0])){
         return;
      }

			return;
			$config = lattice::config('frontend', '//view[@name="'.$uri.'"]');
			if($config->length){
         return array(
             'controller' => 'latticeviews',
             'action' => 'getVirtualView',
             'objectidorslug' => $uri
         );
			} 

			return;
      
	 }

}

Route::set('latticeViewsSlug', array('FrontendRouting', 'routeSlug'));

Route::set('latticeViewsVirtual', array('FrontendRouting', 'routeVirtual'));

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




Route::set('language', 'language/<action>(/<param1>(/<param2>))', array(

	)
)
->defaults(
	array(
		'controller' => 'language',
	));

 
