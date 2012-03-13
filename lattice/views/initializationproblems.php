<div class="modalContainer">
	<div class="header container_12">
		<h3>Initialization</h3>
	</div>
	<div class="modal container_12">

		<ul>
		<?php foreach($problems as $problem):?>
		<li><?php echo $problem;?></li>
		<?php endforeach; ?>
		</ul>
		<ul>
		<?php foreach($messages as $message):?>
		<li><?php echo $message;?></li>
		<?php endforeach; ?>
		</ul>

		<p class="message">
			Once you've fixed the above issues
			<a class="button" href="<?=url::base('http');?>setup">Rerun the installer</a>
		</p>

	</div>
</div>


