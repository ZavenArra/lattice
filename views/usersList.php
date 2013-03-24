<div class="usersList clearfix">
	<h5>Users</h5>
  <?php if (isset($usersList) && is_array($usersList) && (count($usersList) >0)):?>
  <?php foreach ($usersList as $user):?>
    <div class="checkbox">
      <?=form::checkbox('user',$user["id"],$user["checked"])?><?=$user["username"]?>
      <?=cms_ui::buildUIElement( array('type'=>'checkbox', 'name'=>$field, 'checkboxvalue'=>$user['id'], 'label'=>$user['username'], 'class'=>'checkbox'), $user['checked'])?>
    </div>
  <?php endforeach;?>
  <?php else: ?>
  <?php endif;?>
</div>

