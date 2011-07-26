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
	'mopcms' => 'lattice/mopcms',
	'mopcore' => 'lattice/mopcore',
	'mopjs'  => 'lattice/mopjs',
	'tools' => 'lattice/tools',
	'mopfrontend' => 'lattice/mopfrontend',
	'navigation' => 'lattice/navigation',
	'mopui' => 'lattice/mopui',
	'usermanagement' => 'lattice/usermanagement',
);
