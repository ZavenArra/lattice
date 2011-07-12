<?

$config['resources']['librarycss'] = array(
	'moplib/thirdparty/960Grid/reset.css',
	'moplib/thirdparty/960Grid/960.css'
);
$config['resources']['libraryjs'] = array(
	'moplib/thirdparty/mootools/mootools.js',
	'moplib/thirdparty/mootools/mootools-more.js',
	//these are required by MoPUI
	'moplib/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',
	'moplib/thirdparty/arian/datepicker/Picker.js',
	'moplib/thirdparty/arian/datepicker/Picker.Attach.js',
	'moplib/thirdparty/arian/datepicker/Picker.Date.js',
	//include textboxlist here
	'moplib/mopjs/MoPCore.js',
	'moplib/mopjs/MoPUI.js',
	'moplib/mopjs/MoPModules.js',
	'moplib/navigation/views/js/navigationDataSourceInterface.js',
);

$config['resources']['js'] = array(
	'moplib/mopcms/views/js/list.js',
);


$config['defaultsettings']['editable_title'] = true;
//- - if set all titles editable

$config['newObjectPlacement'] = 'bottom';

$config['uiresizes'] =  array(
	'uiresize' => array(
		'width'=>240,
		'height'=>120,
		'prefix' => 'uithumb',
		'forceDimension'=>'width',
		'crop'=>true,
	)
);

$config['navigationRequest'] = 'navigation';


$config['stagingmediapath'] = 'staging/application/media/';
$config['basemediapath'] = 'application/media/';


$config['imagequality'] = 85;

$config['enableSlugEditing'] = true;

$config['baseName'] = 'mop_cms';

return $config;
