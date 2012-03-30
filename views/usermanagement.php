<div id="<?=$instance;?>" class="module usermanagement controller-<?=$class;?> classPath-lattice_modules_UserManagement sortable-true">

	<?if(isset($label)):?>
		<label class='listLabel'><?=$label;?></label>
	<?endif;?>

	<div class="controls clearFix"><a href="#" class="addItem button">Add a User</a></div>

	<ul class="listing">
		<?=$items;?>
	</ul>

</div>


