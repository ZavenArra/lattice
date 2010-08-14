<?

$config['displaycontroller'] = 'DisplayAdmin';
$config['authrole'] = 'admin';
/*
 * Config: ['resources']['css']
 */
$config['resources']['css'] = array( 
	);

/*
 * Config: ['resources']['js']
 */
$config['resources']['js'] = array(
	'modules/listmodule/views/listmodule.js'
);

/*
 * Config: ['passwordchangeemail']['subject']
 * The subject of the password reset email
 */
$config['passwordchangeemail']['subject'] = 'MoPCMS Password Changed';

/*
 * Config: ['managedRoles']
 * The roles that the admin can select from when creating a user. 
 * Array is of format array( {label} => {role unique text key})
 */
$config['managedRoles'] = array();

//array('Call Center'=>'callcenter', 'Admin'=>'admin');
