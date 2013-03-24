<div class="objectTitle">	
	<?
	if ($allow_title_edit){
		$elementArray = array( 'type'=>'text', 'name'=>'title', 'isMultiline'=>'false', 'label'=>'Title', 'class'=>'grid_7', 'tag'=>'p', 'labelClass'=>'hidden' );
		echo cms_ui::buildUIElement( $elementArray, $title );
	}else{
		$elementArray = array( 'type'=>'text', 'name'=>'title', 'isMultiline'=>'false', 'label'=>'Title', 'class'=>'grid_7 inactive', 'tag'=>'p', 'labelClass'=>'hidden' );
		echo cms_ui::buildUIElement( $elementArray, $title );
	}	
	if ( Kohana::config('cms.enable_slug_editing') ){
		$elementArray = array( 'type'=>'text', 'name'=>'slug', 'isMultiline'=>'false', 'label'=>'Slug', 'class'=>'grid_4 discrete', 'tag'=>'p', 'labelClass'=>'hidden' );
		echo cms_ui::buildUIElement( $elementArray, $slug );
	}
	?>

	<?if ( Kohana::config('cms.page_meta') ):?>
		<a href="#" title='Edit page metadata' class="icon meta pageMeta">Edit Page Meta</a>
	<?endif;?>

	<a class='icon preview' title='Preview this page' href="/<?=$slug;?>">Preview this Page</a>

	<div class="clear"></div>

</div>
