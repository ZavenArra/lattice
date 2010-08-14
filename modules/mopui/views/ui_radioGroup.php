<div <?=isset( $id )? 'id="'. $id . '"' : "";?> class="ui-RadioGroup field-<?=$field;?> <?=isset($class)?$class:'';?>">
	<?if(isset($grouplabel)):?>
		<label class="groupLabel"><?=$grouplabel;?></label>
	<?endif;?>
	<fieldset>
	<? foreach ($radios as $radioLabel => $radioValue):?>
		<label for="<?=$radioname;?>_<?=$radioValue;?>"><?=form::radio( $radioname, $radioValue, $value==$radioValue, 'id="'.$radioname.'_'.$radioValue.'"' ); ?><?=$radioLabel;?></label>
	<?endforeach;?>
	</fieldset>
</div>
