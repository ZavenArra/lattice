	<div class="ui-FileElement field-<?=$field;?> action-savefile extensions-<?=str_replace(',','_',$extensions);?> maxlength-<?=$maxlength;?> <?=$class;?>">
		<label><?=(isset($label))?$label:"Image File";?></label>
		<div class="wrapper">
			<input type="file" class="hidden" />
			<p class="fileName <?=str_replace(',',' ',$extensions);?>"><?if(isset($value['id'])):?><?=$value['filename'];?><?else:?>No image uploaded yet&hellip;<?endif;?></p>
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
					<a class="command downloadLink" href="<?=Kohana::config('config.site_path');?>cms_file/directlink/<?=$value['id'];?>">download</a>
				<?else:?>
					<a class="command downloadLink hidden" target="_blank" href="#">download</a>
				<?endif;?>
			</div>
		</div>
	</div>
