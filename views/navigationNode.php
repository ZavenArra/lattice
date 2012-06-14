<? $keys = array_keys($content);?>
<li title="<?=$content['title']; ?>" class="node <?=$content['nodeType'];?> <?=$content['contentType'];?> clearFix" id="node_<?=$content['id'];?>">
<<<<<<< HEAD
  <h5><?=$content['pageLength']?><?  echo strlen($content['title']) > 23 ? substr($content['title'], 0, 23).'...' : $content['title']; ?></h5>
=======
  <h5><?  echo strlen($content['title']) > 23 ? substr($content['title'], 0, 23).'...' : $content['title']; ?></h5>
>>>>>>> 51399beea4565d4fb77b851918ff7592afe00101
	<div class="methods">
		<?if(isset($content['allowTogglePublish']) && $content['allowTogglePublish']=='true' ):?>
		<a class="icon togglePublishedStatus <?echo $content[$keys[2]]?'published':'';?> " href="#" title="unpublish <?=$content['title'];?>">publish</a>
		<?endif;?>
		<?if( isset( $content['allowDelete'] ) && $content['allowDelete']=='true' ):?>
		<a class="icon removeNode" title="delete">delete</a>
		<?endif;?>
	</div>
</li>


