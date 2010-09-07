<div class="ui-IPE field-<?=$field;?> <?=$class;?>">
	<?if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>
	<div class="ipe <?=$tag;?>"><?=($value!=null)?$value:"";?></div>
</div>
