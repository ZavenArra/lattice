<h1><?=$content['main']['title'];?></h1>

<ul id="imageList" >
<?foreach($content['main']['imageList'] as $label => $imageListListItem):?>
 <li class="imageListItem">
  <p class="title"> <?=$imageListListItem['title'];?></p>

  <p class="description"> <?=$imageListListItem['description'];?></p>

  <p class="file"> <?=$imageListListItem['file'];?></p>

  <p class="file"> <?=$imageListListItem['file'];?></p>

 </li>
<?endforeach;?>
</ul>

