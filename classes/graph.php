<?php

/**
 * Graph class - fundamental entry point into the data 'graph'
 *
 * @author deepwinter1
 */
/* @package Lattice */
class Graph {

  public static $mediapath; 

  // cache vars
  private static $_languages;

  public static function instance()
  {
    return  ORM::Factory('object');
  }

  public static function object($object_id =NULL)
  {

    // this will be implemented to support different drivers
    if ($object_id == NULL)
    {
      $object = ORM::Factory('object');
    } else {
      $object = ORM::Factory('object', $object_id);
      if (Kohana::find_file('classes/model/', $object->objecttype->objecttypename))
      {
        if ( is_subclass_of('Model_'.$object->objecttype->objecttypename, 'Model_Object'))
        {
          $object = ORM::Factory($object->objecttype->objecttypename, $object_id);
        } 
      }
    }
    return $object;
  }

  public static function create_object($object_type_name, $key=NULL)
  {
    $key ? $data = array('slug'=>$key) : $data=array(); 
    $object_id = Graph::instance()->add_object($object_type_name, $data);
    return Graph::object($object_id);

  }


  public static function lattice($lattice_id = 'lattice')
  {
    if (is_numeric($lattice_id))
    {
      return ORM::Factory('lattice', $lattice_id);
    } else {
      $lattice = ORM::Factory('lattice')->where('name', '=', $lattice_id)->find();
    }
    if (isset($lattice) AND ! $lattice->loaded())
    {
      $lattice = ORM::Factory('lattice');
      $lattice->name = $lattice_id;
      $lattice->save();
    }
    return $lattice;
  }

  public static function lattices()
  {
    return ORM::Factory('lattice')->find_all();
  }

  public static function file($file_id = NULL)
  {

    if ($file_id == NULL)
    {
      return ORM::Factory('file');
    } else {
      return ORM::Factory('file', $file_id);
    }

  }

  public static function get_active_tags()
  {
    $tags = ORM::Factory('tag')
      ->select('tag')
      ->distinct(TRUE)
      ->join('objects_tags')->on('objects_tags.tag_id', '=', 'tags.id')
      ->join('objects')->on('objects_tags.object_id', '=', 'objects.id')
      ->where('objects.published', '=', 1)
      ->where('objects.activity', 'IS', NULL)
      ->find_all();
    $tags_text = array();
    foreach ($tags as $tag)
    {
      $tags_text[]= $tag->tag;
    }
    return $tags_text;
  }

  public static function is_file_model($model)
  {
    if (get_class($model) == 'Model_File')
    {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public static function languages()
  {
    if ( ! self::$_languages)
    {
      self::$_languages =  ORM::Factory('language')->where('activity', 'is', NULL)->find_all();
    }
    return self::$_languages;
  }

  public static function language($id)
  {
    $languages = self::languages();
    foreach ($languages as $language)
    {

      if ($language->id == $id OR $language->code == $id)
      {
        return $language;
      }
    }
    throw new Kohana_Exception('Language not found :language', array(':language'=>$id));
  }


  public static function new_rosetta()
  {
    $rosetta = ORM::Factory('rosetta');
    $rosetta->save();
    return $rosetta->id;

  }

  public static function default_language()
  {
    return 1;
  }

  public static function mediapath()
  {
    if (self::$mediapath)
    {
      return self::$mediapath;
    }
    if (Kohana::config('lattice.staging'))
    {
      self::$mediapath = Kohana::config('lattice_cms.stagingmediapath');
    } else {
      self::$mediapath = Kohana::config('lattice_cms.basemediapath');
    }
    return self::$mediapath;
  }


  public static function configure_object_type($object_type_name, $force = FALSE)
  {


    // validation
    // 
    // check objects.xml for configuration

    if ( ! $force)
    {
      $object_type_config = NULL;
      $x_path =  sprintf('//objectType[@name="%s"]', $object_type_name);
      $x_path_list =  sprintf('//list[@name="%s"]', $object_type_name);
      if ( ! $object_type_config = lattice::config('objects', $x_path)->item(0))
      { 
        if ( ! $object_type_config = lattice::config('objects', $x_path_list)->item(0))
        {
          throw new Kohana_Exception("Object type '".$object_type_name."' does not exist in objects.xml"); 
        }
      }

      foreach (lattice::config('objects', 'elements/*', $object_type_config) as $item)
      {
        if ($item->getAttribute('name')=='title')
        {
          throw new Kohana_Exception('Title is a reserved field name');
        }
      }

    }

    // find or create object_type record
    $t_record = ORM::Factory('objecttype', $object_type_name );
    if ( ! $t_record->loaded())
    {
      $t_record = ORM::Factory('objecttype');
      $t_record->objecttypename = $object_type_name;
      $t_record->nodeType = 'object';
      $t_record->save();
    }

    /*
     * This can just happen on the fly - lazy configure
     foreach ( lattice::config('objects', '//objectType[@name="'.$object_type_name.'"]/elements/*') as $item)
     {
       $t_record->configure_element($item);
  }
  Model_Object::reinit_dbmap($t_record->id); //  Rethink this.
       */
  }

  public static function add_root_node($root_node_object_type)
  {
    // $this->driver->get_object_type_object($roo_node_object_type)
    Graph::object()->add_object($root_node_object_type);
  }

  public static function get_root_node($root_node_object_type)
  {
    // $this->driver->get_object_type_object($roo_node_object_type)
    $object_type = ORM::Factory('objecttype')->where('objecttypename', '=', $root_node_object_type)->find();
    $object =  Graph::object()->object_type_filter($object_type->objecttypename)->find();
    if ( ! $object->loaded())
    {
      throw new Kohana_Exception('Root node not found: '.$root_node_object_type);
    }
    return $object;
  }

  public static function get_lattice_root($lattice_id = 'lattice', $language_code = 'en')
  {
    $language = ORM::Factory('language')
      ->where('code', '=', $language_code)
      ->find();

    $object_relationship = ORM::Factory('objectrelationship')
      ->where('lattice_id', '=', Graph::lattice($lattice_id))
      ->where('object_id', '=', 0)
      ->join('objects')->on('objects.id', '=', 'objectrelationships.connectedobject_id' )
      ->where('language_id', '=', $language->id)
      ->find();
    $root = ORM::Factory('object', $object_relationship->id);
    if ( ! $root->loaded())
    {
      throw new Kohana_Exception('Root object not found');
    }
    return $root;

  }


}

