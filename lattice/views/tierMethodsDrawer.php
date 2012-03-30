<?if( count( $addableObjects ) ):?>
<div class="tierMethodsDrawer">
	<div class="titleBar clearFix">
		<h5 class="title">Add an Item to this tier.</h5>
		<a href="#" class="icon close">close addable object selection</a>
	</div>
	<ul class="addableObjects">
		<?foreach($addableObjects as $addableObject):?>
		<li class="clearFix <?=$addableObject['nodeType'];?> <?=$addableObject['contentType'];?> objectTypeId-<?=$addableObject['objectTypeId'];?>"><h5><?=$addableObject['objectTypeAddText'];?></h5></li>
		<?endforeach;?>
	</ul>
</div>
<?endif;?>
