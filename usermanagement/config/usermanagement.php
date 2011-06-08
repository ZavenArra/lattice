<?

//this could be something like a standard include?
$config['resources']['librarycss'] = array(
	'modules/mop/thirdparty/960Grid/reset.css',
	'modules/mop/thirdparty/960Grid/960.css'
);
$config['resources']['libraryjs'] = array(
	'modules/mop/thirdparty/mootools/mootools-1.2.4-core-nc.js',
	'modules/mop/thirdparty/mootools/mootools-more.js',
	'modules/mop/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',
	'modules/mop/thirdparty/monkeyphysics/datepicker-nc.js',
	'modules/mop/MoPCore.js',
	'modules/mop/MoPUI.js',
	'modules/mop/MoPModules.js'
);

$config['layout'] = 'LayoutAdmin';
//$config['authrole'] = 'admin';

/*
 * Config: ['resources']['css']
 */
$config['resources']['css'] = array( 
	);

/*
 * Config: ['resources']['js']
 */
$config['resources']['js'] = array(
	'modules/cms/views/list.js'
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

return $config;
