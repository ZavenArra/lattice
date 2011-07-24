<?


//check for setup
MOP_Initializer::check(
	array(
		'mopauth',
		'mopcore',
		'rootgraph',
		'cms',
		'mopcms',
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



