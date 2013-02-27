<div id="list_<?=$listObjectId;?>" data-objectid="<?=$listObjectId;?>" class="module <?=$class;?> classPath-lattice_modules_List clearFix">
	<?if(isset($label) && $label):?>
	<label class='listLabel'><?=$label;?></label>
	<?endif;?>
	<div class="listcontrol controls top clearfix">
		<?foreach($addableObjects as $addableObject):?>
		<a href="addObject/<?=$listObjectId;?>/<?=$addableObject['objectTypeId'];?>" class="addItem button"><?=$addableObject['objectTypeAddText'];?></a>
		<?endforeach;?>
	</div>	
	<ul class="listing clearfix <?=$label;?>"><?=$items;?></ul>
	<div class="listcontrol controls bottom clearfix">
		<?foreach($addableObjects as $addableObject):?>
		<a href="addObject/<?=$listObjectId;?>/<?=$addableObject['objectTypeId'];?>" class="addItem button"><?=$addableObject['objectTypeAddText'];?></a>	
		<?endforeach;?>
	</div>
</div>
