<div id="<?=$lattice;?><?=$parentId;?>" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator classPath-lattice_modules_Associator clearfix">

	<h4><?=$label;?></h4>

	<ul class="associated clearfix ">
	<?foreach($associated as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>

	<div class="actuator clearFix">
		
		<a href="#" class="actuatorButton" title="<?=$poolLabel;?>" class="closed"><?=$poolLabel;?></a>

		<label for="{{filterUniqueID}}" class="filter hidden" >
			Filter results
			<input class="roundedInput" type="text" name="filter" value="" id="{{FilterUniqueID}}" />
			<a href="#" class="filterButton button">Filter</a>
		</label>

	</div>

	<ul class="pool clearfix">
	<?foreach($pool as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>

	
</div>
