<?

$config['displaycontroller'] = 'DisplayAdmin';
$config['authrole'] = 'admin';

$config['defaultsettings']['editable_title'] = true;
//- - if set all titles editable

$config['newObjectPlacement'] = 'bottom';

$config['uiresize'] =  array(
	'width'=>150,
	'height'=>75,
	'prefix' => 'uithumb',
	'forcewidth'=>true,
	'crop'=>true,
);

$config['subModules'] =  array(
		'navigation'=>'navigation',

	);
