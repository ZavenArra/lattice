<div id="list_<?=$listObjectId;?>" data-objectid="<?=$listObjectId;?>" class="module <?=$class;?> classPath-lattice_modules_List clearFix">
	<?if(isset($label) && $label):?>
	<label class='listLabel'><?=$label;?></label>
	<?endif;?>
	<div class="controls clearFix">
		<?foreach($addableObjects as $addableObject):?>
		<a href="addObject/<?=$listObjectId;?>/<?=$addableObject['objectTypeId'];?>" class="addItem button"><?=$addableObject['objectTypeAddText'];?></a>
		<?endforeach;?>
	</div>	
	<ul class="listing"><?=$items;?></ul>
	<div class="controls clearFix">
		<?foreach($addableObjects as $addableObject):?>
		<a href="addObject/<?=$listObjectId;?>/<?=$addableObject['objectTypeId'];?>" class="addItem button"><?=$addableObject['objectTypeAddText'];?></a>	
		<?endforeach;?>
	</div>
</div>
