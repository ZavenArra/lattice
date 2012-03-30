<?

$config['authrole'] = 'admin'; //access controlled by default for safety

$config['resources']['librarycss'] = array(
	'lattice/lattice/resources/thirdparty/960Grid/reset.css',
	'lattice/lattice/resources/thirdparty/960Grid/960.css'
);
$config['resources']['libraryjs'] = array(
	'lattice/lattice/resources/thirdparty/mootools/mootools.js',
	'lattice/lattice/resources/thirdparty/mootools/mootools-more.js',
	//these are required by LatticeUI
	'lattice/lattice/resources/js/LatticeCore.js',
	'lattice/lattice/resources/js/LatticeUI.js',
	'lattice/lattice/resources/js/LatticeModules.js',
	'lattice/usermanagement/resources/usermanagement.js',
);

$config['layout'] = 'LayoutAdmin';
//$config['authrole'] = 'admin';

/*
 * Config: ['resources']['css']
 */
$config['resources']['css'] = array( 
   	'lattice/lattice/resources/css/lattice_cms.css'
);

/*
 * Config: ['resources']['js']
 */
$config['resources']['js'] = array(
	'lattice/lattice/resources/js/list.js'
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
