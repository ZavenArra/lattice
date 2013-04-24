<div class="ui-CheckBox <?=$class;?>" data-field="<?=$name;?>">
	<input name="<?=$name;?>" type="checkbox" id="checkbox_<?=$name;?>" value="<?=$value;?>" <?if ( $value == 1 ) echo 'checked="true"';?>  />
	<label for="checkbox_<?=$name;?>"><?=$label;?></label>
</div>
