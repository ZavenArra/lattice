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
