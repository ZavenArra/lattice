<div id="" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator classPath-lattice_modules_Associator clearFix">

<h5><?=$label;?></h5>
<ul class="associated clearFix">
<?foreach($associated as $view):?>
  <?=$view->render();?>
<?endforeach;?>
</ul>

<h5><?=$poolLabel;?></h5>

<div class="pool clearFix">

	<div class="filter">
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

<div>

</div>
