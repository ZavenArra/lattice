<div id="<?=$lattice;?><?=$parentId;?>" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator classPath-lattice_modules_Associator clearfix">

	<h4><?=$label;?></h4>
	<ul class="associated clearfix ">
	<?foreach($associated as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>
<?php if ($numPages > 1):?>
	<div class="actuator clearFix">
		<h4><?=$poolLabel;?></h4>		
		<label for="<?=$lattice;?>SearchBox<?=$parentId;?>" class="filter" >
			Filter results
			<input class="roundedInput" type="text" name="filter" value="Showing first <?=$pageLength?>" id="<?=$lattice;?>SearchBox<?=$parentId;?>" />
			<a href="#" class="filterButton button">Filter</a>
		</label>
		<?if( $numPages > 1 ):?>
    <div class="paginator" data-numPages="<?=$numPages;?>" >
      <ul class="pages">
          <?php
          if (!isset($searchTerm) ) $searchTerm =null;
          ?>
          <?php for ($i = 0; $i < $numPages; $i++):?>
          <li>
						<a href="/ajax/compound/associator/getPage/<?=$parentId?>/<?=$lattice?>/<?=$i?>" <?=($i==0)?'class="active"':''?>>
							<?=($i+1)?>
						</a>
					</li>
        <?php endfor;?>
      </ul>
    </div>
		<?endif;?>

	</div>
<?php endif;?>

	<ul class="pool clearfix">
	<?foreach($pool as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>

	
</div>
