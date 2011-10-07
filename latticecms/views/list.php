<div id="list_<?=$listObjectId;?>" data-objectid="<?=$listObjectId;?>" class="module <?=$class;?> classPath-lattice_modules_List">
   <!-- changed id to list, since this is what controls submission
   but of course this can't be the id, since there can be multiple lists in the object
   instance idea needs to be changes -->
	<?if(isset($label) && $label):?>
	<label class='listLabel'><?=$label;?></label>
	<?endif;?>
<?foreach($addableObjects as $addableObject):?>
	<div class="controls clearFix"><a href="addObject/<?=$listObjectId;?>/<?=$addableObject['objectTypeId'];?>" class="addItem button"><?=$addableObject['objectTypeAddText'];?></a></div>	
<?endforeach;?>
	<ul class="listing"><?=$items;?></ul>
<?foreach($addableObjects as $addableObject):?>
	<div class="controls clearFix"><a href="addObject/<?=$listObjectId;?>/<?=$addableObject['objectTypeId'];?>" class="addItem button"><?=$addableObject['objectTypeAddText'];?></a></div>	
<?endforeach;?>
</div>
