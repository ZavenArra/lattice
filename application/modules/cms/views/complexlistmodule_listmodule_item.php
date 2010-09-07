<li id="item_<?=$data['id'];?>" class="listItem">
	<?foreach($fields as $field=>$type):?>
		<?if($type=='ipe'):?>
			<?=mopui::IPE( $field, "rows-1", "p", $data[$field], $labels[$field] );?>
		<?endif;?>
	<?endforeach;?>

<?=mopui::buildUIElement(array(
	'type'=>'radioGroup',
	'field'=>'radio',
	'radioname'=>'SingleRadio',
	'grouplabel'=>'Single Radio',
	'radios'=>array('one'=>'one', 'two'=>'two'),
),
$data['radio']
);?>


<?=mopui::buildUIElement(array(
	'type'=>'checkbox',
	'field'=>'checkbox',
	'label'=>'Checkbox',
),
$data['checkbox']
);?>

	<?if(is_array($files) && isset($files['file']) ):?>
		<?=mopui::buildUIElement( array(
			'type'=>'singlefile',
			'field'=>"file",
			'extensions'=>$files['file']['extensions'],
			'maxlength'=>$files['file']['maxlength'], "class"=>null ),
			$files['file']['id'] );?>
	<?elseif(is_array($singleimages) && isset($singleimages['file']) ):?>
		<?=mopui::buildUIElement( array('type'=>'singleImage', 'field'=>"file", 'extensions'=>$singleimages['file']['extensions'], 'maxlength'=>$singleimages['file']['maxlength'], "class"=>null ), $singleimages['file']['id'] );?>
	<?endif;?>

	<div class="itemControls">
		<a href="#" title="delete this list item" class="icon delete"><span>delete</span></a>
		<a href="#" title="submit" class="button submit hidden">submit</a>
		<a href="#" title="cancel" class="button cancel hidden">cancel</a>
	</div>

</li>
