	<div class="ui-FileElement field-<?=$field;?> action-saveFile extensions-<?=str_replace(',','_',$extensions);?> maxlength-<?=$maxlength;?> grid_3">
		<label><?=(isset($label))?$label:"Image File";?></label>
		<div class="wrapper">
			<input type="file" class="hidden" />

			<?if(isset($value['id'])):?>
				<p class="fileName <?=str_replace(',',' ',$extensions);?>"><?=$value['filename'];?></p>
			<?else:?>
				<p class="fileName <?=str_replace(',',' ',$extensions);?>">No image uploaded yet&hellip;</p>			
			<?endif;?>
			
			<div class="preview">
				<?if(isset($value['id'])):?>
					<img src="application/media/<?=$value['thumbSrc'];?>" width="<?=$value['width'];?>" height="<?=$value['height'];?>" alt="<?=$value['filename'];?>"/>
				<?endif;?>
			</div>
			<div class="status hidden">
				<img src="modules/cms/views/images/bar.gif" class="progress" />
				<span class="message hidden"></span>
			</div>
			<div class="controls">
				<a class="command uploadLink" href="#"><?if(isset($value['id'])):?>reupload file<?else:?>upload a file<?endif;?></a>
				<?if(isset($value['id'])):?>
					<a class="command downloadLink" href="<?=Kohana::config('config.site_path');?>file/download/<?=$value['id'];?>">download</a>
					<a class="command clearImageLink" href="#">clear image</a>
				<?else:?>
					<a class="command clearImageLink hidden" href="#">clear image</a>
					<a class="command downloadLink hidden" target="_blank" href="#">download</a>
				<?endif;?>
			</div>
		</div>
	</div>
