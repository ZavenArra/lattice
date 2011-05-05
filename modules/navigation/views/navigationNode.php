
<? $keys = array_keys($content);?>
<?// echo $keys[2];?>
<?// echo $content[$keys[2]];?>
<?// if($keys[2] == 'published'):?>
<?//=$content['published'];?>
<?//endif;?>
<?//=$content['published'];?>

<li class="node <?=$content['nodeType'];?> <?=$content['contentType'];?> clearFix" id="node_<?=$content['id'];?>">
	<h5><?=$content['title'];?></h5>
	<div class="methods">
	<a class="icon togglePublish  <?echo $content[$keys[2]]?'published':'';?> " href="#" title="unpublish <?=$content['title'];?>">publish</a>
		<a class="icon removeNode" title="delete">delete</a>
	</div>
</li>


