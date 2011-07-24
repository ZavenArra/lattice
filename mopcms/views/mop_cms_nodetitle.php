<div class="objectTitle">	

	<div class="<?if($allowTitleEdit):?>ui-Text<?endif;?> grid_8 rows-1 field-title">
		<h2 class="ipe h2"><?=$title;?></h2>
	</div>

	<?if($allowDelete):?>
		<a class="icon deleteLink" href="#" title="Delete this object."></a>
	<?endif;?>

	<?if(Kohana::config('cms.enableSlugEditing')):?>
		<div class="ui-Text grid_4 field-slug">
			<label>Slug</label>
			<p class="ipe p"><?=$slug;?></p>
		</div>
 	<?endif;?>

	<div class="clear"></div>

</div>
