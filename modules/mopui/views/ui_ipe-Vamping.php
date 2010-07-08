<div class="ui-IPE field-<?=$field;?><?=$class;?>  tag-<?=$tag;?>">

	<?if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>
	
	<input class="ipe ipeField<?=$tag;?>" value="<?=($value)? $value : "";?>" />

</div>
