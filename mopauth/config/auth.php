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
	'moplib/thirdparty/960Grid/reset.css',
	'moplib/thirdparty/960Grid/960.css',
	'moplib/mopcms/views/css/mop_cms.css'
);


$config['resources']['js'] = array(
	'moplib/thirdparty/mootools/mootools.js',
	'moplib/thirdparty/mootools/mootools-more.js',

);

$config['redirect'] = 'cms';


return $config;
