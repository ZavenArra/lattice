<? $keys = array_keys($content);?>
<li title="<?=$content['title']; ?>" class="node <?=$content['nodeType'];?> <?=$content['contentType'];?> clearFix" id="node_<?=$content['id'];?>">
  <h5><?  echo strlen($content['title']) > 23 ? substr($content['title'], 0, 23).'...' : $content['title']; ?></h5>

	<div class="methods">
		<?if(isset($content['allowTogglePublish']) && $content['allowTogglePublish']=='true' ):?>
		<a class="icon togglePublishedStatus <?echo $content[$keys[2]]?'published':'';?> " href="#" title="unpublish <?=$content['title'];?>">publish</a>
		<?endif;?>
		<?if( isset( $content['allowDelete'] ) && $content['allowDelete']=='true' ):?>
		<a class="icon removeNode" title="delete">delete</a>
		<?endif;?>
	</div>
</li>


