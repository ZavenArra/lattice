<div id="cms" class="module classPath-lattice_modules_CMS rootObjectId-<? echo Graph::get_root_node(Kohana::config('cms.graphRootNode'))->id; ?> navigation-navigation userLevel-<?=$userlevel;?>">

<header>
	<? 
	
		echo Request::Factory('authstatus')->execute()->body() ;?>

	<?=$navigation;?>

</header>

<?if (Kohana::config('latticecms.localization')):?>
	<div class="localizationControls">
		<div class="localizationControls container_12">
			<ul class="clearFix">
			<?foreach($languages as $language):?>
				<li><a data-lang="<?=$language->code;?>" href="<?=$language->code;?>"><?=$language->fullname;?></a><li>
			<?endforeach;?>
			</ul>
		</div>
	</div>
<?endif;?>
	<div class="pagesPane clearFix">
		<div id="pageContainer" class="clearFix"></div>
	</div>
</div>
