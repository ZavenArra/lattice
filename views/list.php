<div id="list_<?=$list_object_id;?>" data-objectid="<?=$list_object_id;?>" class="module <?=$class;?> classPath-lattice_modules_List clearFix">
	<?if (isset($label) && $label):?>
	<label class='listLabel'><?=$label;?></label>
	<?endif;?>
	<div class="listcontrol controls top clearfix">
		<?foreach($addable_objects as $addable_object):?>
		<a href="addObject/<?=$list_object_id;?>/<?=$addable_object['object_type_id'];?>" class="addItem button"><?=$addable_object['object_type_add_text'];?></a>
		<?endforeach;?>
	</div>	
	<ul class="listing clearfix <?=$label;?>"><?=$items;?></ul>
	<div class="listcontrol controls bottom clearfix">
		<?foreach($addable_objects as $addable_object):?>
		<a href="addObject/<?=$list_object_id;?>/<?=$addable_object['object_type_id'];?>" class="addItem button"><?=$addable_object['object_type_add_text'];?></a>	
		<?endforeach;?>
	</div>
</div>
