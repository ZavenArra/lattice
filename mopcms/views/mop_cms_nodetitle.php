<div class="objectTitle">	
	<div class="<?if($allowTitleEdit):?>ui-Text field-title<?endif;?> grid_7 rows-1">
		<input type='text' class='og title h2' value="<?=$title;?>" />
	</div>
	<?if(Kohana::config('cms.enableSlugEditing')):?>
	<div class="ui-Text grid_2 field-slug clear">
		<p class="ipe discrete p"><?=$slug;?></p>
	</div>
 	<?endif;?>

	<div class="clear"></div>

</div>
