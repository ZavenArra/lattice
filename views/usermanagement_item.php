<li data-objectid="<?=$data['id'];?>" id="item_<?=$data['id'];?>" class="listItem">

	<div div class="clearFix">
	<?if (!$data['superuser'] || cms_util::check_role_access('superuser')):?>
		<?=cms_ui::Text( 'username', "rows-1 validation-nonEmpty grid_2 alpha", "p", $data['username'], 'Username' );?>
		<?=cms_ui::Text( 'firstname', "rows-1 validation-nonEmpty grid_2 alpha", "p", $data['firstname'], 'First Name' );?>
		<?=cms_ui::Text( 'lastname', "rows-1 validation-nonEmpty grid_2 alpha", "p", $data['lastname'], 'Last Name' );?>
		<?=cms_ui::Text( 'email', "rows-1 validation-email grid_3 omega", "p", $data['email'], 'Email' );?>
		<?=cms_ui::Password( 'password', "rows-1 validation-nonEmpty type-password grid_3 omega", "p", '', 'Password (8 Characters)' );?>
	<?else:?>
		<?=$data['username'];?>	
	<?endif;?>
	</div>
	
	
	<? if(Auth::instance()->get_user()->username != $data['username']): ?> 
	
	<?if (!$data['superuser'] || cms_util::check_role_access('superuser')):?>
		<?=cms_ui::radio_group( 'role', '', $managed_roles, $data['role'], 'User Role');?>
	<?else:?>
		Superuser
	<?endif;?>
	<? else:
		echo ucfirst($data['role']);
	 endif; ?>
	
	<div class="itemControls clearFix">
		<a href="#" title="delete this list item" class="icon delete">delete</a>
		<a href="#" title="submit" class="button submit hidden">submit</a>
		<a href="#" title="cancel" class="button cancel hidden">cancel</a>
	</div>

</li>
