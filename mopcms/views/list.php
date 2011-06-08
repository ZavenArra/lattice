<div id="list_<?=$listObjectId;?>" class="module <?=$class;?> classPath-mop_modules_List">
   <!-- changed id to list, since this is what controls submission
   but of course this can't be the id, since there can be multiple lists in the page
   instance idea needs to be changes -->
	
	<?if(isset($label) && $label):?>
	<label><?=$label;?></label>
	<?endif;?>
	
	<ul class="listing">
		<?=$items;?>
	</ul>

	<div class="controls">
		<a href="#" class="addItem button grid_2">Add another?</a>
	</div>

	

</div>


