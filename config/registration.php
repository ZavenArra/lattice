<?

$config = array(
'default'=>array(),
);
$config['layout'] = 'LayoutLogin';
$config['layoutActions'] = array('index');


$config['resources']['css'] = array(
	'modules/lattice/resources/thirdparty/960Grid/reset.css',
	'modules/lattice/resources/thirdparty/960Grid/960.css',
	'modules/lattice/resources/css/lattice_cms.css'
);


$config['resources']['js'] = array(
	'modules/lattice/resources/thirdparty/mootools/mootools.js',
	'modules/lattice/resources/thirdparty/mootools/mootools-more.js',

);



return $config;