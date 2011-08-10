<?

$config['resources']['librarycss'] = array(
	'lattice/thirdparty/960Grid/reset.css',
	'lattice/thirdparty/960Grid/960.css'
);
$config['resources']['libraryjs'] = array(
	'lattice/thirdparty/mootools/mootools.js',
	'lattice/thirdparty/mootools/mootools-more.js',
	//these are required by MoPUI
	'lattice/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',
	'lattice/thirdparty/arian/datepicker/Picker.js',
	'lattice/thirdparty/arian/datepicker/Picker.Attach.js',
	'lattice/thirdparty/arian/datepicker/Picker.Date.js',
	//include textboxlist here
	'lattice/mopjs/MoPCore.js',
	'lattice/mopjs/MoPUI.js',
	'lattice/mopjs/MoPModules.js',
	'lattice/navigation/views/js/navigationDataSourceInterface.js',
);

$config['resources']['js'] = array(
	'lattice/mopcms/views/js/list.js',
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

$config['enableSlugEditing'] = true;

$config['baseName'] = 'mop_cms';

//module-wide settings
$config['dependencies'] = array(
	'mopauth',
	'mopcore',
	'rootgraph',
	'cms',
	'mopcms',
);



return $config;
