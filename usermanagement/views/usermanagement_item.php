<li id="item_<?=$data['id'];?>" class="listItem">

	<div div class="clearFix">
		<?=latticeui::Text( 'username', "rows-1 validation-nonEmpty grid_3 alpha", "p", $data['username'], 'Username' );?>
		<?=latticeui::Text( 'email', "rows-1 validation-email grid_4", "p", $data['email'], 'Email' );?>
		<?=latticeui::Text( 'password', "rows-1 validation-nonEmpty type-password grid_3 omega", "p", $data['password'], 'Reset and Mail Password' );?>
	
	</div>

	<?=latticeui::radioGroup( 'role', '', $managedRoles, $data['role'], 'User Role');?>
	<?if($data['role'] == 'superuser'):?>
		Superuser
	<?endif;?>
	
	<div class="itemControls clearFix">
		<a href="#" title="delete this list item" class="icon delete"><span>delete</span></a>
		<a href="#" title="submit" class="button submit hidden">submit</a>
		<a href="#" title="cancel" class="button cancel hidden">cancel</a>
	</div>

</li>
