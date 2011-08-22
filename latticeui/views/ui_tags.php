<div class="ui-Tags clearFix" data-tags="<?=$tags;?>" data-field="tags">

	<?if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>

	<input class='tagInput' type="text" value="" />
	<ul class='tokens clearFix'>
		<li class="token template hidden"><span>Blank Token</span><a href="#" title="remove token" class='icon close'>remove token</a></li>
		<?foreach($tags as $tag):?>
		<li class="token template hidden"><span><?=$tag;?></span><a href="#" title="remove token" class='icon close'>remove token</a></li>
		<?endforeach;?>
	</ul>
	
</div>
