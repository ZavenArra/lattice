<div class="objectTitle">	
	<?
	if($allowTitleEdit){
		$elementArray = array( 'type'=>'text', 'name'=>'title', 'isMultiline'=>'false', 'label'=>'Title', 'class'=>'grid_7', 'tag'=>'h2', 'labelClass'=>'hidden' );
		echo latticeui::buildUIElement( $elementArray, $title );
	}else{
		$elementArray = array( 'type'=>'text', 'name'=>'title', 'isMultiline'=>'false', 'label'=>'Title', 'class'=>'grid_7 inactive', 'tag'=>'h2', 'labelClass'=>'hidden' );
		echo latticeui::buildUIElement( $elementArray, $title );
	}	
	?>

	<?if( Kohana::config('cms.pageMeta') ):?>
		<a href="#" title='Edit page metadata' class="icon meta pageMeta">Edit Page Meta</a>
	<?endif;?>

	<a class='icon preview' title='Preview this page' href="/<?=$slug;?>">Preview this Page</a>

	<div class="clear"></div>

</div>
