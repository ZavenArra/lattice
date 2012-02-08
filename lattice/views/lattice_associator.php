<?
/*
@todo, make ticket to add associator_<?=$listObjectId;?>
*/
?>
<div id="associator" data-objectid="LISTOBJECTID" class="module <?=$class;?> classPath-lattice_modules_Associator clearFix">
Pool:
<ul>
<?foreach($pool as $object):?>
  <li><?=$object->id;?>:<?=$object->title;?></li>
<?endforeach;?>
</ul>

Associated Objects:
<ul>
<?foreach($associatedChildren as $object):?>
  <li><?=$object->id;?>:<?=$object->title;?></li>
<?endforeach;?>
</ul>

</div>