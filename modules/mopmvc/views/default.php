<h1><?=$content['main']['title'];?></h1>
<?
//this also implies that name is a templatename
ob_start();
foreach(mop::config('backend', 
	sprintf('//template[@name="%s"]/elements/*', ORM::Factory('page', $content['main']['id'])->template->templatename )) as $element){
		frontend::makeHtmlElement($element, "\$content['main']");
}
$html = ob_get_contents();
ob_end_clean();
eval('?> '.$html.' <?');
?>



		
