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
<!-- for testing superuser when addableObjects.length > 3 --> 
		<li class="clearFix object blah objectTypeId-0"><h5>Addable Object One</h5></li>
		<li class="clearFix object blah objectTypeId-1"><h5>Addable Object Two</h5></li>
		<li class="clearFix object blah objectTypeId-3"><h5>Addable Object Four</h5></li>
		<li class="clearFix object blah objectTypeId-0"><h5>Addable Object One</h5></li>
		<li class="clearFix object blah objectTypeId-1"><h5>Addable Object Two</h5></li>
		<li class="clearFix object blah objectTypeId-3"><h5>Addable Object Four</h5></li>
		<li class="clearFix object blah objectTypeId-0"><h5>Addable Object One</h5></li>
		<li class="clearFix object blah objectTypeId-1"><h5>Addable Object Two</h5></li>
		<li class="clearFix object blah objectTypeId-3"><h5>Addable Object Four</h5></li>
		<li class="clearFix object blah objectTypeId-0"><h5>Addable Object One</h5></li>
		<li class="clearFix object blah objectTypeId-1"><h5>Addable Object Two</h5></li>
		<li class="clearFix object blah objectTypeId-3"><h5>Addable Object Four</h5></li>
<!-- -->
	</ul>
</div>
<?endif;?>