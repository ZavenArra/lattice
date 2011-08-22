<div class="ui-RadioGroup <?=$class;?>" data-field="<?=$field;?>">
	<?if(isset($grouplabel)):?>
		<label class="groupLabel"><?=$grouplabel;?></label>
	<?endif;?>
	<fieldset>
	<? foreach ($radios as $radioLabel => $radioValue):?>
		<label for="<?=$radioname;?>_<?=$radioValue;?>"><?=form::radio( $radioname, $radioValue, $value==$radioValue, array('id'=>$radioname.'_'.$radioValue) ); ?><?=$radioLabel;?></label>
	<?endforeach;?>
	</fieldset>
</div>
