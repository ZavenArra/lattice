<?

$config['authrole'] = 'admin'; //access controlled by default for safety

$config['resources']['librarycss'] = array(
	'modules/lattice/resources/thirdparty/960Grid/reset.css',
	'modules/lattice/resources/thirdparty/960Grid/960.css',
	'modules/lattice/resources/css/lattice_cms.css',
);
$config['resources']['libraryjs'] = array(
	'modules/lattice/resources/thirdparty/mootools/mootools.js',
	'modules/lattice/resources/thirdparty/mootools/mootools-more.js',
	//these are required by LatticeUI
	'modules/lattice/resources/js/LatticeCore.js',
	'modules/lattice/resources/js/LatticeUI.js',
	'modules/lattice/resources/js/LatticeModules.js',
	'modules/lattice/resources/js/usermanagement.js',
);

$config['layout'] = 'LayoutAdmin';
//$config['authrole'] = 'admin';

/*
 * Config: ['resources']['css']
 */
$config['resources']['css'] = array( );

/*
 * Config: ['resources']['js']
 */
$config['resources']['js'] = array(
	'modules/lattice/resources/js/list.js'
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
$config['defaultRoles'] = 'client';
$config['superuserEdit'] = true;

return $config;
