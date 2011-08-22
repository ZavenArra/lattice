<div class="ui-MultiSelect <?=$class;?>" data-field="field-<?=$field;?>" data-firstisnull="true">
	<label><?=$label;?></label>
	<?
	$preparedOptions = array();
	$preparedOptions[0] = $unsetLabel;
	foreach($options as $key => $ovalue){
		$preparedOptions["$key"] = $ovalue;
	}
	?>
	<?=form::dropdown( $field, $preparedOptions, $value, "multiple" );?>
</div>
	
