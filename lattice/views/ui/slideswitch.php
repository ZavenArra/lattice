<div data-field="<?=$name;?>" class="ui-SlideSwitch">

  <h4 class="sectionHead"><?=$label;?></h4>
	<div class="oneCol slideSwitch">
		<label for="switch1">On</label><input id="switch1" type="radio" name="switch" <?=($value)?'checked="true"':'';?>/>
		<label for="switch2">Off</label><input id="switch2" type="radio" name="switch" <?=($value)?'':'checked="true"';?>/>
	</div>

</div>
