<div class="ui-Pulldown <?=$class;?>" data-field="<?=$name;?>">
	<label class="groupLabel"><?=$label;?></label>
  <?
    $optionsWithSelectText = array();
    $optionsWithSelectText["0"] = 'Select';
    foreach($options as $optionValue => $key){
      $optionsWithSelectText[$optionValue] = $key;
    }
?>
	 <?=form::select( $label, $optionsWithSelectText, $value );?> 
</div>
