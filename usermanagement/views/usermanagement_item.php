<li id="item_<?=$data['id'];?>" class="listItem">

	<?=mopui::Text( 'username', "rows-1 validation-nonEmpty grid_4 alpha", "p", $data['username'], 'Username' );?>
	<?=mopui::Text( 'email', "rows-1 validation-email grid_4", "p", $data['email'], 'Email' );?>
	<?=mopui::Text( 'password', "rows-1 validation-nonEmpty type-password grid_4 omega", "p", $data['password'], 'Reset and Mail Password' );?>
	
	<div class="options">
			
		<?/*
			add value for third and fourth parameters
			=mopui::checkBox( 'userlevel', '', '', 'Superuser');
		*/?>
			
	</div>

	<div class="clear"></div>
<?print_r($data['role']);?>
	<?=mopui::radioGroup( 'role', '', $managedRoles, $data['role'], 'User Role');?>
	
	<div class="itemControls clearFix">
		<a href="#" title="delete this list item" class="icon delete"><span>delete</span></a>
		<a href="#" title="submit" class="button submit hidden">submit</a>
		<a href="#" title="cancel" class="button cancel hidden">cancel</a>
	</div>

</li>
