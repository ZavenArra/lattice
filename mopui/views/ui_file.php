<div class="ui-FileElement field-<?=$field;?> extensions-<?=str_replace(',','_',$extensions);?> maxlength-<?=$maxlength;?> <?=$class;?> ">
	<label><?=isset($label)?$label:'File';?></label>
	<div class="wrapper">
		<input type="file" class="hidden" />
		<p class="<?=str_replace(',',' ',$extensions);?> filename"><?if($value):?><?=$value['filename'];?><?else:?>No file uploaded yet.<?endif;?></p>
		<div class="status hidden">
		<img src="<?=url::site('lattice/mopcms/views/images/bar.gif', null, false);?>" class="progress" />
			<span class="message hidden"></span>
		</div>
		<div class="controls clearFix">
			<a title="upload a file" class="command uploadLink" href="#">&uarr;</a>
			<?if($value):?>
				<a title="download <?=$value['filename'];?>"  class="command downloadLink" href="<?=url::site("file/download/{$value['id']}");?>">&darr;</a>
				<a title="clear this file" class="command clearImageLink" href="#">&times;</a>
			<?else:?>
				<a title="download" class="command downloadLink hidden" target="_blank" href="#">&darr;</a>
				<a title="clear this file" class="command clearImageLink hidden" href="#">&times;</a>
			<?endif;?>
		</div>
	</div>
</div>
