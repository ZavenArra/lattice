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
	'lattice/thirdparty/arian/datepicker/Picker.js',
	'lattice/latticejs/LatticeCore.js',
	'lattice/latticejs/LatticeModules.js',
	'lattice/latticejs/LatticeUI.js',
	'lattice/navigation/views/js/navigationDataSourceInterface.js',
);

$config['resources']['js'] = array(
	'lattice/latticecms/views/js/list.js',
);


$config['defaultsettings']['editable_title'] = true;
//- - if set all titles editable

$config['newObjectPlacement'] = 'bottom';

$config['uiresizes'] =  array(
	'uithumb' => array(
		'width'=>240,
		'height'=>120,
		'prefix' => 'uithumb',
		'forceDimension'=>'width',
		'crop'=>true,
    'aspectFollowsOrientation'=>false
	)
);

$config['navigationRequest'] = 'navigation';


$config['stagingmediapath'] = 'staging/application/media/';
$config['basemediapath'] = 'application/media/';

$config['enableSlugEditing'] = false;

$config['baseName'] = 'lattice_cms';
$config['localization'] = FALSE;




return $config;
