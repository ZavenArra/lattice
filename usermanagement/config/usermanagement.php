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
	'lattice/latticejs/LatticeCore.js',
	'lattice/latticejs/LatticeUI.js',
	'lattice/latticejs/LatticeModules.js'
);

$config['layout'] = 'LayoutAdmin';
//$config['authrole'] = 'admin';

/*
 * Config: ['resources']['css']
 */
$config['resources']['css'] = array( 
   	'lattice/latticecms/views/css/lattice_cms.css'
);

/*
 * Config: ['resources']['js']
 */
$config['resources']['js'] = array(
	'lattice/latticecms/views/js/list.js'
);

/*
 * Config: ['passwordchangeemail']['subject']
 * The subject of the password reset email
 */
$config['passwordchangeemail']['subject'] = 'LatticeCMS Password Changed';

/*
 * Config: ['managedRoles']
 * The roles that the admin can select from when creating a user. 
 * Array is of format array( {label} => {role unique text key})
 */
$config['managedRoles'] = array('Admin'=>'admin');

return $config;
