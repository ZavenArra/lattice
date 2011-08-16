<?

$config['resources']['librarycss'] = array(
	'lattice/thirdparty/960Grid/reset.css',
	'lattice/thirdparty/960Grid/960.css'
);
$config['resources']['libraryjs'] = array(
	'lattice/thirdparty/mootools/mootools.js',
	'lattice/thirdparty/mootools/mootools-more.js',
	//these are required by LatticeUI
	'lattice/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',
	'lattice/thirdparty/arian/datepicker/Picker.js',
	'lattice/thirdparty/arian/datepicker/Picker.Attach.js',
	'lattice/thirdparty/arian/datepicker/Picker.Date.js',
	//include textboxlist here
	'lattice/latticejs/LatticeCore.js',
	'lattice/latticejs/LatticeUI.js',
	'lattice/latticejs/LatticeModules.js',
	'lattice/navigation/views/js/navigationDataSourceInterface.js',
);

$config['resources']['js'] = array(
	'lattice/latticecms/views/js/list.js',
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

$config['baseName'] = 'lattice_cms';

//module-wide settings
$config['dependencies'] = array(
	'latticeauth',
	'latticecore',
	'rootgraph',
	'cms',
	'latticecms',
);



return $config;
