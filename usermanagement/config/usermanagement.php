<?

$config['resources']['librarycss'] = array(
	'lattice/thirdparty/960Grid/reset.css',
	'lattice/thirdparty/960Grid/960.css'
);
$config['resources']['libraryjs'] = array(
	'lattice/thirdparty/mootools/mootools.js',
	'lattice/thirdparty/mootools/mootools-more.js',
	//these are required by MoPUI
	'lattice/thirdparty/digitarald/fancyupload/Swiff.Uploader.js',
	'lattice/thirdparty/arian/datepicker/Picker.js',
	'lattice/thirdparty/arian/datepicker/Picker.Attach.js',
	'lattice/thirdparty/arian/datepicker/Picker.Date.js',
	'lattice/mopjs/MoPCore.js',
	'lattice/mopjs/MoPUI.js',
	'lattice/mopjs/MoPModules.js'
);

$config['layout'] = 'LayoutAdmin';
//$config['authrole'] = 'admin';

/*
 * Config: ['resources']['css']
 */
$config['resources']['css'] = array( 
   	'lattice/mopcms/views/css/mop_cms.css'
);

/*
 * Config: ['resources']['js']
 */
$config['resources']['js'] = array(
	'lattice/mopcms/views/js/list.js'
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
$config['managedRoles'] = array('Admin'=>'admin', 'Editor Test'=>'editor');

return $config;
