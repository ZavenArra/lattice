<?

Route::set('mopCmsSlugs', '<uri>',
	array(
		'uri'=>'mopfrontend/validSlug',
	)
)
->defaults(
	array(
		'controller'=>'mopsite',
                'action'=>'page'
	));
