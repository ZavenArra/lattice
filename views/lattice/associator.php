<div id="<?=$lattice;?><?=$parentId;?>" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator classPath-lattice_modules_Associator clearfix">

	<h4><?=$label;?></h4>
<h4>Page Length<?=$pageLength?></h4>
	<ul class="associated clearfix ">
	<?foreach($associated as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>
<?php if ($numPages>1):?>
	<div class="actuator clearFix">
		<h4><?=$poolLabel;?></h4>		
		<label for="<?=$lattice;?>SearchBox<?=$parentId;?>" class="filter hidden" >
			Filter results
			<input class="roundedInput" type="text" name="filter" value="Showing first fourty." id="<?=$lattice;?>SearchBox<?=$parentId;?>" />
			<a href="#" class="filterButton button">Filter</a>
		</label>
    <div class="paginator" data-numPages="<?=$numPages;?>" >
      <ul class="pages">
          <?php
          if (!isset($searchTerm) ) $searchTerm =null;
          ?>
          <?php for ($i = 0; $i < $numPages; $i++):?>
          <li>
						<a href="/ajax/html/associator/getPage/<?=$parentId?>/<?=$lattice?>/<?=($i+1)?>/<?=$searchTerm?>" <?=($i==0)?'class="active"':''?>>
							<?=($i+1)?>
						</a>
					</li>
        <?php endfor;?>
      </ul>
    </div>
	</div>
<?php endif;?>




	<ul class="pool clearfix">
	<?foreach($pool as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>

	
</div>
