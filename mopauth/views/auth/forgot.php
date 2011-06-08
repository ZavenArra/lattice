<div class="modalContainer">
	<div class="modal">
		<h3>Forgot Password</h3>
		<div class="container">
			<?if(isset($message)):?><?=$message;?><?endif;?>
			<form action="<?=Kohana::config('config.site_path');?>auth/forgot/" method="POST">
			Please enter your email.  A new password will be sent to you.<br>

			<label for="emailInput">Email</label>
			<input type="text" name="email" />

			<input type="submit">

			</form>
			
		</div>
	</div>
	<a href="#" class="modalAnchor"></a>
</div>
