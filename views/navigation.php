<div id="navigation" class="module classPath-lattice_modules_navigation_Navigation addObjectPosition-bottom">
	<script> //there should be a better way to do this
		lattice.CMS = new lattice.modules.CMS( 'cms' );
	</script>
	<div class="breadCrumb clearFix">
		<ul>
		
		</ul>
		
	</div>
	<ul>
		<?php if(Kohana::config('lattice.search_enabled')): ?>
		<li>
			<?php echo $search_view; ?>
		</li>
		<?php endif; ?>
	</ul>
	<div class="container">
		<div class="panes">
			<div class="pane">
			</div>
		</div>
	</div>
  <a href="#" class="slideToggle" >Show Navigation</a>
</div>
