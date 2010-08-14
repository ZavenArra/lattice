<div class="loginstatus">
	<div class="controls">
	<?if(isset($username)):?>
		You are logged in as: <?=$username;?> <a class="button" href="<?=Kohana::config('config.site_path');?>auth/logout/">logout</a>
	<?endif;?>
	</div>
</div>
