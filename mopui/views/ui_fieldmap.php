<?$values = unserialize($values);?>
<?if(is_array($values)):?>
	<?foreach($values as $key => $value):?>
	<div class="ui-Pulldown field-<?=$key;?>">
		<?=$key;?> : <?=form::dropdown($key, $options, $value, 'class="pulldown field-'.$key.'"');?>
		</div>
	<?endforeach;?>
<?endif?>
