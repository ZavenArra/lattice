<?php defined('SYSPATH') or die('No direct access allowed.');


$config = array(
	'driver'       => 'orm',
	'hash_method'  => 'sha256',
	'hash_key'     => 'asdfasdfaxxx9283r239f28h39fh29fhawpofiasfasdfq23rawefaw3raweasf',
	'lifetime'     => 1209600,
	'session_key'  => 'auth_user',
);

$config['layout'] = 'LayoutLogin';

$config['resources']['css'] = array(
	'lattice/thirdparty/960Grid/reset.css',
	'lattice/thirdparty/960Grid/960.css',
	'lattice/lattice/views/css/lattice_cms.css'
);


$config['resources']['js'] = array(
	'lattice/thirdparty/mootools/mootools.js',
	'lattice/thirdparty/mootools/mootools-more.js',

);

$config['redirect'] = '';


return $config;
