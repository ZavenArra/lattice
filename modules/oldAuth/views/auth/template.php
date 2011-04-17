<div class="modalContainer">
	<div class="modal">
		<h3><?=$title;?></h3>
		<div class="container">
			<?if(isset($message)):?><?=$message;?><?endif;?>
			<?=$content;?>
			<a href="auth/forgot/">Forgot your password?</a> 
		</div>
	</div>
	<a class="modalAnchor"></a>
	<script type="text/javascript">
		window.addEvent( "domready", function(){ $("username").focus(); } );
	</script>
</div>
