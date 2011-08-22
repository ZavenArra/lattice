<div class="ui-Tags grid_5" data-tags="<?=$tags;?>" data-field="tags">

	<?if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>

	<ul class='tokens clearFix'>
		<li class="token template hidden"><span>Blank Token</span><a href="#" title="remove token" class='icon close'>remove token</a></li>
		<li><input class='autoCompleterInput' type="text" value="" /></li>
	</ul>
	
</div>
