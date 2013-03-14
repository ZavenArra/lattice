<?php

/*
 * To change this object_type, choose Tools | Templates
 * and open the object_type in the editor.
 */

/**
 * Model for Objecth
 * 
 *
 * @author deepwinter1
 */
class Model_Lattice_Object extends Model_Lattice_Contentdriver {

  private static $dbmaps;
  /*
   * Variable: nonmappedfield
   * Array of fields to not pass through to the content field mapping logic
   */
  private $passthrough_fields = array('id', 'object_id', 'title', 'activity');



  public static function dbmap($objecttype_id, $column=NULL)
  {
    $objecttype = ORM::Factory('objecttype', $objecttype_id);
    $objecttype_id = $objecttype->id;

    if ( ! isset(self::$dbmaps[$objecttype_id]))
    {
      self::load_dbmap_for_object_type($objecttype_id);
    }
    if ( ! isset($column))
    {
      return self::$dbmaps[$objecttype_id];
    } else {
      if (isset(self::$dbmaps[$objecttype_id][$column]))
      {
        return self::$dbmaps[$objecttype_id][$column];
      } else {
        // Attempt lazy configuration
        $xpath = sprintf('//object_type[@name="%s"]/elements/*[@name="%s"]', $objecttype->objecttypename, $column);
        $element = lattice::config('objects', $xpath)->item(0);
        if ( ! count($element))
        {
          throw new Kohana_Exception('DBMap column not found or configured: '.$column);
        }
        $objecttype->configure_element($element);
        self::load_dbmap_for_object_type($objecttype_id);
        return self::$dbmaps[$objecttype_id][$column];
      }
    }
  }

  private static function load_dbmap_for_object_type($objecttype_id)
  {
    $dbmaps = ORM::Factory('objectmap')->where('objecttype_id', '=', $objecttype_id)->find_all();
    self::$dbmaps[$objecttype_id] = array();
    foreach ($dbmaps as $map)
    {
      self::$dbmaps[$objecttype_id][$map->column] = $map->type.$map->index;
    }
  }

  public static function reinit_dbmap($objecttype_id)
  {
    unset(self::$dbmaps[$objecttype_id]);
  }


  public function load_content_table($object)
  {

    $content = ORM::factory(inflector::singular('contents'));
    $this->contenttable = $content->where('object_id', '=', $object->id)->find();
    if ( ! $this->contenttable->loaded())
    {
      // we are going to allow no content object
      // in order to support having empty objects
      // throw new Kohana_Exception('BAD_Lattice_DB' . 'no content record for object ' . $this->id);
      $this->contenttable = ORM::factory(inflector::singular('contents'));
    }
    return $this->contenttable;
  }

  public function get_title($object)
  {
    $title = $this->contenttable->title; 
    if ( ! $title)
    {
      return $this->contenttable->field1;
    }
    return $title;
  }
  public function set_title($object, $title)
  {
    return $this->contenttable->title = $title; 
  }

  public function get_content_column($object, $column)
  {
    // This is a mapped field in the contents table
    $content_column = self::dbmap($object->objecttype_id, $column);       

    // No column mapping set up, attempt to run setup if it's configured.
    if ( ! $content_column)
    {

      // this column isn't mapped, check to see if it's in the xml
      if ($object->objecttype->node_type == 'container')
      {
        // For lists, values will be on the 2nd level 
        $x_path = sprintf('//list[@name="%s"]', $object->objecttype->objecttypename);

      } else {
        // everything else is a normal lookup
        $x_path = sprintf('//object_type[@name="%s"]', $object->objecttype->objecttypename);

      }

      $field_config = lattice::config('objects', $x_path . sprintf('/elements/*[@name="%s"]', $column));


      if ($field_config->item(0))
      {

        // quick fix for tags
        // tags is not a dbmapped field / configured field
        // so just return here
        if ($field_config->item(0)->tag_name == 'tags')
        {
          return $object->get_tag_strings();
        }

        // field is configured but not initialized in database
        $object->objecttype->configure_element($field_config->item(0));

        self::reinit_dbmap($object->objecttype_id);

        // now go aheand and get the mapped column
        $content_column = self::dbmap($object->objecttype_id, $column);
      }
    }


    if ( ! $content_column)
    {
      throw new Kohana_Exception('Column :column not found in content model', array(':column' => $column));
    }

    // If the column is an object, then this is a relationship with another object
    if (strstr($content_column, 'object'))
    {
      return $this->get_object_element($object, $column);
    }

    // Also need to check for file, but in 3.1 file will be an object itself and this will
    // not be necessary.
    if (strstr($content_column, 'file') AND ! is_object($this->contenttable->$content_column))
    {
      $file = ORM::Factory('file', $this->contenttable->$content_column);
      // file needs to know what module it's from if its going to check against valid resizes
      $this->contenttable->__set($content_column, $file);
    }

    return $this->contenttable->$content_column;
  }

