<div class="objectTitle">	
	<!-- <a class='button floatRight' href="#">Preview this Page</a> -->
	<?
	if($allowTitleEdit){
		$elementArray = array( 'type'=>'text', 'name'=>'title', 'isMultiline'=>'false', 'label'=>'Title', 'class'=>'grid_7', 'tag'=>'p', 'labelClass'=>'hidden' );
		echo latticeui::buildUIElement( $elementArray, $title );
	}else{
		$elementArray = array( 'type'=>'text', 'name'=>'title', 'isMultiline'=>'false', 'label'=>'Title', 'class'=>'grid_7 inactive', 'tag'=>'p', 'labelClass'=>'hidden' );
		echo latticeui::buildUIElement( $elementArray, $title );
	}	
	if( Kohana::config('cms.enableSlugEditing') ){
		$elementArray = array( 'type'=>'text', 'name'=>'slug', 'isMultiline'=>'false', 'label'=>'Slug', 'class'=>'grid_4 discrete', 'tag'=>'p', 'labelClass'=>'hidden' );
		echo latticeui::buildUIElement( $elementArray, $slug );
	}
	?>
		<div class="clear"></div>
</div>

