<?

$config['resources']['librarycss'] = array(
	'modules/lattice/resources/thirdparty/960Grid/reset.css',
	'modules/lattice/resources/thirdparty/960Grid/960.css',
	'modules/lattice/resources/thirdparty/arian/datepicker/datepicker.css'
);
$config['resources']['libraryjs'] = array(

	'modules/lattice/resources/thirdparty/mootools/mootools.js',
	'modules/lattice/resources/thirdparty/mootools/mootools-more.js',

	//these are required by LatticeUI
	'modules/lattice/resources/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',
	'modules/lattice/resources/thirdparty/arian/datepicker/Locale.en-US.DatePicker.js',
	'modules/lattice/resources/thirdparty/arian/datepicker/Picker.js',
	'modules/lattice/resources/thirdparty/arian/datepicker/Picker.Attach.js',
	'modules/lattice/resources/thirdparty/arian/datepicker/Picker.Date.js',
	'modules/lattice/resources/thirdparty/arian/datepicker/Picker.Date.Range.js',

	'modules/lattice/resources/js/LatticeCore.js',
	'modules/lattice/resources/js/LatticeModules.js',
	'modules/lattice/resources/js/LatticeUI.js',

	'modules/lattice/resources/js/navigationDataSourceInterface.js',
);

$config['resources']['js'] = array(
	'modules/lattice/resources/js/list.js',
	'modules/lattice/resources/js/associator.js',
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

$config['baseName'] = 'modules_cms';
$config['localization'] = FALSE;




return $config;
