<div class="objectTitle">	

	<?if(Kohana::config('cms.preview')):?>
  	<a class='button floatRight' href="#">Preview this Page</a>
	<?endif;?>

	<div class="<?if($allowTitleEdit):?>ui-Text<?endif;?> grid_7" data-ismultiline='false' data-field='title'>
		<input type='text' class='og title<?=$translationModifier;?> h2' value="<?=$title;?>" />
	</div>
	<?if(Kohana::config('cms.enableSlugEditing')):?>
	<?/*<?=$translationModifier;?> //may not actually need this, since modules only look within themselves... still its good to have*/?>
	<div class="ui-Text discrete grid_2" data-ismultiline='false' data-field='slug'>
				<input type="text" class="og p" value="<?=$slug;?>" />
	</div>
 	<?endif;?>
	
	<div class="clear"></div>

</div>

