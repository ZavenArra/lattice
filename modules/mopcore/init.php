<?

Route::set('ajax', '(<controller>(/<action>(/<uri>)))',
	array(
		'controller'=>'ajax',
		'uri' => '[A-z\/]++',		
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

Route::set('layout', 'mop:(<request>)')
	->defaults(
		array(
			'controller'=>'layout',
			'action'=>'htmlLayout'
		)
	);


//using the framework means that other controllers aren't going to automatically load via the default
//they will always get wrapped by the layout controller

/*
Route::set('mopdefault', '(m:<requestController>(/<requestAction>(/<id>)))')
	->defaults(array(
		'controller' => 'layout',
		'action' => 'htmlLayout',
	));
 */
