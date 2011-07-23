<?

$config['resources']['librarycss'] = array(
	'moplib/thirdparty/960Grid/reset.css',
	'moplib/thirdparty/960Grid/960.css'
);
$config['resources']['libraryjs'] = array(
	'moplib/thirdparty/mootools/mootools.js',
	'moplib/thirdparty/mootools/mootools-more.js',
	//these are required by MoPUI
	'moplib/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',
	'moplib/thirdparty/arian/datepicker/Picker.js',
	'moplib/thirdparty/arian/datepicker/Picker.Attach.js',
	'moplib/thirdparty/arian/datepicker/Picker.Date.js',
	'moplib/mopjs/MoPCore.js',
	'moplib/mopjs/MoPUI.js',
	'moplib/mopjs/MoPModules.js'
);

$config['layout'] = 'LayoutAdmin';
//$config['authrole'] = 'admin';

/*
 * Config: ['resources']['css']
 */
$config['resources']['css'] = array( 
   	'moplib/mopcms/views/css/mop_cms.css'
);

/*
 * Config: ['resources']['js']
 */
$config['resources']['js'] = array(
	'moplib/mopcms/views/js/list.js'
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
$config['managedRoles'] = array('Admin'=>'admin', 'Fruit Bat'=>'fruitbat');

return $config;
