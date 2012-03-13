<div id="<?=$lattice;?><?=$parentId;?>" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator classPath-lattice_modules_Associator clearFix">

	<h4><?=$label;?></h4>

	<ul class="associated clearFix">
	<?foreach($associated as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>

	<div class="actuator clearFix">
		
		<a href="#" title="<?=$poolLabel;?>" class="icon closed"><?=$poolLabel;?></a>

		<label for="{{filterUniqueID}}" class="filter hidden" >
			Filter results
			<input class="roundedInput" type="text" name="filter" value="" id="{{FilterUniqueID}}" />
			<a href="#" class="filterButton button">Filter</a>
		</label>

	</div>

	<div class="poolcontainer clearFix hidden">

	
		<ul class="pool clearFix">
		<?foreach($pool as $view):?>
		  <?=$view->render();?>
		<?endforeach;?>
		</ul>

	</div>
	
</div>
