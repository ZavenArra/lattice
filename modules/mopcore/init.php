<?

Route::set('ajax', '(<controller>(/<action>(/<uri>)))',
	array(
		'controller'=>'ajax',
		'uri' => '[A-z\/]++',		
	));
Route::set('header', '(<controller>(/<id>))',
	array(
		'controller'=>'header',
	))
	->defaults(
		array(
		'action'=>'build'
	)
	);

Route::set('footer', '(<controller>(/<id>))',
	array(
		'controller'=>'footer',
	))
	->defaults(
		array(
		'action'=>'build'
	)
	);
