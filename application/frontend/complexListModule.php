<h1><?=$content['main']['title'];?></h1>

ehllolist<ul id="complexList" >
<?foreach($content['main']['complexList'] as $label => $complexListListItem):?>
 <li class="complexListItem">
ehlloipe  <p class="title"> <?=$complexListListItem['title'];?></p>

ehlloipe  <p class="description"> <?=$complexListListItem['description'];?></p>

ehllocheckbox  <p class="singleCheckbox"> <?=$complexListListItem['singleCheckbox'];?></p>

ehlloradioGroup  <p class="singleRadioGroup"> <?=$complexListListItem['singleRadioGroup'];?></p>

ehllosingleFile  <?if(is_object($complexListListItem['file'])):?>
  <a href="<?=$complexListListItem['file']->fullpath;?>"><?=$complexListListItem['file']->filename;?></a>

  <?endif;?>

 </li>
<?endforeach;?>
</ul>

