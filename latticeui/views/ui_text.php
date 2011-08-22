<div data-field="<?=$field;?>" <?if(isset( $isMultiline )):?>data-isMultiline="<?=$isMultiline;?>"<?endif;?> class="ui-Text <?=$class;?>">
	<?if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>
	<?if( isset($isMultiline) && $isMultiline ):?>
		<textarea class="og <?=$tag;?>"><?=($value!=null)?$value:"";?></textarea>
	<?else:?>
		<input class="og <?=$tag;?>" type="text" value="<?if($value!=null)echo$value;?>" />
	<?endif;?>
</div>
