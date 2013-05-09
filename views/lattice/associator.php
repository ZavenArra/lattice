<div id="<?=$lattice;?><?=$parent_id;?>" data-objectid="<?=$parent_id;?>" data-lattice="<?=$lattice;?>" class="module associator classPath-lattice_modules_Associator clearfix">

	<h4><?=$label;?></h4>
	<ul class="associated clearfix ">
	<?foreach($associated as $view):?>
	  <?=$view->render();?>
	<?endforeach;?>
	</ul>
<?php if ($num_pages > 1):?>
	<div class="actuator clearFix">
		<h4><?=$pool_label;?></h4>		
		<label for="<?=$lattice;?>SearchBox<?=$parent_id;?>" class="filter" >
			Filter results
			<input class="roundedInput" type="text" name="filter" value="Showing first <?=$page_length?>" id="<?=$lattice;?>SearchBox<?=$parent_id;?>" />
			<a href="#" class="filterButton button">Filter</a>
		</label>
		<?if( $num_pages > 1 ):?>
    <div class="paginator" data-num_pages="<?=$num_pages;?>" >
      <ul class="pages">
      	
          <li class="template hidden">
						<a href="/ajax/compound/associator/getPage/<?=$parent_id?>/<?=$lattice?>/{{page}}/{{filter}}">0</a>
					</li>

          <?php
          if (!isset($search_term) ) $search_term =null;
          ?>
          <?php for ($i = 0; $i < $num_pages; $i++):?>
          <li>
						<a href="/ajax/compound/associator/getPage/<?=$parent_id?>/<?=$lattice?>/<?=$i?>" <?=($i==0)?'class="active"':''?>>
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
