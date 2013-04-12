<div data-field="<?=$name;?>" <?if (isset( $isMultiline )):?>data-isMultiline="<?=$isMultiline;?>"<?endif;?> class="ui-Text <?=$class;?>">
	<?if (isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>
	<input class="og <?=$tag;?>" type="password" value="<?if ($value!=null)echo$value;?>" />
</div>
