<div class="ui-FileElement field-<?=$field;?> extensions-<?=implode('_',$extensions);?> maxlength-<?=$maxlength;?> <?=$class;?> ">
	<label><?=isset($label)?$label:'FIle';?></label>
	<div class="wrapper">
		<input type="file" class="hidden" />
		<p class="<?=implode(' ',$extensions);?> fileName"><?if($value):?><?=$value['filename'];?><?else:?>No file uploaded yet.<?endif;?></p>
		<div class="status hidden">
			<img src="modules/cms/views/images/bar.gif" class="progress" />
			<span class="message hidden"></span>
		</div>
		<div class="controls">
			<a class="command uploadLink" href="#"><?if($value):?>reupload file<?else:?>upload a file<?endif;?></a>
			<?if($value):?>
			<a class="command downloadLink" href="<?=Kohana::config('config.site_path');?>cms_file/directlink/<?=$value['id'];?>">download</a>
			<?endif;?>
		</div>
	</div>
</div>
