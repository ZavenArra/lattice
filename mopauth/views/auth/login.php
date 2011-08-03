<div class="modalContainer">
	<div class="header container_12">
		<h3><?=$title;?></h3>
	</div>
	<div class="modal container_12">
		<div class="content">
			<?if(isset($message)):?><?=$message;?><?endif;?>
			<form action="<?=url::base();?>auth/login" method="post" class="form">
				<label for="username">Username</label></th>
				<input id="username" name="username" value="" class="grid_4" type="text"></td>
				<label for="password">Password</label></th>
				<input id="password" name="password" value="" class="grid_4" type="password"></td>
				<button type="submit" class="submit" name="submit">Login</button></td>
				<input type="hidden" name="redirect" value="<?=$redirect;?>" />
			</form>
			<a href="<?=URL::base();?>auth/forgot/">Forgot your password?</a> 
		</div>
	</div>
	<a class="modalAnchor"></a>
	<script type="text/javascript">
		window.addEvent( "domready", function(){ $("username").focus(); } );
	</script>
</div>
