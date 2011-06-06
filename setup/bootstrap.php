<?php



/**  
 * Set Correct Base_Url
 */
//this is a convention that eases things for us, but doesn't break interoperability of the mop modules
$path = substr($_SERVER['SCRIPT_NAME'],0,-9);

Kohana::init(array(
  'base_url'   => $path,
));


/**  
 * Enable MoPLib Modules
 */
Kohana::modules(array(
	'mopcms' => 'moplib/mopcms',
	'mopcore' => 'moplib/mopcore',
	'mopjs'  => 'moplib/mopjs',
	'tools' => 'moplib/tools',
	'mopfrontend' => 'moplib/mopfrontend',
	'navigation' => 'moplib/navigation',
	'mopui' => 'moplib/mopui',
	'usermanagement' => 'moplib/usermanagement',
);
