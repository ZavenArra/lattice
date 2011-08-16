<div class="objectTitle">	
	<div class="<?if($allowTitleEdit):?>ui-Text field-title<?endif;?> grid_7 rows-1">
		<input type='text' class='og title<?=$translationModifier;?> h2' value="<?=$title;?>" />
	</div>
	<?if(Kohana::config('cms.enableSlugEditing')):?>
	<div class="ui-Text field-slug<?=$translationModifier;?> clear">
				<input class="og p" value="<?=$slug;?>" type="text" />
	</div>
 	<?endif;?>

	<div class="clear"></div>

</div>
