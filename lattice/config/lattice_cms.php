<?

$config['resources']['librarycss'] = array(
	'lattice/lattice/views/thirdparty/960Grid/reset.css',
	'lattice/lattice/views/thirdparty/960Grid/960.css'
);
$config['resources']['libraryjs'] = array(
	'lattice/lattice/views/thirdparty/mootools/mootools.js',
	'lattice/lattice/views/thirdparty/mootools/mootools-more.js',
	//these are required by LatticeUI
	'lattice/lattice/views/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',
	'lattice/lattice/views/thirdparty/arian/datepicker/Picker.js',
	'lattice/lattice/views/thirdparty/arian/datepicker/Picker.Attach.js',
	'lattice/lattice/views/thirdparty/arian/datepicker/Picker.Date.js',
	'lattice/lattice/views/thirdparty/arian/datepicker/Picker.js',
	'lattice/lattice/LatticeCore.js',
	'lattice/lattice/LatticeModules.js',
	'lattice/lattice/LatticeUI.js',
	'lattice/navigation/views/js/navigationDataSourceInterface.js',
);

$config['resources']['js'] = array(
	'lattice/lattice/views/js/list.js',
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
