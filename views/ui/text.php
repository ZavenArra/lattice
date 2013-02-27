<div data-field="<?=$name;?>" 
  <?if(isset( $maxlength )):?>data-maxlength="<?=$maxlength;?>"<?endif;?>
  <?if(isset( $isMultiline )):?>data-isMultiline="<?=$isMultiline;?>"<?endif;?>
  class="ui-Text <?=$class;?>">
	
  <?if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>
	<?if( isset($isMultiline) && $isMultiline ):?>
		<textarea class="og <?=$tag;?>"><?=($value!=null)?$value:"";?></textarea>
	<?else:?>
		<textarea class="og <?=$tag;?>" rows="1"><?=($value!=null)?$value:"";?></textarea>
	<?endif;?>
</div>
