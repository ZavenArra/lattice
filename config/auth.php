<?php defined('SYSPATH') or die('No direct access allowed.');


$config = array(
	'driver'       => 'orm',
	'hash_method'  => 'sha256',
	'hash_key'     => 'asdfasdfaxxx9283r239f28h39fh29fhawpofiasfasdfq23rawefaw3raweasf',
	'lifetime'     => 1209600,
	'session_key'  => 'auth_user',
);

$config['layout'] = 'layout_login';

$config['resources']['librarycss'] = array(
	'modules/lattice/resources/thirdparty/960Grid/reset.css',
	'modules/lattice/resources/thirdparty/960Grid/960.css',
	'modules/lattice/resources/css/lattice_cms.css'
);


$config['resources']['js'] = array(
	'modules/lattice/resources/thirdparty/mootools/mootools.js',
	'modules/lattice/resources/thirdparty/mootools/mootools-more.js',

);

$config['redirect'] = '';


return $config;
