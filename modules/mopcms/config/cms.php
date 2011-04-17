<?

$config['displaycontroller'] = 'DisplayAdmin';
$config['authrole'] = 'admin';

$config['defaultsettings']['editable_title'] = true;
//- - if set all titles editable

$config['newObjectPlacement'] = 'bottom';

$config['uiresize'] =  array(
	'width'=>240,
	'height'=>120,
	'prefix' => 'uithumb',
	'forceDimension'=>'width',
	'crop'=>true,
);

$config['subModules'] =  array(
	'navigation'=>'navigation',
);


$config['stagingmediapath'] = 'staging/application/media/';
$config['basemediapath'] = 'application/media/';


$config['imagequality'] = 85;

$config['enableSlugEditing'] = true;

$config['baseName'] = 'mop_cms';

return $config;
