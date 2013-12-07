<script>
	window.addEvent('domready', function(){			
	var dataArray = [];
	$('search_tag').getElements('li').each(function(el,i){
			var dataArray_new =[{name:el.get('text'),row:i}];
			dataArray.append(dataArray_new);
	}); var ArrSort1 = dataArray.sortBy('name').map(function(item){return item.row});
	var ArrSort2 = dataArray.sortBy('-name').map(function(item){return item.row});

	var sorter = new Fx.Sort($$('#search_tag li'),{
	duration: 500,
	transition: Fx.Transitions['Quartic.easeIn']
	});

	$('sort1').addEvent('click', function(event){
	sorter.sort(ArrSort1);
	});
	$('sort2').addEvent('click', function(event){
	sorter.sort(ArrSort2);
	});
	});
</script>
	<ul class="nodes" id="search_tag">
		<?php if(Kohana::config('lattice.tier_sort_enabled')): ?>
		Sort by: <span id="sort1" onclick="
lattice.CMS.doAjax(this.get('rel'));" rel="desc">down</span> 
		| <span id="sort2" rel="asc">up</span>
		<?php endif; ?>
	<?php foreach($nodes as $node):?>
		<?php echo $node; ?>
	<?php endforeach;?>
	<li class="node object spacer" id="node" style="opacity: 0;"></li> 
	</ul>
	
	<?php echo $tier_methods_drawer; ?>
