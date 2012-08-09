<div data-objectid="<?=$object->id;?>" class="item checkbox toggle <?=($selected)? 'selected"' : '';?>" >
<label for="associatorCheckboxItem<?=$uniqueElementId;?>">
	<?=$object->title;?>
	<input type="checkbox" name="associatorCheckboxItem<?=$uniqueElementId;?>" <?=($selected)? 'checked="checked"' : '';?>  />
</label>
</div>