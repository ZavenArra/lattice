<div class="pageTitle grid_12">	

	<div class="<?if($allowTitleEdit):?>ui-IPE<?endif;?> grid_8 rows-1 field-title">
		<h2 class="ipe h2"><?=$title;?></h2>
	</div>

	<?if($allowDelete):?>
		<a class="icon deleteLink" href="#" title="Delete this page."></a>
	<?endif;?>

<?if(Kohana::config('cms.enableSlugEditing')):?>
	<div class="ui-IPE grid_4 field-slug">
		<label>Edit Slug</label>
		<p class="ipe p hidden"><?=$slug;?></p>
	</div>
<?endif;?>

	<div class="clear"></div>

</div>
