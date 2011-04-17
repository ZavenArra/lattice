<?

$config['resources']['librarycss'] = array(
	'modules/mop/thirdparty/960Grid/reset.css',
	'modules/mop/thirdparty/960Grid/960.css'
);
$config['resources']['libraryjs'] = array(
	'modules/mop/thirdparty/mootools/mootools-1.2.4-core-nc.js',
	'modules/mop/thirdparty/mootools/mootools-more.js',
	'modules/mop/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',
	'modules/mop/thirdparty/monkeyphysics/datepicker-nc.js',
	'modules/mop/MoPCore.js',
	'modules/mop/MoPUI.js',
	'modules/mop/MoPModules.js'
);

$config['layout'] = 'LayoutAdmin';
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

$config['navigationRequest'] = 'navigation';


$config['stagingmediapath'] = 'staging/application/media/';
$config['basemediapath'] = 'application/media/';


$config['imagequality'] = 85;

$config['enableSlugEditing'] = true;

$config['baseName'] = 'mop_cms';

return $config;
