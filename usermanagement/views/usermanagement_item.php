<li id="item_<?=$data['id'];?>" class="listItem">

	<?=mopui::IPE( 'username', "rows-1 validation-nonEmpty twoColTriptic", "p", $data['username'], 'Username' );?>
	<?=mopui::IPE( 'email', "rows-1 validation-email twoColTriptic", "p", $data['email'], 'Email' );?>
	<?=mopui::IPE( 'password', "rows-1 validation-nonEmpty type-password twoColTriptic", "p", $data['password'], 'Reset and Mail Password' );?>
	
	<div class="clear">
		<?=mopui::radioGroup( 'role', '', $managedRoles, $data['role'], 'User Role');?>
	</div>
	
	<div class="itemControls">
		<a href="#" title="delete this list item" class="icon delete"><span>delete</span></a>
		<a href="#" title="submit" class="button submit hidden">submit</a>
		<a href="#" title="cancel" class="button cancel hidden">cancel</a>
	</div>

</li>
