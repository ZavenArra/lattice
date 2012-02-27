<label for="associatorRadioItem<?=$uniqueElementId;?>">
	<input type="radio" data-objectid="<?=$object->id?>" name="associatorRadioItem<?=$uniqueElementId;?>" <? echo $selected ? 'checked="checked"' : '';?>  />
	<?=$object->title;?>
</label>
