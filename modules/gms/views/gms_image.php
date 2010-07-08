<?
if( strlen( $image['title'] ) > 14 ){ 
	$title = substr( $image['title'], 0, 13 )."&hellip;"."jpg";
} else { 
	$title = $image['title']; 
};
?>

<li class="thumbnail" id="thumb_<?=$image['imageid'];?>">
	<a href="#" class="deletelink"><img src="../modules/gms/images/icon_delete.gif" alt="delete this image" /></a>
	<h4 class="title editable"><?=$title;?></h4>
	<img class="thumb" src= "../media/galleryimage_thumb_<?=$image['imageid'];?>.jpg" width="<?=$image['width']?>" height="<?=$image['height'];?>" alt="<?=$image['title'];?>" />
</li>
