<div class="ui-MultiSelect field-<?=$field;?> firstIsNull-true <?=$class;?>">
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
	
