<div class="ui-Associator field-<?-$field;?>">

	<ul class="associable">
		<?foreach($pool as $object):?>
		<li class="objectId-<?=$object->id;?>">
		<p class="objectTitle"><?=$object->contenttable->title;?></p> 
			<div class="controls">
				<a class="icon associate" href="cms/associate/"><span>associate</span></a>
				<a class="icon dissociate hidden" href="{can you build wole dissociate url here?}"><span>dissociate</span></a>
			</div>
		</li>
	<?endforeach;?>
	
	</ul>

	<ul class="associated">

		<li class="subObjectId-xxx">
			<p class="objectTitle">blah</p> 
			<div class="controls">
				<a class="icon associate hidden" href="{can you build wole associate url here?}"><span>associate</span></a>
				<a class="icon dissociate" href="{can you build wole dissociate url here?}"><span>dissociate</span></a>
			</div>
		</li>

		<li class="subObjectId-xxx">
			<p class="objectTitle">blah</p> 
			<div class="controls">
				<a class="icon associate hidden" href="{can you build wole associate url here?}"><span>associate</span></a>
				<a class="icon dissociate" href="{can you build wole dissociate url here?}"><span>dissociate</span></a>
			</div>
		</li>

		<li class="subObjectId-xxx">
			<p class="objectTitle">blah</p> 
			<div class="controls">
				<a class="icon associate hidden" href="{can you build wole associate url here?}"><span>associate</span></a>
				<a class="icon dissociate" href="{can you build wole dissociate url here?}"><span>dissociate</span></a>
			</div>
		</li>

	</ul>	
</div>
