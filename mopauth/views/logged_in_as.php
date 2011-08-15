<div class="loginStatus"><?if(isset($username)):?>You are logged in as: <?=$username;?> <a class='button floatRight' href="<?=url::site('auth/logout/');?>">logout</a><?endif;?></div>
