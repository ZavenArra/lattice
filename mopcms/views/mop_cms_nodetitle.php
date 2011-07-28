<div class="objectTitle">	
	<div class="clearFix">
		<div class="<?if($allowTitleEdit):?>ui-Text<?endif;?> grid_7 rows-1 field-title">
			<h2 class="ipe h2"><?=$title;?></h2>
		</div>
	</div>
	<?if(Kohana::config('cms.enableSlugEditing')):?>
		<div class="ui-Text grid_2 field-slug">
			<p class="ipe discrete p"><?=$slug;?></p>
		</div>
 	<?endif;?>

	<div class="clear"></div>

</div>
