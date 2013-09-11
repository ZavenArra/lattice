<div id="<?=$lattice;?><?=$parent_id;?>" data-objectid="<?=$parent_id;?>" data-lattice="<?=$lattice;?>" class="module associator classPath-lattice_modules_Associator clearfix">

<h4><?=$label;?></h4>
<ul class="associated clearfix ">
<?foreach($associated as $view):?>
<?=$view->render();?>
<?endforeach;?>
</ul>
<?php if ($num_pages > 1):?>
<<<<<<< HEAD
<div class="actuator clearFix">
<h4><?=$pool_label;?></h4>
<label for="<?=$lattice;?>SearchBox<?=$parent_id;?>" class="filter" >
Filter results
<input class="roundedInput" type="text" name="filter" value="" placeholder="Search Text" id="<?=$lattice;?>SearchBox<?=$parent_id;?>" />
<a href="#" class="filterButton button">Filter</a>
</label>
<?if( $num_pages > 1 ):?>
=======
	<div class="actuator clearFix">
		<h4><?=$pool_label;?></h4>		
		<label for="<?=$lattice;?>SearchBox<?=$parent_id;?>" class="filter" >
			Filter
			<input class="roundedInput" type="text" size="100" name="filter" value="" placeholder="Search Text" id="<?=$lattice;?>SearchBox<?=$parent_id;?>" />
			<a href="#" class="filterButton button">Apply</a>
			<a href="#" class="resetButton button">Clear</a>
		</label>
		
		<?if( $num_pages > 1 ):?>
>>>>>>> d56f3d2067cb20a77eb0b6c22f97b05a6e69adb3
    <div class="paginator" data-num_pages="<?=$num_pages;?>" >
      <ul class="pages">
          <?php
          if (!isset($search_term) ) $search_term =null;
          ?>
<?php for ($i = 0; $i < $num_pages; $i++):?>
          <li class="paginator_page_option">
<a href="<?php echo url::site("/ajax/compound/associator/get_page/$parent_id/$lattice/$i"); ?> " <?=($i==0)?'class="active"':''?>>
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
