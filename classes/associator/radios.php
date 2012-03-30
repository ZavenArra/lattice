<?

Class Associator_Radios {

  public static function makePool($associatedViews, $poolViews){
    if(count($associatedViews)){
      $keys = array_map(array('Associator_Radios','titleIndex'), $associatedViews);
      $associatedViews = array_combine($keys, $associatedViews);
    }
    $poolViews = array_combine( array_map(array('Associator_Radios','titleIndex'), $poolViews),  $poolViews);
    foreach($associatedViews as $key => $view){
      $view->selected = true;
      $poolViews[$key] = $view;
    }

    array_walk($poolViews, array('Associator_Radios', 'setUniqueElementId'));

    ksort($poolViews);

    return $poolViews;
  }

  private static function titleIndex($view){
    return $view->object->title;
  }

  private static function setUniqueElementId($view){
    $view->uniqueElementId = LatticeCms::uniqueElementId();
  }

}
