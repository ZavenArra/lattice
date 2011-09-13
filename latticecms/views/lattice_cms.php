<div id="cms" class="module classPath-lattice_modules_CMS rootObjectId-<? echo Graph::getRootNode(Kohana::config('cms.graphRootNode'))->id; ?> navigation-navigation userLevel-<?=$userlevel;?>">
	
	<?=$navigation;?>
	
<div class="localizationControls">
	<div class="localizationControls container_12">
	<ul class="clearFix">
	<?foreach($languages as $language):?>
		<li><a href="<?=latticeurl::site('cms/getTranslatedPage/ID/'.$language->code);?>"><?=$language->fullname;?></a><li>
	<?endforeach;?>
	</ul>
</div>

	<div class="pagesPane clearFix">
		<div id="pageContainer" class="clearFix"></div>
	</div>

</div>
