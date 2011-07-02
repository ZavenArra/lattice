<div id="<?=$instance;?>" class="module <?=$class;?> classPath-mop_modules_UserManagement sortable-true">
<?if(isset($label) && $label):?>
		<label><?=$label;?></label>
	<?endif;?>
	<ul class="listing">
		<?=$items;?>
	</ul>
 <div class="controls">
    <a href="#" class="addItem button grid_2">Add Item</a>
  </div>
</div>


