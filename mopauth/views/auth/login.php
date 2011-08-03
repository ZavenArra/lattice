<div class="modalContainer">
	<div class="header container_12">
		<h3><?=$title;?></h3>
	</div>
	<div class="modal container_12">
		<div class="content">
			<?if(isset($message)):?><?=$message;?><?endif;?>
			<form action="<?=url::base();?>auth/login" method="post" class="form">
				<fieldset class="grid_3">
					<label for="username">Username</label>
					<input id="username" name="username" value="" class="" type="text" />
				</fieldset>
				<fieldset class="grid_4">
					<label for="password">Password</label>
					<input id="password" name="password" value="" class="grid_4" type="password" />
				</fieldset>
				<fieldset class="grid_12">
					<button type="submit" class="submit" name="submit">Login</button>
					<input type="hidden" name="redirect" value="<?=$redirect;?>" />
					<a href="<?=URL::base();?>auth/forgot/">Forgot your password?</a> 
				</fieldset>
			</form>
		</div>
	</div>
	<a class="modalAnchor"></a>
	<script type="text/javascript">
		window.addEvent( "domready", function(){ $("username").focus(); } );
	</script>
</div>
