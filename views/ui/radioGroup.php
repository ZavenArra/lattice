<div class="ui-RadioGroup <?=$class;?>" data-field="<?=$name;?>">
	<?if (isset($groupLabel)):?>
		<label class="groupLabel"><?=$groupLabel;  $name; $label;?></label>
	<?endif;?>
	<fieldset>
	<? foreach ($radios as $radioLabel => $radioValue):?>
		<label for="<?=$name;?>_<?=$radioValue;?>"><?=form::radio( $name, $radioValue, $value==$radioValue, array('id'=>$name.'_'.$radioValue) ); ?><?=$radioLabel;?></label>
	<?endforeach;?>
	</fieldset>
</div>
