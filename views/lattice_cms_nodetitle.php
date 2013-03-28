<div class="objectTitle">	
	<?
	//display the item type
	
	$elementArray = array( 'type'=>'item', 'name'=>'item', 'isMultiline'=>'false', 'label'=>'Item Type', 'class'=>'grid_7 inactive', 'tag'=>'p', 'labelClass'=>'hidden' );
	echo cms_ui::build_ui_element($elementArray, $objecttypename);
	
	if ($allow_title_edit){
		$elementArray = array( 'type'=>'text', 'name'=>'title', 'isMultiline'=>'false', 'label'=>'Title', 'class'=>'grid_7', 'tag'=>'p', 'labelClass'=>'hidden' );
		echo cms_ui::build_ui_element( $elementArray, $title );
	}else{
		$elementArray = array( 'type'=>'text', 'name'=>'title', 'isMultiline'=>'false', 'label'=>'Title', 'class'=>'grid_7 inactive', 'tag'=>'p', 'labelClass'=>'hidden' );
		echo cms_ui::build_ui_element( $elementArray, $title );
	}	
	if ( Kohana::config('cms.enable_slug_editing') ){
		$elementArray = array( 'type'=>'text', 'name'=>'slug', 'isMultiline'=>'false', 'label'=>'Slug', 'class'=>'grid_4 discrete', 'tag'=>'p', 'labelClass'=>'hidden' );
		echo cms_ui::build_ui_element( $elementArray, $slug );
	}
	?>

	<?if ( Kohana::config('cms.page_meta') ):?>
		<a href="#" title='Edit page metadata' class="icon meta pageMeta">Edit Page Meta</a>
	<?endif;?>

	<a class='icon preview' title='Preview this page' href="<?=core_url::site($slug)?>">Preview this Page</a>

	<div class="clear"></div>

</div>
