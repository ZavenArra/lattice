<?

Route::set('ajax', '<controller>/(<action>)/(<uri>)', array(
			'controller' => 'ajax',
			'action' => '[A-z]+',
			'uri' => '[A-z\/0-9]++',
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

