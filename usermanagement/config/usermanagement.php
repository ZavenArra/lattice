<?

$config['authrole'] = 'admin'; //access controlled by default for safety

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
	'lattice/lattice/views/js/LatticeCore.js',
	'lattice/lattice/views/js/LatticeUI.js',
	'lattice/lattice/views/js/LatticeModules.js'
);

$config['layout'] = 'LayoutAdmin';
//$config['authrole'] = 'admin';

/*
 * Config: ['resources']['css']
 */
$config['resources']['css'] = array( 
   	'lattice/lattice/views/css/lattice_cms.css'
);

/*
 * Config: ['resources']['js']
 */
$config['resources']['js'] = array(
	'lattice/lattice/views/js/list.js'
);

/*
 * Config: ['passwordchangeemail']['subject']
 * The subject of the password reset email
 */
$config['passwordChangeEmail']['subject'] = 'LatticeCMS Password Changed';
$config['passwordChangeEmail']['from'] = "Lattice Usermanagement <usermanagement@madeofpeople.org>";

/*
 * Config: ['managedRoles']
 * The roles that the admin can select from when creating a user. 
 * Array is of format array( {label} => {role unique text key})
 */
$config['managedRoles'] = array('Admin'=>'admin');
$config['defaultRoles'] = 'admin';
$config['superuserEdit'] = true;

return $config;
