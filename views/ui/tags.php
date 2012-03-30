<div class="ui-Tags clearFix" data-tags="<?=$tags;?>" data-field="tags">
	<?/*if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;*/?>
	<div class="container atRest">
		<ul class='tokens clearFix'>
			<li class='head'>
				<label>Tags</label>
				<input class='tagInput hidden' type="text" value="" />
				<a href="#" class="icon edit">edit</a>
			</li>
			<li class="token template"><span>Blank Token</span><a href="#" title="remove token" class='icon close'>remove token</a></li>
			<?foreach($tags as $tag):?>
			<li class="token"><span><?=$tag;?></span><a href="#" title="remove token" class='icon close'>remove token</a></li>
			<?endforeach;?>
		</ul>
	</div>
</div>
