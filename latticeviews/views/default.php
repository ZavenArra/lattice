<h1><?=$content['main']['title'];?></h1>
<?
//this also implies that name is a objecttypename
ob_start();
foreach(lattice::config('objects', 
	sprintf('//objectType[@name="%s"]/elements/*', Graph::object($content['main']['id'])->objecttype->objecttypename )) as $element){
		frontend::makeHtmlElement($element, "\$content['main']");
}
$html = ob_get_contents();
ob_end_clean();
eval('?> '.$html.' <?');
?>



		
