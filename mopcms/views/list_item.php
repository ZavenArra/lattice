<?$instance=$data['instance'];?>
<li id="item_<?=$data['id'];?>" class="listItem whaaAa?"> 
<?/*<?=moputil::modulo( "$instance", array( "alpha","","omega" ));?>">*/?>

	<?foreach($uiElements as $htmlChunk):?>
		<?=$htmlChunk;?>
	<?endforeach;?>

	<div class="itemControls">
		<a href="#" title="delete this list item" class="icon delete">delete</a>
		<a href="#" title="Add This Item" class="button submit hidden">submit</a>
		<a href="#" title="Cancel" class="button cancel hidden">cancel</a>
	</div>

</li>
