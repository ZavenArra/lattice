<?php 
$config['resources']['libraryjs'] = array( 'views/js/lattice_settings' );
$config['navigation_request'] = 'navigation';
$config['layout'] = 'template/layout_admin';
$config['enable_slug_editing'] = true;
$config['graph_root_node'] = 'cmsRootNode';
$config['default_language'] = 'en';
$config['internationalization'] = true;
$config['preview'] = true;
$config['authrole'] = 'admin';
$config['associator_page_length'] = 20;

return $config;
