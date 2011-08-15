
<div id="<?=$id;?>_paging" class="<?=$class;?> cachePages-false totalPages-<?=$totalPages;?> marshal-<?=$controller;?> listId-<?=$id;?> objectNum-<?=$objectnum;?> ">
	<a class="pagingLeft  <?=$objectnum-1?'':'hidden'?> " <?if($objectnum-1):?>href="<?=$controller;?>/pagination/<?=$id;?>/<?=$objectnum-1;?>"<?else:?>href="#"<?endif;?> >Previous</a>
	<a class="pagingRight  <?=($objectnum < $totalPages)?'':'hidden'?>" <?if($objectnum < $totalPages):?>href="<?=$controller;?>/pagination/<?=$id;?>/<?=$objectnum+1;?>"<?endif;?> >Next</a>
	<img class="spinner hidden" src="modules/mopui/views/images/spinner.gif" width="12" height="12" alt="processing request..." />
</div>

