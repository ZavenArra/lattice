<div class="modalContainer">
	<div class="header container_12">
		<h3><?=$title;?></h3>
	</div>
	<div class="modal container_12">
		<form action="<?=URL::base();?>auth/forgot/" method="POST">
			<div class="content login">
				<fieldset>
					<legend>
					<?php 
						if (isset($message)):
							echo $message;
					?>
						<br />
					<?php
						endif;
					?>
						Please enter your email.  A new password will be sent to you.
					</legend>
					<label for="emailInput">Email</label>
					<input type="text" name="email" size="56"/>
				</fieldset>
			</div>
			<div class="footer">
				<div class="controls clearFix">
					<button type="submit" class="submit" name="submit">Submit</button>
					<a href="<?=URL::base();?>cms">CLick here to Login</a> 
				</div>
			</div>
		</form>
	</div>
</div>
