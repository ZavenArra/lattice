<?

$config['add_object_position'] = 'bottom';

$config['nav_data_fields']['object'] = array(
		'id'=>'id',
		'slug'=>'slug',
		'published'=>'published',
	);

$config['nav_data_fields']['objectType'] = array(
		'nodeType',
		'contentType',
		'allowDelete',
		'pageLength',
		'allowTogglePublish',
		'allowChildSort',
		'addableObjects',
	);

$config['nav_data_fields']['content'] = array(
		'title'=>'title',
	);

return $config;
