
<div id="<?=$id;?>_paging" class="<?=$class;?> cachePages-false totalPages-<?=$totalPages;?> marshal-<?=$controller;?> listId-<?=$id;?> pageNum-<?=$pagenum;?> ">
	<a class="pagingLeft  <?=$pagenum-1?'':'hidden'?> " <?if($pagenum-1):?>href="<?=$controller;?>/pagination/<?=$id;?>/<?=$pagenum-1;?>"<?else:?>href="#"<?endif;?> >Previous</a>
	<a class="pagingRight  <?=($pagenum < $totalPages)?'':'hidden'?>" <?if($pagenum < $totalPages):?>href="<?=$controller;?>/pagination/<?=$id;?>/<?=$pagenum+1;?>"<?endif;?> >Next</a>
	<img class="spinner hidden" src="modules/mopui/views/images/spinner.gif" width="12" height="12" alt="processing request..." />
</div>

