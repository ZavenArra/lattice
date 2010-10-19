<div id="<?=$instance;?>" class="module <?=$class;?> classPath-mop_modules_ListModule">
	
	<?if(isset($label) && $label):?>
	<label><?=$label;?></label>
	<?endif;?>
	
	<ul class="listing">
		<?=$items;?>
	</ul>

	<div class="controls clear">
		<a href="#" class="addItem button oneCol floatLeft">Add another?</a>
	</div>

	

</div>


