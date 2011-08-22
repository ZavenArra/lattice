<div class="ui-CheckBox <?=$class;?>" data-field="<?=$field;?>">
	<input name="<?=$field;?>" type="checkbox" id="checkbox_<?=$field;?>" value="<?=$value;?>" <?if( $value == 1 ) echo 'checked="true"';?>  />
	<label for="checkbox_<?=$field;?>"><?=$label;?></label>
</div>
