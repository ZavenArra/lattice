<?

$config['stuff'] = array (
);

$config['templates'] = array (
  'stuff' => 
  array (
    'blurb' => 
    array (
      'type' => 'ipe',
      'field' => 'blurb',
      'label' => 'Blurb',
      'class' => 'rows-4',
      'tag' => 'p',
    ),
    'listOfThings' => 
    array (
      'type' => 'list',
      'collectionName' => 'listOfThings',
      'label' => 'List of things',
      'object' => 'stuffItem',
    ),
  ),
  'stuffItem' => 
  array (
    'text' => 
    array (
      'type' => 'ipe',
      'field' => 'text',
      'label' => 'Text',
      'class' => 'rows-4',
      'tag' => 'p',
    ),
    'more' => 
    array (
      'type' => 'ipe',
      'field' => 'more',
      'label' => 'MORE',
      'class' => 'rows-4',
      'tag' => 'p',
    ),
  ),
);

$config['stuffItem'] = array (
);

$config['home'] = array (
);

