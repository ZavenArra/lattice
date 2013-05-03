<?if ( count( $addable_objects ) ):?>
<div class="tierMethodsDrawer">
	<div class="titleBar clearFix">
		<h5 class="title">Add an Item to this tier.</h5>
		<a href="#" class="icon close">close addable object selection</a>
	</div>
	<ul class="addableObjects">
		<?foreach($addable_objects as $addable_object):?>
		<li class="clearFix <?=$addable_object['nodeType'];?> <?=$addable_object['contentType'];?> objectTypeId-<?=$addable_object['object_type_id'];?>"><h5><?=$addable_object['object_type_add_text'];?></h5></li>
		<?endforeach;?>
	</ul>
</div>
<?endif;?>
