<?

$config['addObjectPosition'] = 'bottom';

$config['navDataFields']['object'] = array(
		'id'=>'id',
		'slug'=>'slug',
		'published'=>'published',
	);

$config['navDataFields']['objectType'] = array(
		'nodeType',
		'contentType',
		'allowDelete',
		'allowTogglePublish',
		'allowChildSort',
		'addableObjects',
	);

$config['navDataFields']['content'] = array(
		'title'=>'title',
	);

return $config;
