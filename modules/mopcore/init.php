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
