<label for="associatorRadioItem<?=$uniqueElementId;?>">
	<input type="radio" data-objectid="<?=$object->id?>" name="associatorRadioItem<?=$uniqueElementId;?>" value="<?=$object->id?>" <? echo $selected ? 'selected="selected"' : '';?>  />
	<?=$object->title;?>
</label>
