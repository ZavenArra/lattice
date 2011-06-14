<?


//check for setup
MOP_Initializer::check(
	array(
      'cms',
		'mopcore',
		'mopcms',
      'rootgraph'
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



Route::set('cms_addChild', '<id>/<action>/<type>', array(
	'action' => 'addChild',
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



