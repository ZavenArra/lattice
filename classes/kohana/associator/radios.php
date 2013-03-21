<?php

Class Kohana_Associator_Radios {

  public static function make_pool($associated_views, $pool_views)
  {
    if (count($associated_views))
    {
      $keys = array_map(array('Associator_Radios','title_index'), $associated_views);
      $associated_views = array_combine($keys, $associated_views);
    }
    $pool_views = array_combine( array_map(array('Associator_Radios','title_index'), $pool_views),  $pool_views);
    foreach ($associated_views as $key => $view)
    {
      $view->selected = TRUE;
      $pool_views[$key] = $view;
    }

    array_walk($pool_views, array('Associator_Radios', 'set_unique_element_id'));

    ksort($pool_views);

    return $pool_views;
  }

  private static function title_index($view)
  {
    return $view->object->title;
  }

  private static function set_unique_element_id($view)
  {
    $view->unique_element_id = Lattice_cms::unique_element_id();
  }

}
