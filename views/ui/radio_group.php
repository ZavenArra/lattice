<div class="ui-RadioGroup <?=$class;?>" data-field="<?=$name;?>">
	<?if (isset($groupLabel)):?>
		<label class="groupLabel"><?=$groupLabel;  $name; $label;?></label>
	<?endif;?>
	<fieldset>
	<? foreach ($radios as $radioLabel => $radioValue):?>
		<label for="<?=$radioname;?>_<?=$radioValue;?>"><?=form::radio( $radioname, $radioValue, $value==$radioValue, array('id'=>$radioname.'_'.$radioValue) ); ?><?=$radioLabel;?></label>
	<?endforeach;?>
	</fieldset>
</div>
