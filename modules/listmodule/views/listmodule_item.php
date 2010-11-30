<li id="item_<?=$data['id'];?>" class="listItem">

	<?foreach($fields as $field=>$type):?>
		<?=mopui::IPE( $field, "rows-1", "p", $data[$field], $labels[$field] );?>
	<?endforeach;?>

	<?if(is_array($files) && isset($files['file']) ):?>
		<?=mopui::buildUIElement( array(
			'type'=>'file',
			'field'=>"file",
			'extensions'=>$files['file']['extensions'],
			'maxlength'=>$files['file']['maxlength'], "class"=>null ),
			$files['file']['id'] );?>
	<?elseif(is_array($images) && isset($images['file']) ):?>
		<?=mopui::buildUIElement( array('type'=>'image', 'field'=>"file", 'extensions'=>$images['file']['extensions'], 'maxlength'=>$images['file']['maxlength'], "class"=>null ), $images['file']['id'] );?>
	<?endif;?>

	<div class="itemControls">
		<a href="#" title="delete this list item" class="icon delete"><span>delete</span></a>
		<a href="#" title="submit" class="button submit hidden">submit</a>
		<a href="#" title="cancel" class="button cancel hidden">cancel</a>
	</div>

</li>
