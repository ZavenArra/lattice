<h1><?=$content['main']['title'];?></h1>

<ul id="complexList" >
<?foreach($content['main']['complexList'] as $label => $complexListListItem):?>
 <li class="complexListItem">
  <p class="title"> <?=$complexListListItem['title'];?></p>

  <p class="description"> <?=$complexListListItem['description'];?></p>

  <p class="singleCheckbox"> <?=$complexListListItem['singleCheckbox'];?></p>

  <p class="singleRadioGroup"> <?=$complexListListItem['singleRadioGroup'];?></p>

  <?if(is_object($complexListListItem['file'])):?>
  <a href="<?=$complexListListItem['file']->fullpath;?>"><?=$complexListListItem['file']->filename;?></a>

  <?endif;?>

 </li>
<?endforeach;?>
</ul>

