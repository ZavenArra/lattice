<div class="modalContainer">
	<div class="header container_12">
		<h3><?=$title;?></h3>
	</div>
	<div class="modal container_12">
		<form action="<?=url::base();?>auth/login" method="post" class="form">
			<div class="content clearFix">
				<?if(isset($message)):?><p class="statusMessage"><?=$message;?></p><?endif;?>
				<fieldset>
					<label for="username">Username</label>
					<input id="username" name="username" value="" size="56" type="text" />
				</fieldset>
				<fieldset>
					<label for="password">Password</label>
					<input id="password" name="password" value="" size="56" type="password" />
				</fieldset>
			</div>
			<div class="footer">
				<div class="controls clearFix">
					<input type="hidden" name="redirect" value="<?=$redirect;?>" />
					<button type="submit" class="submit" name="submit">Login</button>
					<a href="<?=URL::base();?>auth/forgot/">Forgot your password?</a> 
				</div>
			</div>
		</form>
	</div>
	<a class="modalAnchor"></a>
	<script type="text/javascript">
		window.addEvent( "domready", function(){ $("username").focus(); } );
	</script>
</div>
