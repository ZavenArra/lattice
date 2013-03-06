<?php
/**
 * Class: Navigation_Controller 
 *
 *
 */

class Navigation {


  /*
    Function:get_node_info
    Utility function to get one node
   */
  public static function get_node_info(& $object)
  {
    if (!strstr('Lattice_Object', get_class($object)))
    {
      $object = Graph::object($object);
    }

    $node_info = array();
    foreach (Kohana::config('navigation.nav_data_fields.object') as $send=>$field)
    {
      $node_info[$send] = $object->$field;
    }
    foreach (Kohana::config('navigation.nav_data_fields.object_type') as $field)
    {
      $node_info[$field] = $object->objecttype->$field;
    }
    if (!count($node_info['addable_objects']))
    {
      unset($node_info['addable_objects']);
    }


    foreach (Kohana::config('navigation.nav_data_fields.content') as $send=>$field)
    {
      $node_info[$send] = $object->$field;
    }


    if (!$node_info['title'])
    {
      $node_info['title'] = $node_info['slug'];
    }

    if (strlen($node_info['title']) > 25)
    {
      $node_info['title'] = substr($node_info['title'], 0, 23);
      $node_info['title'] .= '...';
    }

    return $node_info;
  }

   /*
    Function:get_node_info
    Utility function to get one node
    */
  public static function get_node_info_by_id($id)
  {
    $object = Graph::object($id);
    $node_info = Navigation::get_node_info($object);
    return $node_info;
  }

}

?>
