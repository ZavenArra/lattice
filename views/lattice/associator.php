<div id="<?=$lattice;?><?=$parentId;?>" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator classPath-lattice_modules_Associator clearfix">

	<div class="floatcontrol">
		<a href="#" title="Choose which items to include…" class="icon meta modal-actuator">meta</a>
	</div>
	<h4><?=$label;?></h4>

	<ul class="associated clearfix ">
	<?foreach($associated as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>

	<div class="modalContent associator hidden">
	
		<div class="methods clearFix">
			<h4><?=$poolLabel;?></h4>		
			<label for="<?=$lattice;?>SearchBox<?=$parentId;?>" class="filter hidden" >
				Filter results
				<input class="roundedInput" type="text" name="filter" value="Showing first fourty." id="<?=$lattice;?>SearchBox<?=$parentId;?>" />
				<a href="#" class="filterButton button">Filter</a>
			</label>
			
			<div class="pagination">
				<?if ( isset( $pages ) && count( $pages ) ):?>
				<ul>
					<?foreach( $page as $key => $pages):?>
					<li><a class="active" href="ajax/html/associator/getPage/<?=$parentId;?>/<?=$lattice;?>/<?=$key;?>"><?=$key;?></a></li>
					<?endforeach;?>
				</ul>
				<?endif;?>

			</div>

		</div>

		<ul class="pool clearfix">
		<?foreach($pool as $view):?>
		  <?=$view->render();?>
		<?endforeach;?>
		</ul>

	</div>

</div>
