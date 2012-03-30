<div id="<?=$lattice;?><?=$parentId;?>" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator classPath-lattice_modules_Associator clearfix">

	<h4><?=$label;?></h4>

	<ul class="associated clearfix ">
	<?foreach($associated as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>

	<div class="actuator clearFix">
		<h4><?=$poolLabel;?></h4>		
		<label for="<?=$lattice;?>SearchBox<?=$parentId;?>" class="filter hidden" >
			Filter results
			<input class="roundedInput" type="text" name="filter" value="Showing first fourty." id="<?=$lattice;?>SearchBox<?=$parentId;?>" />
			<a href="#" class="filterButton button">Filter</a>
		</label>

	</div>

	<ul class="pool clearfix">
	<?foreach($pool as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>

	
</div>
