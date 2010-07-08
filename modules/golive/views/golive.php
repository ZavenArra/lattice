<div id="golive" class="important fourCol module package-mop_modules class-GoLive">

	<div class="SlideSwitch oneCol floatLeft">
		<label for="switch1">On</label><input id="switch1" type="radio" name="switch" value='1' />
		<label for="switch2">Off</label><input id="switch2" type="radio" name="switch" value='0' checked="checked" />
	</div>
	
	<div class="secondCol">
		<p>Here is where one can make push changes from the <a href="<?=Kohana::config('config.site_domain');?>" target="_blank">Staging Build</a><br/>to the <a href="<?=str_replace('staging/','',Kohana::config('config.site_domain'));?>" target="_blank">Live Build</a>.<br/>Simply slide the switch to the active position.</p>
		<a id="bigRedButton" href="golive/copytolive/" class="button hidden">Update Live Site</a>
		<img src="modules/mopui/views/images/spinner.gif" width="16" height="16" alt="processing..." class="spinner hidden"/>
		<p class="message"></p>
	</div>

</div>
