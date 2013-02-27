<label for="associatorCheckboxItem_<?=$object->id;?>">
	<?=$object->title;?>
	<input type="checkbox" data-objectid="<?=$object->id?>" name="associatorCheckboxItem_<?=$object->id;?>" <? echo $selected ? 'checked="checked"' : '';?>  />
</label>
