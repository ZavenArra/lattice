<?

$config['plants'] = array (
  'addable_objects' => 
  array (
    array (
      'templateId' => 'plant',
      'templateAddText' => 'Add a Plant',
    ),
  ),
  'allow_delete' => NULL,
  'allow_toggle_publish' => NULL,
  'landing' => 'DEFAULT',
  'allow_sort' => NULL,
);

$config['plant'] = array (
  'addable_objects' => 
  array (
    array (
      'templateId' => 'recipe',
      'templateAddText' => 'Add a Recipe',
    ),
    array (
      'templateId' => 'plantImage',
      'templateAddText' => 'Add an Image',
    ),
  ),
  'allow_delete' => true,
  'allow_toggle_publish' => NULL,
  'landing' => 'DEFAULT',
  'allow_sort' => NULL,
);

$config['plantImage'] = array (
  'addable_objects' => 
  array (
  ),
  'allow_delete' => true,
  'allow_toggle_publish' => NULL,
  'landing' => 'DEFAULT',
  'allow_sort' => NULL,
);

$config['recipe'] = array (
  'addable_objects' => 
  array (
  ),
  'allow_delete' => true,
  'allow_toggle_publish' => NULL,
  'landing' => 'DEFAULT',
  'allow_sort' => NULL,
);

