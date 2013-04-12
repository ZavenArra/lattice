<div class="loginStatus">
  <?if (isset($username)):?><span>You are logged in as: <b><?=$username;?></b></span>
  <a class='button' href="<?=url::site('auth/logout/');?>">logout</a>
  <?endif;?>
</div>
