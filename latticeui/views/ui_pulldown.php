<div class="ui-Pulldown <?=$class;?>" data-field="<?=$name;?>">
	<label class="groupLabel"><?=$label;?></label>
	<?=form::dropdown($name, $options, $value, 'class="pulldown field-'.$name.'"');?>
</div>
