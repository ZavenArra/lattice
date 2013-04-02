<?$instance=$data['instance'];?>
<li data-objectid="<?=$data['id'];?>" id="item_<?=$data['id'];?>" class="listItem"> 

	<?foreach($ui_elements as $html_chunk):?>
		<?=$html_chunk;?>
	<?endforeach;?>

	<div class="itemControls clearFix">
		<a href="#" title="delete this list item" class="icon delete">delete</a>
		<a href="#" title="Add This Item" class="button submit hidden">submit</a>
		<a href="#" title="Cancel" class="button cancel hidden">cancel</a>
	</div>

</li>
