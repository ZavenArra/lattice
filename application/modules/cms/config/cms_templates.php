<?

$config['stuff'] = array (
  'addable_objects' => 
  array (
    array (
      'templateId' => 'stuffItem',
      'templateAddText' => 'Add a Stuff',
    ),
  ),
  'allow_delete' => NULL,
  'allow_toggle_publish' => NULL,
  'landing' => 'DEFAULT',
  'allow_sort' => NULL,
);

$config['stuffItem'] = array (
  'addable_objects' => 
  array (
  ),
  'allow_delete' => NULL,
  'allow_toggle_publish' => NULL,
  'landing' => 'DEFAULT',
  'allow_sort' => true,
);

$config['listOfThings'] = array (
  'templatename' => 'listOfThings',
  'type' => 'CONTAINER',
  'addable_objects' => 
  array (
    array (
      'templateId' => 'differentItem',
      'templateAddText' => 'Add a Stuff Item',
    ),
  ),
);

$config['home'] = array (
  'addable_objects' => 
  array (
  ),
  'allow_delete' => NULL,
  'allow_toggle_publish' => NULL,
  'landing' => 'DEFAULT',
  'allow_sort' => NULL,
);

$config['differentItem'] = array (
  'addable_objects' => 
  array (
  ),
  'allow_delete' => NULL,
  'allow_toggle_publish' => NULL,
  'landing' => 'DEFAULT',
  'allow_sort' => NULL,
);

