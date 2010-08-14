<div class="ui-Pulldown field-<?=$field;?> <?=$class;?>">
	<label class="groupLabel"><?=$label;?></label>
	<?=form::dropdown($field, $options, $value, 'class="pulldown field-'.$field.'"');?>
</div>
