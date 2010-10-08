<li id="item_<?=$data['id'];?>" class="listItem">

	
	<?foreach($uiElements as $htmlChunk):?>
		<?=$htmlChunk;?>
	<?endforeach;?>

	<div class="itemControls">
		<a href="#" title="delete this list item" class="icon delete"><span>delete</span></a>
		<a href="#" title="submit" class="button submit hidden">submit</a>
		<a href="#" title="cancel" class="button cancel hidden">cancel</a>
	</div>

</li>
