<?

$config['resources']['librarycss'] = array(
	'lattice/lattice/resources/thirdparty/960Grid/reset.css',
	'lattice/lattice/resources/thirdparty/960Grid/960.css',
	'lattice/lattice/resources/thirdparty/arian/datepicker/Source/datepicker.css'
);
$config['resources']['libraryjs'] = array(

	'lattice/lattice/resources/thirdparty/mootools/mootools.js',
	'lattice/lattice/resources/thirdparty/mootools/mootools-more.js',

	//these are required by LatticeUI

	'lattice/lattice/resources/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',

	'lattice/lattice/resources/thirdparty/arian/datepicker/Source/Locale.en-US.DatePicker.js',
	'lattice/lattice/resources/thirdparty/arian/datepicker/Source/Picker.js',
	'lattice/lattice/resources/thirdparty/arian/datepicker/Source/Picker.Attach.js',
	'lattice/lattice/resources/thirdparty/arian/datepicker/Source/Picker.Date.js',
	'lattice/lattice/resources/thirdparty/arian/datepicker/Source/Picker.Date.Range.js',

	'lattice/lattice/resources/js/LatticeCore.js',
	'lattice/lattice/resources/js/LatticeModules.js',
	'lattice/lattice/resources/js/LatticeUI.js',

	'lattice/navigation/resources/js/navigationDataSourceInterface.js',
);

$config['resources']['js'] = array(
	'lattice/lattice/resources/js/list.js',
	'lattice/lattice/resources/js/associator.js',
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
