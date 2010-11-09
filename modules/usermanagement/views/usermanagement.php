<div id="<?=$instance;?>" class="module <?=$class;?> classPath-mop_modules_List sortable-true">
<?if(isset($label) && $label):?>
		<label><?=$label;?></label>
	<?endif;?>
	<ul class="listing">
		<?=$items;?>
	</ul>
 <div class="controls">
    <a href="#" class="addItem button oneCol floatLeft">Add Item</a>
  </div>
</div>


