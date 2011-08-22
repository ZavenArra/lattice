<div class="ui-Pulldown <?=$class;?>" data-field="<?=$field;?>">
	<label class="groupLabel"><?=$label;?></label>
	<?=form::dropdown($field, $options, $value, 'class="pulldown field-'.$field.'"');?>
</div>
