<div class="ui-Pulldown <?=$class;?>" data-field="<?=$name;?>">
	<label class="groupLabel"><?=$label;?></label>
  <?
    $optionsWithSelectText = array();
    $optionsWithSelectText["0"] = 'Select';
    foreach($options as $value => $key){
      $optionsWithSelectText[$value] = $key;
    }
?>
	 <?=form::select( $label, $optionsWithSelectText, $value );?> 
</div>
