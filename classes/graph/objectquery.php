<?php

/*
 * To change this object_type, choose Tools | Templates
 * and open the object_type in the editor.
 */

/**
 * Description of objectquery
 *
 * @author deepwinter1
 */
class Graph_Object_query {

  public $attributes;


  public function init_with_array($attributes)
  {
    $this->attributes['label'] = NULL;
    $this->attributes['object_type_filter'] = NULL;
    $this->attributes['where'] = NULL;
    $this->attributes['from'] = NULL;
    $this->attributes['slug'] = NULL;

    foreach ($attributes as $key=>$value)
    {
      $this->attributes[$key] = $value;
    }
  }

  public function init_with_xml($xml)
  {
    $this->attributes['label'] = $xml->get_attribute('label');
    $this->attributes['object_type_filter'] = $xml->get_attribute('object_type_filter');
    $this->attributes['where'] = $xml->get_attribute('where');
    $this->attributes['from'] = $xml->get_attribute('from');
    $this->attributes['slug'] = $xml->get_attribute('slug');
  }

  public function run($parent_id = NULL)
  {

    $objects = Graph::object();

    //apply slug filter
    if ($this->attributes['slug'])
    {
      $objects->where('slug', '=', $this->attributes['slug']);
    }

    //apply optional parent filter
    if ($from = $this->attributes['from'] )
    { //
      if ($from != 'all')
      {
        if ($from == 'parent')
        {
          $objects->lattice_children_filter($parent_id);
        } else {
          $from = Graph::object($from);
          $objects->lattice_children_filter($from->id);
        }
        $objects->order_by('objectrelationships.sortorder');
      }
    }

    //apply optional object_type filter
    $objects = $objects->object_type_filter($this->attributes['object_type_filter']); 

    //apply optional SQL where filter
    if ($where = $this->attributes['where'])
    { //
      $objects->where($where);
    }


    $objects->published_filter();
    $objects = $objects->find_all();

    $items = array();
    foreach ($objects as $include_object)
    {
      $items_data = $include_object->get_content();
      $items[] = $items_data;
    }
    return $items;

  }
}

?>
