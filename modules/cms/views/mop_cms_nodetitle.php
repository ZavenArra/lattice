<div class="pageTitle sixCol">

	<div class="<?if($allowTitleEdit):?>ui-IPE<?endif;?> fourCol floatLeft rows-1 field-title">
		<h2 class="ipe h2"><?=$title;?></h2>
	</div>

	<?if($allowDelete):?>
		<a class="icon deleteLink" href="#" title="Delete this page."></a>
	<?endif;?>

<?if(Kohana::config('cms.enableSlugEditing')):?>
	<div class="ui-IPE twoCol field-slug floatLeft	">
		<label>Edit Slug</label>
		<p class="ipe p hidden"><?=$slug;?></p>
	</div>
<?endif;?>

	<div class="clear"></div>

</div>
