<div class="ui-MultiSelect <?=$class;?>" data-field="field-<?=$name;?>" data-firstisnull="true">
	<label><?=$label;?></label>
	<?
	$preparedOptions = array();
	$preparedOptions[0] = $unsetLabel;
	foreach($options as $key => $ovalue){
		$preparedOptions["$key"] = $ovalue;
	}
	?>
	<?=form::dropdown( $name, $preparedOptions, $value, "multiple" );?>
</div>
	
