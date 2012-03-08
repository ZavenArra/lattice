<label for="associatorCheckboxItem<?=$uniqueElementId;?>">
	<?=$object->title;?>
	<input type="checkbox" data-objectid="<?=$object->id?>" name="associatorRadioItem<?=$uniqueElementId;?>" <? echo $selected ? 'checked="checked"' : '';?>  />
</label>
