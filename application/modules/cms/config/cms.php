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
    'listOfThings' => 
    array (
      'type' => 'list',
      'class' => 'listOfThings',
      'label' => 'List of things',
      'display' => 'inline',
      'templateId' => 'differentItem',
      'templateAddText' => 'Add a Stuff Item',
    ),
  ),
  'listOfThings' => 
  array (
    'cssClasses' => NULL,
    'label' => 'List of things',
  ),
  'differentItem' => 
  array (
    'blurb3' => 
    array (
      'type' => 'ipe',
      'field' => 'blurb3',
      'label' => 'WJAT',
      'class' => 'rows-4',
      'tag' => 'p',
    ),
    'blurb' => 
    array (
      'type' => 'ipe',
      'field' => 'blurb',
      'label' => 'EH KKDSJ  KDK',
      'class' => 'rows-4',
      'tag' => 'p',
    ),
  ),
);

$config['stuffItem'] = array (
);

$config['settings'] = array (
  'stuffItem' => 
  array (
    'components' => 
    array (
      array (
        'templateId' => 'listOfThings',
        'data' => 
        array (
          'title' => 'List of things',
        ),
      ),
    ),
  ),
);

$config['home'] = array (
);

$config['differentItem'] = array (
);

