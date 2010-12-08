<h1><?=$content['main']['title'];?></h1>

<ul id="imageList" >
<?foreach($content['main']['imageList'] as $label => $imageListListItem):?>
 <li class="imageListItem">
  <p class="title"> <?=$imageListListItem['title'];?></p>

  <p class="description"> <?=$imageListListItem['description'];?></p>

  <?if(is_object($imageListListItem['file'])):?>
   <img id="file" src="<?=$imageListListItem['file']->original->fullpath;?>" width="<?=$imageListListItem['file']->original->width;?>" height="<?=$imageListListItem['file']->original->height;?>" alt="<?=$imageListListItem['file']->original->filename;?>" />
  <?endif;?>

  <?if(is_object($imageListListItem['fileTwo'])):?>
   <img id="fileTwo" src="<?=$imageListListItem['fileTwo']->original->fullpath;?>" width="<?=$imageListListItem['fileTwo']->original->width;?>" height="<?=$imageListListItem['fileTwo']->original->height;?>" alt="<?=$imageListListItem['fileTwo']->original->filename;?>" />
  <?endif;?>

 </li>
<?endforeach;?>
</ul>

