<?

$config = array(
'default'=>array(),
);
$config['layout'] = 'LayoutLogin';
$config['layoutActions'] = array('index');


$config['resources']['css'] = array(
	'lattice/lattice/resources/thirdparty/960Grid/reset.css',
	'lattice/lattice/resources/thirdparty/960Grid/960.css',
	'lattice/lattice/resources/css/lattice_cms.css'
);


$config['resources']['js'] = array(
	'lattice/lattice/resources/thirdparty/mootools/mootools.js',
	'lattice/lattice/resources/thirdparty/mootools/mootools-more.js',

);



return $config;
