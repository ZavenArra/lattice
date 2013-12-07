<?php $keys = array_keys($content); ?>

<?
	$fitTitle = $content['title'];
	if(strlen($fitTitle) > 25){
		$fitTitle = substr($content['title'], 0, 25) ."&hellip;"; 	
	}

?>

<li title="<?php echo $content['title']; ?>" class="node <?php echo $content['nodeType'];?> <?php echo $content['contentType'];?>" id="node_<?php echo $content['id'];?>" >
  <h5><?php echo $fitTitle;?></h5>
  <?php if ( ( isset($content['allowTogglePublish']) && $content['allowTogglePublish']=='true' ) 
    || ( isset( $content['allowDelete'] ) && $content['allowDelete']=='true' ) ):?>
  <div class="methods">
		<?php if (isset($content['allowTogglePublish']) && $content['allowTogglePublish']=='true' ):?>
		<a class="icon togglePublishedStatus <?php echo $content[$keys[2]]?'published':'';?> " href="#" title="unpublish <?php echo $content['title'];?>">publish</a>
		<?endif;?>
		<?php if ( isset( $content['allowDelete'] ) && $content['allowDelete']=='true' ):?>
		<a class="icon removeNode" title="delete">delete</a>
		<?php endif;?>
	</div>
  <?php endif;?>
</li>



