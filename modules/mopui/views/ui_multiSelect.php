<div class="ui-MultiSelect field-<?=$field;?> firstIsNull-true <?=$class;?>">
<label><?=$label;?></label>
<?
$preparedOptions = array();
$preparedOptions[0] = $unsetLabel;
foreach($options as $key => $value){
	$preparedOptions["$key"] = $value;
}
?>
<?=form::dropdown( $field, $preparedOptions, $value, "multiple" );?>
</div>
	
