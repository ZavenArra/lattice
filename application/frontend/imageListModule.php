<h1><?=$content['main']['title'];?></h1>

ehllolist<ul id="imageList" >
<?foreach($content['main']['imageList'] as $label => $imageListListItem):?>
 <li class="imageListItem">
ehlloipe  <p class="title"> <?=$imageListListItem['title'];?></p>

ehlloipe  <p class="description"> <?=$imageListListItem['description'];?></p>

ehllosingleImage  <?if(is_object($imageListListItem['file'])):?>
   <img id="file" src="<?=$imageListListItem['file']->original->fullpath;?>" width="<?=$imageListListItem['file']->original->width;?>" height="<?=$imageListListItem['file']->original->height;?>" alt="<?=$imageListListItem['file']->original->filename;?>" />
  <?endif;?>

ehllosingleImage  <?if(is_object($imageListListItem['file2'])):?>
   <img id="file2" src="<?=$imageListListItem['file2']->original->fullpath;?>" width="<?=$imageListListItem['file2']->original->width;?>" height="<?=$imageListListItem['file2']->original->height;?>" alt="<?=$imageListListItem['file2']->original->filename;?>" />
  <?endif;?>

 </li>
<?endforeach;?>
</ul>

