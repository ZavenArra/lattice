<?





//check for setup
Lattice_Initializer::check(
	array(
		'rootgraph',
	)
);


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
Route::set('graph', 'graph/<action>(/<param1>(/<param2>))', array(

	)
)
->defaults(
	array(
		'controller' => 'graph',
	));

