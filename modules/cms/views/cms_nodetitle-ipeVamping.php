<div class="pageTitle fourCol">

	<?if($editable_title):?>
		<?=mopui::IPE( 'title', 'threeCol floatLeft rows-1 field-title marshal-cms', 'h2', $title, 'Page Title' );?>
	<?else:?>
		<div class="threeCol floatLeft rows-1 field-title marshal-cms"><h2 class="ipe"><?=$title;?></h2></div>
	<?endif;?>

	
	<?if($allow_delete):?>
		<a class="icon deleteLink" href="#" title="Delete this page."></a>
	<?endif;?>
	
	<div class="clear"></div>

</div>
