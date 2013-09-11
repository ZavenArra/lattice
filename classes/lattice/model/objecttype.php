<?php

/*
 * Class: Model_Objecttype
 */
class Lattice_Model_Objecttype extends ORM {

  protected $_has_many = array('object'=>array());
  protected $_belongs_to = array('object'=>array());

  /*
   * Variable: nonmappedfield
   * Array of fields to not pass through to the content field mapping logic
   */
  private $nonmappedfields = array('id', 'object_id', 'activity', 'loaded', 'objecttypename', 'nodeType');

  public function __construct($id=NULL)
  {

    if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
    {
      // it's the tmeplate identified, look up the integer primary key
      $result = DB::select('id')->from('objecttypes')->where('objecttypename', '=', $id)->execute()->current();
      $id = $result['id'];
    }

    parent::__construct($id);

  }

  public static function get_config($objectTypeName)
  {
    $config = core_lattice::config('objects', sprintf('//objectType[@name="%s"]', $objectTypeName));
    if ($config->length)
    {
      return $config->item(0);
    }

    $config = core_lattice::config('objects', sprintf('//list[@name="%s"]', $objectTypeName));
    if ($config->length)
    {
      return $config->item(0);
    } else {
      return FALSE;
    }
  }

  public static function get_elements($objectTypeName)
  {
    $config = Model_Objecttype::get_config($objectTypeName);
    $elements = core_lattice::config('objects', 'elements/*', $config);
    return $elements;
  }

  public static function get_element_config($objectTypeName, $element_name)
  {
    throw new Kohana_Expection("Not Implemented");
  }

  /*
   * Function: __get($column)
   * Custom getter, allows overriding database values with local file config values
   * Parameters: 
   * $column  - the column to get
   * Returns: The value
     */
    public function __get($column)
    {

      // check if this value is set in config files

      if (in_array($column, $this->nonmappedfields))
      {
        return parent::__get($column);
      }

      if (parent::__get('nodeType')=='container')
      {
        // For lists, values will be on the 2nd level 
        $x_query =  sprintf('//list[@name="%s"]', parent::__get('objecttypename'));
      } else {
        // everything else is a normal lookup
        $x_query =  sprintf('//objectType[@name="%s"]', parent::__get('objecttypename'));
      }

      $value_from_config=NULL;
      if ($column == 'addable_objects')
      {
        $x_query .= '/addableObject';
        $nodes = core_lattice::config('objects', $x_query);
        $value_from_config = array();
        foreach ($nodes as $node)
        {
          $entry = array();
          $entry['object_type_id'] = $node->getAttribute('objectTypeName');
          $entry['object_type_add_text'] = $node->getAttribute('addText');
          $t_config = core_lattice::config('objects', sprintf('//objectType[@name="%s"]', $entry['object_type_id'] ))->item(0);
          if ( ! count($t_config))
          {
            throw new Kohana_Exception('No object type definition by name: '.$entry['object_type_id']);
          }
          $entry['nodeType'] = $t_config->getAttribute('nodeType');
          $entry['contentType'] = $t_config->getAttribute('contentType');
          $value_from_config[] = $entry;
        }
      } else {
        $node = core_lattice::config('objects', $x_query)->item(0);
        if ($node)
          $value_from_config = $node->getAttribute($column);

        switch($column)
        {
        case 'initial_access_roles':
          if ($value_from_config)
          {
            $value_from_config = explode(',',$value_from_config);
          } else {
            $value_from_config = array();
          }
          break;
        }
      }

      return $value_from_config;	
    }


    /*
     * Function: unique_key($id)
     * Allows both integer id and objecttypename text to be unique key,
     * overrides function in base class
     * Parameters:
     * $id - a primary key
     * Returns: type of key being used
     */
    public function unique_key($id)
    {
      if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
      {
        return 'objecttypename';
      }

      return parent::unique_key($id);
    }

    /*
     * Function: defaults()
     * Get default values for insert
     */
    public function defaults()
    {
      $elements = Model_Objecttype::get_elements($this->objecttypename);
      $defaults = array();
      foreach ($elements as $element)
      {
        $default = $element->getAttribute('default');
        switch($default)
        {
        case 'now':
          $defaults[$element->getAttribute('name')] = date('Y/m/d H:i:s ');
          break;
        case 'none':
          break;

        default:
          if ($default)
          {
            $defaults[$element->getAttribute('name')] = $default; 
          }

        }

      }
      return $defaults;
    }

    /*
     * Function: get_published_members($limit)
     * This function queries all objects that use the current initialized object_type model object as thier object_type.
     * Parameters:
     * $limit - number of records to return
     * Returns: ORM Iterator of matching records
     */
    public function get_published_members($limit=NULL)
    {

      $o = Graph::object()
        ->published_filter()
        ->object_type_filter($this->objectTypeName);
      if ($limit)
      {
        $o->limit($limit);
      }
      $o = $o->find_all();
      return $o;

    }

    /*
     * Function: get_active_members($limit)
     * This function queries all objects that use the current initialized object_type model object as thier object_type.
     * Parameters:
     * $limit - number of records to return
     * Returns: ORM Iterator of matching records
     */
    public function get_active_members($limit=NULL)
    {

      if ( ! $this->loaded())
      {
        return array();
      }

      $o = Graph::object()
        ->active_filter()
        ->object_type_filter($this->objecttypename);
      if ($limit)
      {
        $o->limit($limit);
      }
      $o = $o->find_all();

      return $o;

    }



    public function configure_element($item)
    {

      switch($item->tagName)
      {

      case 'list':
        $lt_record = ORM::Factory('objecttype');
        $lt_record->objecttypename = $item->getAttribute('name');
        $lt_record->nodeType = 'container';
        $lt_record->save();
        break;

      default:
        Model_Objectmap::configure_new_field($this->id, $item->getAttribute('name'), $item->tagName );
        break;

      }

    }


}
