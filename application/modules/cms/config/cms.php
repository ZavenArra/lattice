<?

$config['stuff'] = array (
);

$config['objects'] = array (
  'stuff' => 
  array (
    array (
      'type' => 'ipe',
      'field' => 'blurb',
      'label' => 'Blurb',
      'class' => 'rows-4',
      'tag' => 'p',
    ),
    array (
      'type' => 'list',
      'label' => 'List of things',
      'object' => 'stuffItem',
    ),
  ),
  'stuffItem' => 
  array (
    array (
      'type' => 'ipe',
      'field' => 'text',
      'label' => 'Text',
      'class' => 'rows-4',
      'tag' => 'p',
    ),
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

