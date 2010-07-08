<?
require('../modules/gms/gms.class.php');
class gms_work extends gms{

	var	$setup = array (
	array(
		'tag' => '',
		'width'=>708,
		'height'=>329,
		'path'=> "../media/gallerymodule/galleryimages/",
		'forceheight'=>true,
		),
	array(
		'tag' => 'userthumb',
		'width'=> 90,
		'height'=>40,
		'path'=> "../media/gallerymodule/galleryimagesuserthumbs/",
		'forcewidth'=> true,
		),
	 array(
		'tag' => 'thumb',
 		'width'=> 160,
 		'height'=>117,
 		'path'=> "../media/gallerymodule/galleryimagesthumbs/",
 		'forceheight'=> true,
 	),

	);

	function gms_work($featurettename){
		parent::gms($featurettename);
	}

	function buildFeaturette(){
		parent::buildFeaturette();
	}

	function loadContent(){
		parent::loadContent('gms');
	}

	function loadTemplate( $module = 'gms'){
		parent::loadTemplate($module);
	}

	function loadCSS($module = 'gms'){
		parent::loadCSS($module);
	}

	function loadJS($module='gms'){
		parent::loadJS($module);
	}


}

?>
