<?

$config['resources']['librarycss'] = array(
	'moplib/mopjs/thirdparty/960Grid/reset.css',
	'moplib/mopjs/thirdparty/960Grid/960.css'
);
$config['resources']['libraryjs'] = array(
	'moplib/mopjs/thirdparty/mootools/mootools.js',
	'moplib/mopjs/thirdparty/mootools/mootools-more.js',
	'moplib/mopjs/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',
	'moplib/mopjs/thirdparty/arian/datepicker/Picker.js',
	'moplib/mopjs/thirdparty/arian/datepicker/Picker.Attach.js',
	'moplib/mopjs/thirdparty/arian/datepicker/Picker.Date.js',
	//include textboxlist here
	'moplib/mopjs/MoPCore.js',
	'moplib/mopjs/MoPUI.js',
	'moplib/mopjs/MoPModules.js',
	'moplib/mopcms/views/js/list.js',
	'moplib/navigation/views/js/NavigationDataSourceInterface.js'
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
