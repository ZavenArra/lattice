<h1><?=$content['main']['title'];?></h1>
<?
//this also implies that name is a objecttypename
ob_start();
foreach(core_lattice::config('objects', 
	sprintf('//objectType[@name="%s"]/elements/*', Graph::object($content['main']['id'])->objecttype->objecttypename )) as $element){
		frontend_core::make_html_element($element, "\$content['main']");
}
$html = ob_get_contents();
ob_end_clean();

eval('?> '.$html.' <?');

?>



		
