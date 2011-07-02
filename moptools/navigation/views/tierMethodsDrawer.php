<div class="tierMethodsDrawer">

<h3>Add an Item to this tier.</h3>

<ul class="methods">
<?foreach($addableObjects as $addableObject):?>
<li class="<?=$addableObject['nodeType'];?> <?=$addableObject['contentType'];?> addObjectId-<?=$addableObject['templateId'];?>"><?=$addableObject['templateAddText'];?></li>
<?endforeach;?>

</ul>
</div>
