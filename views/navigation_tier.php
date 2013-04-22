	<ul class="nodes clearFix">
	<li>
		<form class="search-form">
			<input type="text" name="search_node" value="" id="search_node" placeholder="search for an object"/>
		</form>
	</li>
	<?foreach($nodes as $node):?>
		<?=$node;?>
	<?endforeach;?>
	</ul>
	<?=$tier_methods_drawer;?>
