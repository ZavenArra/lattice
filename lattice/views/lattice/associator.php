<div id="<?=$lattice;?><?=$parentId;?>" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator classPath-lattice_modules_Associator clearFix">

	<h4><?=$label;?></h4>

	<ul class="associated clearFix">
	<?foreach($associated as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>

	<div class="actuator clearFix">
		<a href="#" title="<?=$poolLabel;?>" class="icon closed"><?=$poolLabel;?></a>
	</div>

	<div class="poolcontainer clearFix">

		<div class="filter clearFix">
			<label>
				<input type="text" name="filter" value="" id="FILTERuniqueID" />
				<a href="#" class="button">Filter Pool</a>
			</label>
		</div>
	
		<ul class="pool clearFix">
		<?foreach($pool as $view):?>
		  <?=$view->render();?>
		<?endforeach;?>
		</ul>

	</div>
	
</div>
