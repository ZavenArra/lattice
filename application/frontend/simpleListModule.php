<h1><?=$content['main']['title'];?></h1>

ehllolist<ul id="simplelist" >
<?foreach($content['main']['simplelist'] as $label => $simplelistListItem):?>
 <li class="simpleListModuleItem">
ehlloipe  <p class="title"> <?=$simplelistListItem['title'];?></p>

ehlloipe  <p class="description"> <?=$simplelistListItem['description'];?></p>

 </li>
<?endforeach;?>
</ul>

