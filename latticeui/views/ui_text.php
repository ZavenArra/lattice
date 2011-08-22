<div data-field="<?=$field;?>" data-isMultiline="<?=$isMultiline;?>" class="ui-Text <?=$class;?>">
	<?if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>
	<?if( isset($isMultiline) && $isMultiline ):?>
		<textarea class="og <?=$tag;?>"><?=($value!=null)?$value:"";?></textarea>
	<?else:?>
		<input class="og <?=$tag;?>" type="text" value="<?if($value!=null)echo$value;?>" />
	<?endif;?>
</div>
