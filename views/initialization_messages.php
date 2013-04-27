<div class="modalContainer">
	<div class="header container_12">
		<h3>Initialization</h3>
	</div>
	<div class="modal container_12">

		<ul>
		<?php foreach($messages as $message):?>
		<li><?php echo $message;?></li>
		<?php endforeach; ?>
		</ul>

		<p class="message">
      Looks good!
			<a class="button" href="<?=url::base('http');?>cms">Continue</a>
		</p>

	</div>
</div>


