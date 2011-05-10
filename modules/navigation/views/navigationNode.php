<? $keys = array_keys($content);?>
<li class="node <?=$content['nodeType'];?> <?=$content['contentType'];?> clearFix" id="node_<?=$content['id'];?>">
	<h5><?=$content['title'];?></h5>
	<div class="methods">
	<a class="icon togglePublishedStatus <?echo $content[$keys[2]]?'published':'';?> " href="#" title="unpublish <?=$content['title'];?>">publish</a>
		<a class="icon removeNode" title="delete">delete</a>
	</div>
</li>


