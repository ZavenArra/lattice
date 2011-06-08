<div class="modalContainer">
	<div class="modal">
		<h3><?=$title;?></h3>
		<div class="container">
			<?if(isset($message)):?><?=$message;?><?endif;?>

	<form action="<?=url::base();?>auth/login" method="post" class="form">
<table class="">
<tbody><tr>
<th><label for="username">Username</label></th>
<td>
<input id="username" name="username" value="" class="grid_4" type="text"></td>
</tr>
<tr>
<th><label for="password">Password</label></th>
<td>
<input id="password" name="password" value="" class="grid_4" type="password"></td>
</tr>
<tr>

<th></th>
<td>
<button type="submit" class="submit" name="submit">Login</button></td>
</tr>
</tbody></table>
<input type="hidden" name="redirect" value="<?=$redirect;?>" />
</form>

			<a href="auth/forgot/">Forgot your password?</a> 
		</div>
	</div>
	<a class="modalAnchor"></a>
	<script type="text/javascript">
		window.addEvent( "domready", function(){ $("username").focus(); } );
	</script>
</div>