  private function get_object_element($object, $column)
  {
    $object_element_relationship = ORM::Factory('objectelementrelationship')
      ->where('object_id', '=', $object->id)
      ->where('name', '=', $column)
      ->find();
    $object_element = Graph::object($object_element_relationship->elementobject_id);

    if ( ! $object_element->loaded())
    {
      // 
      //  it may make sense for the objecttype model to return the config info for itself
      //  or something similar
      // 
      if ($object->objecttype->node_type == 'container')
      {
        // For lists, values will be on the 2nd level 
        $x_path = sprintf('//object_type/elements/list[@name="%s"]', $object->objecttype->objecttypename);
      } else {
        // everything else is a normal lookup
        $x_path = sprintf('//object_type[@name="%s"]', $object->objecttype->objecttypename);
      }

      $element_config = lattice::config('objects', $x_path . sprintf('/elements/*[@name="%s"]', $column));

      // build the object
      $object_element = $object->add_element_object($element_config->item(0)->tag_name, $column);
    }
    return $object_element;

  }


  public function set_content_column($object, $column, $value)
  {

    if (in_array($column, $this->passthrough_fields))
    {
      return $this->contenttable->__set($column, $value);
    }


    // check for dbmap
    $mapped_column = self::dbmap($object->objecttype_id, $column);

    // TODO: This is a temporary stop gap to support title editing for objects that do not 
    // expose a title.  Handling of objects that don't expose a title (list items) needs further work
    if ($mapped_column=='field1' AND ($this->contenttable->title == $this->contenttable->field1))
    {
      $this->contenttable->title = $value;
    }
    if ($mapped_column AND ! strstr($mapped_column, 'object'))
    {
      $this->contenttable->$mapped_column = $value;
      $this->contenttable->save();
      return;
    }


    // this column isn't mapped, check to see if it's in the xml
    if ($object->objecttype->node_type == 'container')
    {
      // For lists, values will be on the 2nd level 
      $x_path = sprintf('//list[@name="%s"]', $object->objecttype->objecttypename);
    } else {
      // everything else is a normal lookup
      $x_path = sprintf('//object_type[@name="%s"]', $object->objecttype->objecttypename);
    }


    $field_config = lattice::config('objects', $x_path . sprintf('/elements/*[@name="%s"]', $column));
    if ($field_config->item(0))
    {
      // field is configured but not initialized in database
      $object->objecttype->configure_element($field_config->item(0));
      self::reinit_dbmap($object->objecttype_id);

      // now go aheand and save on the mapped column

      $mapped_column = self::dbmap($object->objecttype_id, $column);

      // If the column is an object, then this is a relationship with another object
      if (strstr($mapped_column, 'object'))
      {
        $object_element = $this->get_object_element($object, $column);

        if (is_array($value))
        {
          foreach ($value as $cluster_column => $cluster_value)
          {
            $object_element->$cluster_column = $cluster_value;
          }
        }
        return $object_element->save();;
      }

    }


    // TODO: This is a temporary stop gap to support title editing for objects that do not 
    // expose a title.  Handling of objects that don't expose a title (list items) needs further work
    if ($mapped_column=='field1' AND ($this->contenttable->title == $this->contenttable->field1))
    {
      $this->contenttable->title = $value;
    }

    $this->contenttable->$mapped_column = $value;
    $this->contenttable->save();
  }

  // this could potentially go into the base class 100%
  public function save_content_table($object, $inserting=FALSE)
  {
    if ( ! $this->contenttable)
    {
      $this->load_content_table($object);
    }
    if ($inserting)
    {
      $this->contenttable->object_id = $object->id;
    }
    $this->contenttable->save();
  }

  public function delete()
  {
    $this->contenttable->delete();
  }


}

?>
