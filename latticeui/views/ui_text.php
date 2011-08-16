<div class="ui-Text field-<?=$field;?> <?=$class;?>">
	<?if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>
	<?if( isset($rows) && $rows > 1 ):?>
		<textarea class="og <?=$tag;?>"><?=($value!=null)?$value:"";?></textarea>
	<?else:?>
		<input class="og <?=$tag;?>" type="text" value="<?if($value!=null)echo$value;?>" />
	<?endif;?>
</div>
