<h1><?=$content['main']['title'];?></h1>

<ul id="simplelist" >
<?foreach($content['main']['simplelist'] as $label => $simplelistListItem):?>
 <li class="simpleListModuleItem">
  <p class="title"> <?=$simplelistListItem['title'];?></p>

  <p class="description"> <?=$simplelistListItem['description'];?></p>

 </li>
<?endforeach;?>
</ul>

