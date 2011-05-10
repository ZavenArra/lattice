<?

$config['resources']['librarycss'] = array(
	'modules/mop/thirdparty/960Grid/reset.css',
	'modules/mop/thirdparty/960Grid/960.css'
);
$config['resources']['libraryjs'] = array(
	'modules/mop/thirdparty/mootools/mootools.js',
	'modules/mop/thirdparty/mootools/mootools-more.js',
	'modules/mop/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',
	'modules/mop/thirdparty/monkeyphysics/datepicker.js',
	'modules/mop/MoPCore.js',
	'modules/mop/MoPUI.js',
	'modules/mop/MoPModules.js',
	'modules/mopcms/views/js/list.js',
	'modules/navigation/views/js/NavigationDataSourceInterface.js'
);


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
