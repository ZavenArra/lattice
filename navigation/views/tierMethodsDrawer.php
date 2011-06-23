<?if( count( $addableObjects ) ):?>
<div class="tierMethodsDrawer">
	<h5>Add an Item to this tier.</h5>
	<ul class="methods">
		<?foreach($addableObjects as $addableObject):?>
		<li class="<?=$addableObject['nodeType'];?> <?=$addableObject['contentType'];?> templateId-<?=$addableObject['templateId'];?>"><?=$addableObject['templateAddText'];?></li>
		<?endforeach;?>
	</ul>
</div>
<?endif;?>