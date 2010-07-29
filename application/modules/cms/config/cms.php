<?

$config['uiresize'] =  array(
	'width'=>300,
	'height'=>300,
	'prefix' => 'uithumb',
	'forcewidth'=>true,
);

$config['plants'] = array (
	);

$config['plant'] = array (
);

$config['modules'] = array (
  'plant' => 
  array (
    array (
      'type' => 'ipe',
      'field' => 'scientificName',
      'label' => 'Scientific Name',
      'class' => 'rows-1',
      'tag' => 'p',
    ),
    array (
      'type' => 'ipe',
      'field' => 'group',
      'label' => 'Group',
      'class' => 'rows-1',
      'tag' => 'p',
    ),
    array (
      'type' => 'multiSelect',
      'field' => 'seasonsEdible',
      'label' => 'Seasons this Plant is Edible',
      'class' => NULL,
      'tag' => NULL,
      'options' => 
      array (
        'spring' => 'Spring',
        'summer' => 'Summer',
        'autumn' => 'Autumn',
        'winter' => 'Winter',
      ),
      'unsetLabel' => 'Select Seasons',
    ),
    array (
      'type' => 'ipe',
      'field' => 'season',
      'label' => 'Season Text',
      'class' => 'rows-2',
      'tag' => 'p',
    ),
    array (
      'type' => 'ipe',
      'field' => 'habitat',
      'label' => 'Habitat',
      'class' => 'rows-2',
      'tag' => 'p',
    ),
    array (
      'type' => 'ipe',
      'field' => 'range',
      'label' => 'Range',
      'class' => 'rows-2',
      'tag' => 'p',
    ),
    array (
      'type' => 'ipe',
      'field' => 'howToSpot',
      'label' => 'How to Spot',
      'class' => 'rows-2',
      'tag' => 'p',
    ),
    array (
      'type' => 'ipe',
      'field' => 'generalInfo',
      'label' => 'General Info',
      'class' => 'rows-20',
      'tag' => 'p',
    ),
    array (
      'type' => 'ipe',
      'field' => 'harvesting',
      'label' => 'Harvesting',
      'class' => 'rows-20',
      'tag' => 'p',
    ),
    array (
      'type' => 'ipe',
      'field' => 'cooking',
      'label' => 'Food Preparation',
      'class' => 'rows-20',
      'tag' => 'p',
    ),
    array (
      'type' => 'ipe',
      'field' => 'nutrition',
      'label' => 'Nutrition',
      'class' => 'rows-10',
      'tag' => 'p',
    ),
    array (
      'type' => 'ipe',
      'field' => 'medicinalUses',
      'label' => 'Medicinal Uses',
      'class' => 'rows-10',
      'tag' => 'p',
    ),
    array (
      'type' => 'ipe',
      'field' => 'positiveId',
      'label' => 'Positive Id Checklist',
      'class' => 'rows-8',
      'tag' => 'p',
    ),
    array (
      'type' => 'checkbox',
      'field' => 'hasPoisonousLookalikes',
      'label' => 'This plant has poisonous lookalikes',
      'class' => NULL,
      'tag' => NULL,
    ),
    array (
      'type' => 'ipe',
      'field' => 'poisonousLookalikes',
      'label' => 'Poisonous Lookalikes',
      'class' => 'rows-5',
      'tag' => 'p',
    ),
    array (
      'type' => 'ipe',
      'field' => 'similarPlants',
      'label' => 'Similar Plants and Confusing Factors',
      'class' => 'rows-5',
      'tag' => 'p',
    ),
  ),
  'plantImage' => 
  array (
    array (
      'type' => 'ipe',
      'field' => 'caption',
      'label' => 'Caption',
      'class' => 'rows-5',
      'tag' => 'p',
    ),
    array (
      'type' => 'checkbox',
      'field' => 'poisonous',
      'label' => 'Poisonous Plant',
    ),
    array (
      'type' => 'singleImage',
      'field' => 'image',
      'label' => 'Image',
      'class' => NULL,
      'tag' => NULL,
      'extensions' => 
      array (
        'jpg',
        'tiff',
        'tif',
      ),
      'maxlength' => NULL,
    ),
  ),
  'recipe' => 
  array (
    array (
      'type' => 'ipe',
      'field' => 'directions',
      'label' => 'Directions',
      'class' => 'rows-20',
      'tag' => 'p',
    ),
  ),
);

$config['plantImage'] = array (
);

$config['recipe'] = array (
);

