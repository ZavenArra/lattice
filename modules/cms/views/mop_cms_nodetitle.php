<div class="pageTitle sixCol">

	<div class="<?if($editable_title):?>ui-IPE<?endif;?> fourCol floatLeft rows-1 field-title">
		<h2 class="ipe h2"><?=$title;?></h2>
	</div>

	<?if($allowDelete):?>
		<a class="icon deleteLink" href="#" title="Delete this page."></a>
	<?endif;?>

	<div class="ui-IPE twoCol field-slug floatLeft	">
		<label>Edit Slug</label>
		<p class="ipe p hidden"><?=$slug;?></p>
	</div>

	<div class="clear"></div>

</div>
