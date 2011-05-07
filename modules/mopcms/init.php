<?

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


