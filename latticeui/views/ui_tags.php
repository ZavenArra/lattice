<div class="ui-Tags grid_5" data-tags="<?=$tags;?>" data-field="tags">

	<?if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>

	<ul class='tokens clearFix'>
		<?foreach($tags as $tag):?>
		<li class="token template hidden"><span><?=$tag;?></span><a href="#" title="remove token" class='icon close'>remove token</a></li>
		<?endforeach;?>
		<li><input class='autoCompleterInput' type="text" value="" /></li>
	</ul>
	
</div>
