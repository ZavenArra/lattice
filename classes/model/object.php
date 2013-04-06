<?php
/**
 * Model_Object
 * The ORM Object that connects to the objects table in the database
 * This class also contains all functionality for using the object in the graph.
 * Model_Object hosts a content table for tracking content data, which is implemented
 * by extending 4 abstract methods from this class.
 * @package Lattice
 * @author deepwinter1
 */
class Model_Object extends ORM implements arrayaccess {

  protected $_belongs_to = array(
    'objecttype' => array()
  );
  protected $_has_one = array(
    'objecttype' => array()
  );
  protected $_has_many = array(
    'tag' => array(
      'model' => 'tag',
      'through' => 'objects_tags',
      'foreign_key' => 'object_id',
    ),
    'roles' => array(
      'model' => 'role',
      'through' => 'objects_roles',
      'foreign_key' => 'object_id',
    ),
    'users' => array(
      'model' => 'user',
      'through' => 'objects_users',
      'foreign_key' => 'object_id'
    )
  );
  // cache
  private $lattice_parents = array();

  protected $content_driver = NULL;

  protected $messages = array();
  // this needs to come from the associator page_length in objects.xml
  private $items_per_page = 8;
  private $page_num = 0;
  public function __construct($id=NULL)
  {


    if ( ! empty($id) AND is_string($id) AND !ctype_digit($id))
    {

      // check for translation reference
      if (strpos('_', $id))
      {
        $slug = strtok($id, '_');
        $language_code = strtok($id);
        $object = Graph::object($slug);
        $translated_object = $object->translated($language_code);
        return $translated_object;
      } else {

        $result = DB::select('id')->from('objects')->where('slug', '=', $id)->execute()->current();
        $id = $result['id'];
      }
    }
    $this->items_per_page=Kohana::config('cms.associator_page_length');
    parent::__construct($id);

    if ($this->loaded())
    {
      $this->load_content_driver();
    }
  }



  /*
   * Variable: create_slug($title, $for_page_id)
   * Creates a unique slug to identify a object
   * Parameters:
   * $title_or_slug - optional starting point for the slug
   * $for_page_id - optionally indicate the id of the object this slug is for to avoid FALSE positive slug collisions
   * Returns: The new, unique slug
   */
  public static function create_slug($title_or_slug=NULL, $for_page_id=NULL)
  {
    // create slug
    if ($title_or_slug!=NULL)
    {
      $title_or_slug = str_replace('.', '-', $title_or_slug);
      $slug = preg_replace('/[^a-z0-9\- ]/', '', strtolower($title_or_slug));
      $slug = str_replace('.', '-', $slug);
      $slug = str_replace(' ', '-', $slug);

      $slug = trim($slug);
      $slug = substr($slug, 0, 50);


      $check_slug = Graph::object()
        ->where('slug', '=', $slug);
      if ($for_page_id != NULL)
      {
        $check_slug->where('id', '!=', $for_page_id);
      }
      $check_slug->find();
      if ( ! $check_slug->loaded())
      {
        return $slug;
      }


      $check_slug = Graph::object()
        ->where('slug', 'REGEXP',  '^'.$slug.'[0-9]*$')
        ->order_by("slug", 'DESC');

      if ($for_page_id != NULL)
      {
        $check_slug->where('id', '!=', $for_page_id);
      }
      $check_slug = $check_slug->find_all();
      if (count($check_slug))
      {
        $idents = array();
        foreach ($check_slug as $ident)
        {
          $idents[] = $ident->slug;
        }
        natsort($idents);
        $idents = array_values($idents);
        $maxslug = $idents[count($idents)-1];
        if ($maxslug)
        {
          $curindex = substr($maxslug, strlen($slug));
          $newindex = $curindex+1;
          if (strlen($slug) > 50 - strlen($newindex))
          {
            $slug = substr($slug, 0, 50 - strlen($newindex) );
          }
          $slug .= $newindex;
        }
      }
      return $slug;
    } else {
      return self::create_slug('slug'.str_replace(' ', '',microtime())); // try something else
    }
  }

  /*
   * convert_new_lines($value)
   * Replace \n with <br /> for saving into the database
   * This replacement is wrapped by detection for \n values that should not be converted into br tags, 
   * those which follow lines that only contain html tags
   */
  public static function convert_new_lines($value)
  {
    $value = preg_replace('/(<.*>)[ ]*\n/', "$1------Lattice_NEWLINE------", $value);
    $value = preg_replace('/[ ]*\n/', '<br />', $value);
    $value = preg_replace('/------Lattice_NEWLINE------/', "\n", $value);
    return $value;
  }

  /*
   *
   */
  public static function resize_image($original_filename, $new_filename, $width, $height,
    $force_dimension='width', $crop='FALSE', $aspect_follows_orientation='false')
  {
    // set up dimenion to key off of
    switch($force_dimension)
    {
    case 'width':
      $key_dimension = Image::WIDTH;
      break;
    case 'height':
      $key_dimension = Image::HEIGHT;
      break;
    default:
      $key_dimension = Image::AUTO;
      break;
    }

    $image = Image::factory(Graph::mediapath().$original_filename);

    // just do the resample
    // set up sizes
    $resize_width = $width;
    $resize_height = $height;

    if ($aspect_follows_orientation == 'TRUE' )
    {
      $osize = getimagesize(Graph::mediapath().$original_filename);
      $horizontal = FALSE;
      if ($osize[0] > $osize[1])
      {
        // horizontal
        $horizontal = TRUE; 
      }
      $newsize = array($resize_width, $resize_height);
      sort($newsize);
      if ($horizontal)
      {
        $resize_width = $newsize[1];
        $resize_height = $newsize[0];
      } else {
        $resize_width = $newsize[0];
        $resize_height = $newsize[1];
      }
    }

    if ($crop=='TRUE')
    {
      // resample with crop
      // set up sizes, and crop
      if ( ($image->width / $image->height) > ($image->height / $image->width) )
      {
        $crop_key_dimension = Image::HEIGHT;
      } else {
        $crop_key_dimension = Image::WIDTH;
      }
      $image->resize($width, $height, $crop_key_dimension)->crop($width, $height);
      $image->save(Graph::mediapath().$new_filename);
    }

    // maintain aspect ratio
    // use the forcing when it applied
    // forcing with aspectfolloworientation is gonna give weird results! 
    $image->resize($resize_width, $resize_height, $key_dimension);

    $image->save(Graph::mediapath() .$new_filename);

  }


  protected function load_content_driver()
  {

    $objectTypeName = $this->objecttype->objecttypename;
    if ($objectTypeName)
    {
      if (Kohana::find_file('classes/model/lattice', strtolower($objectTypeName)))
      {
        $model_name = 'Model_Lattice_' . $objectTypeName;
        $model = new $model_name($object_id);
        $this->content_driver = $model;
      } else {
        $this->content_driver = new Model_Lattice_Object();
      }
      if ($this->loaded())
      {
        $this->content_driver->load_content_table($this);
      }
      if ( ! $this->content_driver)
      {
        throw new Kohana_Exception('Content Driver did not load for '.$this->id);
      }
    }
  }





  /*
   *   Function: __get
   *     Custom getter for this model, links in appropriate content table
   *       when related object 'content' is requested
   *         */

  public function __get($column)
  {

    if (in_array($column, array_keys($this->_table_columns)))
    {
      // this catches the configured colums for this table
      return parent::__get($column);

    } elseif ($column == 'parent')
    {
      return $this->get_lattice_parent(); 

    } elseif ($column == 'objecttype' OR $column == 'object_type')
    {
      $return = parent::__get('objecttype');
      return $return;

    } elseif (in_array($column, array_keys($this->__get('objecttype')->_table_columns)))
    {
      return $this->__get('objecttype')->$column; 

    } elseif ($column == 'roles')
    {
      return parent::__get('roles');

    } elseif ($column == 'sortorder')
    {
      return parent::__get('sortorder');
    }

    if ( ! $this->loaded())
    {
      return NULL; 
    }

    switch($column)
    {
    case 'title':
      return $this->content_driver()->get_title($this);
      break;
    case 'tags':
      return $this->get_tag_strings();
      break;
    }


    // check if this is a list container
    $list_config = core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list[@name="%s"]', $this->objecttype->objecttypename, $column));
    if ($list_config->length)
    {

      // look up the object type
      $family = $column;

      $list_object_type = ORM::Factory('objecttype', $family);
      if ( ! $list_object_type->id)
      {
        $this->objecttype->configure_element($list_config->item(0));
        $list_object_type = ORM::Factory('objecttype', $family);
      }

      $list_container_object = ORM::Factory('listcontainer')
        ->lattice_children_filter($this->id)
        ->object_type_filter($list_object_type->id)
        ->active_filter()
        ->find();
      // The next line is either necessary to correctly initialize the model
      // or listcontainer could be refactored as a storage class of object
      // Lattice_Model_...
      $list_container_object = ORM::Factory('listcontainer', $list_container_object->id);
      if ( ! $list_container_object->id)
      {
        $list_container_object_id = $this->add_object($family);
        $list_container_object = ORM::Factory('listcontainer', $list_container_object_id);
      }
      return $list_container_object;
    }

    return $this->content_driver()->get_content_column($this, $column);

  }


  // Providing access to content_driver as a quick fix for 
  // needing the id of the content table, plus there could
  // be other reasons that justify this.
  public function content_driver()
  {
    if ( ! $this->content_driver)
    {

      $objectTypeName = $this->objecttype->objecttypename;

      if ($objectTypeName)
      {
        if (Kohana::find_file('classes/model/lattice', $objectTypeName))
        {
          $model_name = 'Model_Lattice_' . $objectTypeName;
          $model = new $model_name($object_id);
          $this->content_driver = $model;
        } else {
          $this->content_driver = new Model_Lattice_Object();
        }
        if ($this->loaded())
        {
          $this->content_driver->load_content_table($this);
        }
      }

    }
    if ( ! $this->content_driver)
    {
      throw new Kohana_Exception('Content Driver did not load for object id '.$this->id);
    }

    return $this->content_driver;

  }

  /*
   * Function: save()
   * Public interface to save(), can only be called from a loaded object.  Use create_object to save a new object
   */
  public function save(Validation $validation = NULL)
  {
    if ( ! $this->loaded())
    {
      throw new Kohana_Exception('Calling save on object which is not loaded.  Use create_object to insert a new object');
    }

    parent::save();
    $this->save_content_table($this);
    return $this;

  }



    /*
      Function: _save()
      Custom save function, makes sure the content table has a record when inserting new object
      This is the implementation method
     */
  private function _save()
  {
    $inserting = FALSE;
    if ($this->loaded() == FALSE)
    {
      $inserting = TRUE;
    }

    parent::save();

    // Postpone adding record to content table until after lattice point
    // is set.
    if ( ! $inserting)
    {
      $this->save_content_table($this);
    }
    return $this;

  }


  private function insert_content_record()
  {

    // create the content driver table
    $objectTypeName = $this->objecttype->objecttypename;
    if (Kohana::find_file('classes','model/lattice/'.strtolower($objectTypeName)))
    {
      $model_name = 'Model_Lattice_' . $objectTypeName;
      $model = new $model_name($object_id);
      $this->content_driver = $model;
    } else {
      $this->content_driver = new Model_Lattice_Object();
    }
    // $this->content_driver->load_content_table($this);
    // $this->content_driver->set_content_column($this, 'object_id', $this->id);
    $this->content_driver->save_content_table($this, TRUE);
  }

  private function save_content_table()
  {
    $this->content_driver()->save_content_table($this);
  }

  public function get_element_config($element_name)
  {

    if ($this->__get('objecttype')->nodeType == 'container')
    {
      // For lists, values will be on the 2nd level 
      $x_path = sprintf('//list[@name="%s"]', $this->__get('objecttype')->objecttypename);
    } else {
      // everything else is a normal lookup
      $x_path = sprintf('//objectType[@name="%s"]', $this->__get('objecttype')->objecttypename);
    }
    $field_config = core_lattice::config('objects', $x_path . sprintf('/elements/*[@name="%s"]', $element_name));
    return $field_config;
  }

   /*
     Function: __set
     Custom setter, saves to appropriate content_driver
     */

    public function __set($column, $value)
    {

      if ( ! $this->_loaded)
      {
        // Bypass special logic when just loading the object
        return parent::__set($column, $value);
      }

      if ( ! is_object($value))
      {
        $value = Model_Object::convert_new_lines($value);
      }


      if ($column == 'slug')
      {
        parent::__set('slug', Model_Object::create_slug($value, $this->id));
        parent::__set('decoupleSlugTitle', 1);
        return;
      } elseif ($column == 'title')
      {
        if ( ! $this->decoupleSlugTitle)
        {
          $this->slug = Model_Object::create_slug($value, $this->id);
        }
        $this->content_driver()->set_title($this, $value);
        return;
      } elseif (in_array($column, array('dateadded')))
      {
        parent::__set($column, $value);
      } elseif ($this->_table_columns AND in_array($column, array_keys($this->_table_columns)))
      {
        parent::__set($column, $value);

        // TODO: Change this to an objectTypeName match below
      } elseif ($column == 'tags')
      {
        $tags = explode(',', $value);
        foreach ($tags as $tag_name)
        {
          $this->add_tag($tag_name);
        }
      } elseif ($column)
      {
        $o = $this->_object;
        $objecttype_id = $o['objecttype_id'];

        $object_type = ORM::Factory('objecttype', $objecttype_id);
			
		echo $object_type->objecttypename . ' | ' . $column .' | ';
			
        $xpath = sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $object_type->objecttypename, $column);
        $field_info = core_lattice::config('objects', $xpath)->item(0);
        
        var_dump($field_info);  echo '<br />';
        
        if ( ! $field_info)
        {
          throw new Kohana_Exception('Invalid field for objecttype, using XPath : :xpath', array(':xpath' => $xpath));
        }


        $this->content_driver()->set_content_column($this, $column, $value);
      } else {
        throw new Kohana_Exception('No field found for __set');
      }

    }

    public function deactivate()
    {
      $this->cascade_delete();
    }

    public function reactivate()
    {
      $this->cascade_undelete();
    }

    public function delete()
    {
      if ( ! $this->loaded())
      {
        throw new Kohana_Exception("Trying to delete object that is not loaded");
      }
      $this->cascade_delete(TRUE);
    }


    private function cascade_undelete()
    {
      $this->activity = new Database_Expression(NULL);
      $this->slug = Model_Object::create_slug($this->contenttable->title, $this->id);
      $this->contentdriver()->undelete();
      $this->_save();

      $children = $object->get_lattice_children();
      foreach ($children as $child)
      {
        $child->cascade_undelete();
      }

    }

    private function cascade_delete($permanent=FALSE)
    {
      $this->activity = 'D';
      $this->slug = DB::expr('NULL');
      $this->_save();

      $children = $this->get_lattice_children();
      foreach ($children as $child)
      {
        $child->cascade_delete($permanent);
      }

      if ($permanent)
      {
        $this->contentdriver()->delete();
        parent::delete();
      }
    }

    /*
     * Functions for returning messages
     */
    protected function add_message($message)
    {
      $this->messages[] = $message;
    }

    public function get_messages()
    {
      return $this->messages;
    }


    public function translate($language_code)
    {
      if ( ! $this->loaded())
      {
        return $this;
      }

      $rosetta_id = $this->rosetta_id;
      if ( ! $rosetta_id)
      {
        throw new Kohana_Exception('No Rosetta ID found for object during translation with object_id :object_id',
          array(':object_id'=>$rosetta_id)
        );
      }
      if (is_numeric($language_code))
      {
        $language_id = intval($language_code);
      } else {
        // this could just ask the graph, to avoid going to database again
        $language_id = ORM::Factory('language', $language_code)->id;
      }
      if ( ! $language_id)
      {
        throw new Kohana_Exception('Invalid language code :code', array(':code'=>$language_code));
      }

      $translated_object = Graph::object()
        ->where('rosetta_id', '=', $rosetta_id)
        ->where('objects.language_id', '=', $language_id)
        ->find();
      if ( ! $translated_object->loaded())
      {
        throw new Kohana_Exception('No translated object available for object_id :id with language :language',
          array(':id'=>$object_id,
          ':language'=>$language_code));

      }
      return $translated_object;

    }

    public function update_with_array($data)
    {
      foreach ($data as $field => $value)
      {
        switch ($field)
        {
        case 'slug':
        case 'decoupleSlugTitle':
        case 'date_added':
        case 'published':
        case 'activity':
          $this->__set($field, $value);
          break;
        default:
          $this->$field = $value;
          break;
        }
      }
      $this->_save();
      return $this->id;
    }

    public function get_content_as_array()
    {

      $fields = ORM::Factory('objectmap')
        ->where('objecttype_id', '=', $this->objecttype->id)
        ->find_all();
      foreach ($fields as $map)
      {
        $content[$map->column] = $this->__get($map->column);
      }
      return $content;
    }

    public function set_data_query_where($key, $value)
    {
      $this->data_query_targets = array();
    }

    public function add_tag($tag_name)
    {
      $tag_name = trim($tag_name);
      $tag = ORM::Factory('tag')->where('tag', '=', $tag_name)->find();
      if ( ! $tag->loaded())
      {
        $tag = ORM::Factory('tag');
        $tag->tag = $tag_name;
        $tag->language_id = $this->language_id;
        $tag->save();
      }
      if ( ! $this->has('tag', $tag))
      {
        $this->add('tag', $tag);
      }
      return $this;
    }

    public function remove_tag($tag_name)
    {
      $tag = ORM::Factory('tag')->where('tag', '=', $tag_name)->find();
      if ( ! $tag->loaded())
      {
        throw new Kohana_Exception("Tag :tag_name does not exist in the database.", array(':tag_name' => $tag_name));
      }
      $this->remove('tag', $tag);
      return $this;
    }

    public function get_tag_objects()
    {
      $tag_objects = ORM::Factory('objects_tag')
        ->select('*')
        ->select('tag')
        ->where('object_id', '=', $this->id)
        ->join('tags')->on('tag_id', '=', 'tags.id')
        ->find_all();
      return $tag_objects;
    }

    public function get_tag_strings()
    {
      $tag_objects = $this->get_tag_objects();
      $tags = array();
      foreach ($tag_objects as $tag_object)
      {
        $tags[] = $tag_object->tag;
      }
      return $tags;
    }

    public function get_user_objects()
    {
      $user_objects = ORM::Factory('objects_user')
        ->select('*')
        ->select('username')
        ->where('object_id', '=', $this->id)
        ->join('users')->on('user_id', '=', 'users.id')
        ->find_all();
      return $user_objects;
    }

    public function get_user_strings()
    {
      $user_objects = $this->get_user_strings_objects();
      $user = array();
      foreach ($user_objects as $user_object)
      {
        $users[] = $user_object->username;
      }
      return $users;
    }



    public function get_content()
    {
      return $this->get_page_content();
    }

    public function get_page_content()
    {
      $content = array();
      $content['id'] = $this->id;
      $content['title'] = $this->title;
      $content['slug'] = $this->slug;
      $content['dateadded'] = $this->dateadded;
      $content['objectTypeName'] = $this->objecttype->objecttypename;

      $fields = core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*', $this->objecttype->objecttypename));

      foreach ($fields as $field_info)
      {
        $field = $field_info->getAttribute('name');
        $content[$field] = $this->__get($field);
      }

      // find any lists
      foreach (core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list', $this->objecttype->objecttypename)) as $list)
      {
        $name = $list->getAttribute('name');
        $content[$name] = $this->get_list_content_as_array($name);
      }

      // find any associators
      foreach (core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/associator', $this->objecttype->objecttypename)) as $list)
      {
        $name = $list->getAttribute('name');
        $content[$name] = $this->get_lattice_children($list->getAttribute('name'));;
      }
      return $content;
    }

    public function get_fields()
    {
      $fields = array('id', 'title', 'slug', 'dateadded', 'objecttypename');

      $object_fields = core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*', $this->objecttype->objecttypename));
      foreach ($object_fields as $field_info)
      {
        $fields[] = $field_info->getAttribute('name');   
      }

      foreach (core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list', $this->objecttype->objecttypename)) as $list)
      {
        $family = $list->getAttribute('name');
        $fields[] = $family;
      }

      return $fields;

    }

    public function get_list_content_as_array($family)
    {
      $iter = $this->get_list_content($family);
      $content = array();
      foreach ($iter as $item)
      {
        $content[] = $item->get_page_content();
      }
      return $content;
    }

    public function get_list_content($family)
    {
      // get container
      $c_template = ORM::Factory('objecttype', $family);
      $container = Graph::object()
        ->lattice_children_filter($this->id)
        ->where('objecttype_id', '=', $c_template->id)
        ->where('activity', 'IS', NULL)
        ->find();

      return $container->get_published_children();
    }

    public function get_published_children($lattice = 'lattice')
    {

      $children = Graph::object()->lattice_children_filter($this->id, $lattice)
        ->where('published', '=', 1)
        ->where('activity', 'IS', NULL)
        ->order_by('objectrelationships.sortorder')
        ->join('objecttypes')->on('objects.objecttype_id', '=', 'objecttypes.id')
        ->where('nodeType', '!=', 'container')
        ->find_all();
      return $children;
    }

    public function get_lattice_children($lattice = 'lattice')
    {
      $children = Graph::object()
        ->lattice_children_filter($this->id, $lattice)
        ->where('activity', 'IS', NULL)
        ->order_by('objectrelationships.sortorder')
        ->find_all();
      return $children;

    }

    public function get_lattice_children_paged($lattice = 'lattice')
    {
      $children = Graph::object()
        ->lattice_children_filter_paged($this->id, $lattice)
        ->where('activity', 'IS', NULL)
        ->order_by('objectrelationships.sortorder')
        ->find_all();
      return $children;

    }


    public function get_next_published_peer()
    {
      $next = Graph::object()
        ->lattice_children_filter($this->get_lattice_parent()->id)
        ->where('published', '=', 1)
        ->where('activity', 'IS', NULL)
        ->order_by('objectrelationships.sortorder', 'ASC')
        ->where('sortorder', '>', $this->sortorder)
        ->limit(1)
        ->find();
      if ($next->loaded())
      {
        return $next;
      } else {
        return NULL;
      }
    }

    public function get_prev_published_peer()
    {
      $next = Graph::object()
        ->lattice_children_filter($this->get_lattice_parent()->id)
        ->where('published', '=', 1)
        ->where('activity', 'IS', NULL)
        ->order_by('objectrelationships.sortorder',  'DESC')
        ->where('sortorder', '<', $this->sortorder)
        ->limit(1)
        ->find();
      if ($next->loaded())
      {
        return $next;
      } else {
        return NULL;
      }
    }

    public function get_first_published_peer()
    {
      $first = Graph::object()
        ->lattice_children_filter($this->get_lattice_parent()->id)
        ->where('published', '=', 1)
        ->where('activity', 'IS', NULL)
        ->order_by('objectrelationships.sortorder', 'ASC')
        ->limit(1)
        ->find();
      if ($first->loaded())
      {
        return $first;
      } else {
        return NULL;
      }
    }

    public function get_last_published_peer()
    {
      $last = Graph::object()
        ->lattice_children_filter($this->get_lattice_parent()->id)
        ->where('published', '=', 1)
        ->where('activity', 'IS', NULL)
        ->order_by('objectrelationships.sortorder', 'DESC')
        ->limit(1)
        ->find();
      if ($last->loaded())
      {
        return $last;
      } else {
        return NULL;
      }
    }

    public function set_sort_order($order, $lattice='lattice')
    {
      $lattice = Graph::lattice($lattice);

      for ($i = 0; $i < count($order); $i++)
      {
        if ( ! is_numeric($order[$i]))
        {
          return;
          //  this breaks frontend, but returning a typical lattice error would allow us to log it, or provide a less terrifying experience.
          throw new Kohana_Exception('bad sortorder string: >' . $order[$i] . '<');
        }

        $object_relationship = ORM::Factory('objectrelationship')
          ->where('object_id', '=', $this->id)
          ->where('lattice_id', '=', $lattice->id)
          ->where('connectedobject_id', '=', $order[$i])
          ->find();
        if ( ! $object_relationship->loaded())
        {
          throw new Kohana_Exception('No object relationship found matching sort order object_id :object_id, lattice_id :lattice_id, connectedobject_id :connectedobject_id',
            array(':object_id' => $this->id,
            ':lattice_id' => $lattice->id,
            ':connectedobject_id' => $order[$i]
          )
        );
        }
        $object_relationship->sortorder = $i;
        $object_relationship->save();
      }
    }


    public function save_field($field, $value)
    {
      $this->__set($field, $value);
      $this->_save();
      return $this->$field;
    }

    public function save_uploaded_file($field, $filename, $type, $tmp_name)
    {
      $tmp_name = $this->move_uploaded_file_to_tmp_media($tmp_name);
      return $this->save_file($field, $filename, $type, $tmp_name);
    }

    /*
     *
     *  Returns: file model of saved file
     * */

    public function save_uploaded_image($field, $filename, $type, $tmp_name, $additional_resizes=array())
    {
      $tmp_name = $this->move_uploaded_file_to_tmp_media($tmp_name);
      $file = $this->save_image($field, $filename, $type, $tmp_name, $additional_resizes);

      return $file;
    }

    private function move_uploaded_file_to_tmp_media($tmp_name)
    {
      $save_name = Model_Object::make_file_save_name('tmp') . microtime();

      if ( ! move_uploaded_file($tmp_name, Graph::mediapath() . $save_name))
      {
        $result = array(
          'result' => 'failed',
          'error' => 'internal error, contact system administrator',
        );
        return $result;
      }
      // Kohana::$log->add(Log::INFO, 'tmp moved file to ' . Graph::mediapath() . $save_name);

      return $save_name;
    }

    public static function make_file_save_name($filename)
    {
      if ( ! $filename)
      {
        return NULL;
      }
      $filename = str_replace('&', '_', $filename);
      $xarray = explode('.', $filename);
      $nr = count($xarray);
      $ext = $xarray[$nr - 1];
      $name = array_slice($xarray, 0, $nr - 1);
      $name = implode('.', $name);
      $i = 1;
      if ( ! file_exists(Graph::mediapath() . "$name" . '.' . $ext))
      {
        $i = '';
      } else {
        for (; file_exists(Graph::mediapath() . "$name" . $i . '.' . $ext); $i++)
        {     
        }
      }
      // clean up extension
      $ext = strtolower($ext);
      if ($ext == 'jpeg')
      {
        $ext = 'jpg';
      }
      return $name . $i . '.' . $ext;
    }

    public function save_file($field, $filename, $type, $tmp_name)
    {
      if ( ! is_object($file = $this->__get($field)))
      {
        $file = ORM::Factory('file', $this->__get($field));
      }

      $replacing_empty_file = FALSE;
      if ( ! $file->filename)
      {
        $replacing_empty_file = TRUE;
      }

      $file->unlink_old_file();
      $save_name = Model_Object::make_file_save_name($filename);

      if ( ! copy(Graph::mediapath() . $tmp_name, Graph::mediapath() . $save_name))
      {
        throw new Lattice_Exception('this is a MOP Exception');
      }
      unlink(Graph::mediapath() . $tmp_name);

      $file->filename = $save_name;
      $file->mime = $type;
      $file->save(); // inserts or updates depending on if it got loaded above

      $this->$field = $file->id;
      $this->_save();

      // Handle localized object linked via rosetta
      if ($replacing_empty_file)
      {

        $languages = Graph::languages();
        foreach ($languages as $translation_language)
        {

          if ($translation_language->id == $this->language_id)
          {
            continue;
          }

          $translated_object = $this->translate($translation_language->id);
          $translated_object->$field = $file->id;
          $translated_object->save();

        }   
      }

      return $file;
    }

    public function verify_image($field, $tmp_name)
    {
      $origwidth = $size[0];
      $origheight = $size[1];
      // Kohana::$log->add(Log::INFO, var_export($parameters, TRUE));
      if (isset($parameters['minheight']) AND $origheight < $parameters['minheight'])
      {
        $result = array(
          'result' => 'failed',
          'error' => 'Image height less than minimum height',
        );
        return $result;
      }
      if (isset($parameters['minwidth']) AND $origwidth < $parameters['minwidth'])
      {
        $result = array(
          'result' => 'failed',
          'error' => 'Image width less than minimum width',
        );
        return $result;
      }
    }

    public function save_image($field, $filename, $type, $tmp_name, $additional_resizes = array() )
    {
      // do the saving of the file
      $file = $this->save_file($field, $filename, $type, $tmp_name);
      $imagefilename = $this->process_image($file->filename, $field, $additional_resizes );

      return $file;
    }

    /*
     * Functon: process_image($filename, $parameters)
     * Create all automatice resizes on this image
     */

    public function process_image($filename, $field, $additional_resizes = array())
    {

      // First check for tiff, and convert if necessary
      $ext = substr(strrchr($filename, '.'), 1);
      switch ($ext)
      {
      case 'tiff':
      case 'tif':
      case 'TIFF':
      case 'TIF':
        //   Kohana::$log->add(Log::INFO, 'Converting TIFF image to JPG for resize');

        $imagefilename = $filename . '_converted.jpg';
        $command = sprintf('convert %s %s', addcslashes(Graph::mediapath() . $filename, "'\"\\ "), addcslashes(Graph::mediapath() . $imagefilename, "'\"\\ "));
        //    Kohana::$log->add(Log::INFO, $command);
        system(sprintf('convert %s %s', addcslashes(Graph::mediapath() . $filename, "'\"\\ "), addcslashes(Graph::mediapath() . $imagefilename, "'\"\\ ")));
        break;
      default:
        $imagefilename = $filename;
        break;
      }

      // do the resizing
      $objecttypename = $this->objecttype->objecttypename;
      $resizes = core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]/resize', $objecttypename, $field
      )
    );
      foreach ($resizes as $resize)
      {

        $new_filename = NULL;
        $tag = NULL;
        if ($tag = $resize->getAttribute('name'))
        {
          $prefix = $tag . '_';
          $new_filename = $prefix .  $imagefilename;
        } else {
          $prefix = '';
          $new_filename = $imagefilename;
        }
        $save_name = Graph::mediapath() . $new_filename;

        // This dependency should be moved out of latticecms
        // Rootgraph should never require latticecms
        Model_Object::resize_image($imagefilename, $new_filename, $resize->getAttribute('width'), $resize->getAttribute('height'), $resize->getAttribute('force_dimension'), $resize->getAttribute('crop'), $resize->getAttribute('aspect_follows_orientation')
        );

        if (isset($oldfilename) AND $new_filename != $prefix . $oldfilename)
        {
          if (file_exists(Graph::mediapath() . $oldfilename))
          {
            unlink(Graph::mediapath() . $oldfilename);
          }
        }

        if (array_key_exists($tag, $additional_resizes))
        {
          unset($additional_resizes[$tag]);
        }
      }

      // And process resizes passed in from caller
      foreach ($additional_resizes as $uiresize)
      {
        Model_Object::resize_image($imagefilename, $uiresize['prefix'] . '_' . $imagefilename, $uiresize['width'], $uiresize['height'], $uiresize['force_dimension'], $uiresize['crop'], $uiresize['aspect_follows_orientation'] 
        );
      }


      return $imagefilename;
    }


    /* Query Filters */

    public function object_type_filter($object_types)
    {
      if ( ! $object_types)
      {
        return $this;
      }

      if (is_numeric($object_types))
      {
        $this->where('objecttype_id', '=', $object_types);
      } elseif (strpos(',', $object_types))
      {
        $t_names = explode(',', $object_types);
        $t_ids = array();
        foreach ($t_names as $tname)
        {
          $result = DB::query("Select id from objecttypes where objecttypename = '$object_types'")->execute();
          if ( ! $result->current->id AND !Model_Objecttype::get_config($tname))
          {
            throw new Kohana_Exception('Invalid object type requested in object_type_filter '.$object_types);
          }
          $t_ids[] = $result->current()->id;
        }
        $this->in('objecttype_id', $t_ids);
      } elseif ($object_types == 'all')
      {
        // set no filter
      } else {
        $object_type = $object_types; //  argument is just a singluar string
        $result = DB::query(Database::SELECT, "Select id from objecttypes where objecttypename = '$object_type'")->execute()->current();
        if ( ! $result['id'] AND !Model_Objecttype::get_config($object_type))
        {
          throw new Kohana_Exception('Invalid object type requested in object_type_filter '.$object_type);
        }
        $this->where('objecttype_id', '=', intval($result['id']));
      }
      return $this;
    }

    public function content_filter($wheres)
    {
      //   $driver_info = $this->content_driver()->driver_info();
      // Extension point for implementing support for content_filter with other drivers
      $driver_info = array(
        'driver' => 'mysql', 
        'table_name' => 'contents',
      );
      if ($driver_info['driver']=='mysql')
      {

        foreach ($wheres as $where)
        {

          if ($where[0] == 'title')
          {
            $this->join($driver_info['table_name'])->on('objects.id', '=', $driver_info['table_name'].'.object_id');
            $this->where($driver_info['table_name'].'.'.$where[0], $where[1], $where[2]);

          } else {
            $view_table_name = $this->join_content_column($where[0]);
            $this->where($view_table_name.'.'.$where[0], $where[1], $where[2]);

          }
        }
      }
      return $this;
    }

    public function join_content_column($column)
    {
      $map = core_lattice::config('objects', '//objectType[elements/*/@name="'.$column.'"]'); 
      $map_query = array();
      if ($map->length)
      {
        foreach ($map as $object_type_config)
        {
          $object_type = ORM::Factory('objecttype', $object_type_config->getAttribute('name')); 
          if ( ! $object_type->loaded())
          {
            continue;
            // Continue here because the object type might not be lazy-configured yet 
          }
          $mapped_column = Model_Lattice_Object::dbmap($object_type->id, $column);
          $map_query[] = 'select object_id, '.$mapped_column.' as '.$column
            .' from contents where object_id in (select id from objects where objecttype_id = '.$object_type->id.')';  
        }

      }
      if ( ! count($map_query))
      {
        throw new Kohana_Exception('Content Column: '.$column.' not specifid for any objects');
      }
      $map_query = implode($map_query, ' UNION ');
      $map_query = '('.$map_query.') ';
      $view_table_name =  $column.'View';
      $this->join(new Database_Expression($map_query . $view_table_name ))->on('objects.id', '=', $view_table_name.'.object_id');
      return $view_table_name;
    }


    public function no_container_objects()
    {
      $res = ORM::Factory('objecttype')
        ->where('nodeType', '=', 'container')
        ->find_all();
      $t_ids = array();
      foreach ($res as $container)
      {
        $t_ids[] = $container->id;
      }
      if (count($t_ids))
      {
        $this->where('objecttype_id', 'NOT IN', DB::Expr('(' . implode(',', $t_ids) . ')'));
      }
      return $this;
    }

    public function published_filter()
    {
      $this->where('published', '=', 1);
      $this->active_filter();
      return $this;
    }

    public function active_filter()
    {
      $this->where('objects.activity', 'IS', NULL);
      return $this;   
    }

    // filter objects based on related objects in our associator
    public function associator_filter($parent_id,$objects)
    {
      // $objects is id's of our objects that we want to match against
      // we're joining via object relationships
      // all object id's from objectrelationships
      $o_ids = array();
      foreach ($objects as $object)
      {
        $o_ids[] = $object["id"];
      }
      if (count($o_ids)>0)
      {

       /*return $this->join('objectrelationships')->on('objectrelationships.object_id','=','objects.id')
          ->where('objectrelationships.connectedobject_id','IN',$o_ids);
     */
    Kohana::$log->add(Log::INFO,print_r($o_ids,1))->write();

    $lattice = Graph::lattice('lattice');
    $this->join('objectrelationships', 'LEFT')->on('objects.id', '=', 'objectrelationships.connectedobject_id');
    $this->where('objectrelationships.lattice_id', '=', $lattice->id);
    $this->where('objectrelationships.object_id', 'IN', $o_ids);
    return $this;
      } else {
        Kohana::$log->add(Log::INFO,"none")->write();
        return $this;
      }

    }

    public function tagged_filter($tags)
    {
      return $this->join('objects_tags')->on('objects_tags.object_id', '=', 'objects.id')
        ->join('tags')->on('objects_tags.tag_id', '=', 'tags.id')
        ->where('tag', '=', $tags);
    }

    public function lattice_children_filter($parent_id, $lattice="lattice")
    {
      // run this query without limit to get a count
      $lattice = Graph::lattice($lattice);
      $this->join('objectrelationships', 'LEFT')->on('objects.id', '=', 'objectrelationships.connectedobject_id');
      $this->where('objectrelationships.lattice_id', '=', $lattice->id);
      $this->where('objectrelationships.object_id', '=', $parent_id);
      return $this;
    }

    public function lattice_children_filter_paged($parent_id, $lattice="lattice")
    {
      // twg -> thiago removed call to lattice_children_filter and instead duplicated with pagination
      //         tom added it to lattice_children_filter which was also paginating nav ages and lists...
      // run this query without limit to get a count
      $lattice = Graph::lattice($lattice);
      $this->join('objectrelationships', 'LEFT')->on('objects.id', '=', 'objectrelationships.connectedobject_id');
      $this->where('objectrelationships.lattice_id', '=', $lattice->id);
      $this->where('objectrelationships.object_id', '=', $parent_id);
      // twg added pagination here
      $this->limit($this->items_per_page);
      $this->offset($this->items_per_page * $this->page_num);
      return $this;
    }

    public function set_page_num($num=0)
    {
      $this->page_num = $num;
    }

    public function set_items_per_page($num=0)
    {
      $this->items_per_page = $num;

    }

  /* 
   public function lattice_children_count($parent_id, $lattice)
{
     $children = Graph::object();
     $children->join('objectrelationships', 'LEFT')->on('objects.id', '=', 'objectrelationships.connectedobject_id');
     $children->where('objectrelationships.lattice_id', '=', $lattice->id);
     $children->where('objectrelationships.object_id', '=', $parent_id);
     $children->where('activity', 'IS', NULL);
     $c = count( $children->count_all());
    return  $c;
   }
     */

    public function lattice_children_query($lattice='lattice')
    {
      return Graph::instance()->lattice_children_filter($this->id, $lattice);

    }

    public function get_lattice_parents($lattice='lattice', $just_one = FALSE)
    {

      $lattice_parents = $this->lattice_parents_query($lattice)->find_all();
      if ($just_one)
      {
        if (count($lattice_parents))
        {
          return $lattice_parents[0];
        } else {
          return NULL;
        }
      } else {
        return $lattice_parents;
      }
    }

    public function get_lattice_parent($lattice='lattice')
    {
      return $this->get_lattice_parents($lattice, TRUE);
    }

    public function lattice_parents_filter($child_id, $lattice="lattice")
    {
      $lattice = Graph::lattice($lattice);

      $this->join('objectrelationships', 'LEFT')->on('objects.id', '=', 'objectrelationships.object_id');
      $this->where('objectrelationships.lattice_id', '=', $lattice->id);
      $this->where('objectrelationships.connectedobject_id', '=', $child_id);
      return $this;

    }

    public function lattice_parents_query($lattice='lattice')
    {
      return Graph::instance()->lattice_parents_filter($this->id, $lattice);

    }


    public function get_published_parents($lattice='lattice')
    {
      $this->get_lattice_parents($lattice, TRUE);
    }



    public function is_within_sub_tree($object_id, $lattice='lattice')
    {
      $sub_tree_object = NULL;
      if ( ! is_object($object_id))
      {
        $sub_tree_object = Graph::object($object_id);
      } else {
        $sub_tree_object = $object_id;
      }
      if ( ! $sub_tree_object->loaded())
      {
        throw new Kohana_Exception('Checking for object subtree of object that is not in database: :objectid',
          array(':objectid'=>$object_id));
      }
      $object = $this;
      do{
        if ($object->id == $sub_tree_object->id)
        {
          return TRUE;
        }
      } while($object = $object->get_lattice_parent($lattice) );

      return FALSE;
    }

    private function is_table_column($column)
    {
      if (in_array($column, array_keys($this->_table_columns)))
      {
        return TRUE;
      }
      return FALSE;
    }

    public function get_sort_order($lattice, $current_id)
    {
      $lattice = Graph::lattice($lattice);
      Kohana::$log->add(Kohana_Log::INFO, $lattice->id);
      $sort_order_query = clone($this);
      $sort_order_query->where('objects.id', '=', $current_id);
      $sort_order_query->join( array('objectrelationships', 'objectrelationshipstosort') )->on('objects.id', '=', 'objectrelationshipstosort.connectedobject_id');
      $sort_order_query->where('objectrelationshipstosort.lattice_id', '=', $lattice->id);
      $sort_order_query->select(array('objectrelationshipstosort.sortorder', 'sortorder'));
      $object = $sort_order_query->find();
      Kohana::$log->add(Kohana_Log::INFO, $object->id . '{'.$object->sortorder);
      return $object->sortorder;
    }

    public function adjacent_record($sort_field, $direction, $current_id = NULL, $lattice='lattice' )
    {
      $id_inequalities = array('>', '<');
      switch($direction)
      {
      case 'next':
        $inequality = '>=';
        $order = 'ASC';
        $id_inequality = 0;
        break;
      case 'prev':
        $inequality = '<=';
        $order = 'DESC';
        $id_inequality = 1;
        break;
      default:
        throw new Kohana_Exception('Bad direction sent to adjacent record');
        break;
      }

      $query = clone($this); 
      if ($current_id)
      {
        $current = Graph::object($current_id);
      } else {
        $current = $this;
      }

      if ($this->is_table_column($sort_field))
      {
        $sort_value = $current->$sort_field;
        $query->where($sort_field, $inequality, $sort_value)
          ->order_by($sort_field, $order);
      } elseif ($sort_field == 'sortorder')
      {
        if ($lattice == NULL)
        {
          throw new Kohana_Exception('sortorder field requires lattice parameter');
        }
        // assume the default lattice
        //   $query->join('objectrelationships')->on('objects.id', '=', 'objectrelationships.
        // get current sort order
        //  get it! 
        // $query->join //join objectrelationships
        // this assumes we've already joined objectrelatinpshios
        $sort_value = $this->get_sort_order($lattice, $current->id);  // implement this function
        $query->join( array('objectrelationships', 'objectrelationshipstosort') )->on('objects.id', '=', 'objectrelationshipstosort.connectedobject_id');
        $query->where('objectrelationshipstosort.lattice_id', '=', Graph::lattice($lattice)->id);
        $query->where('objectrelationshipstosort.'.$sort_field, $inequality, $sort_value);
        $query->order_by('objectrelationshipstosort.sortorder', $order);
      } else  {
        $sort_value = $current->$sort_field;
        $query->content_filter( array(array($sort_field, $inequality, $sort_value)) )->order_by($sort_field, $order);  
      }

      /* TODO: Tiebreaker code is really problematic, since the DESC/ASC sortorder doesn't get applied by Kohana 
       * disciminately to each sort field, i.e. it applies the same sortorder to both 
       $query_copy = clone($query); // reclone so we can rerun if necessary
      // $query->where('objects.id', $id_inequalities[$id_inequality], $current->id)->order_by('id', $order)->limit(1);
      $query->where('objects.id', '!=', $current->id)->order_by('id', $order)->limit(1);
      $result = $query->find();
      if ( ! $result->loaded())
      {
        // id inequality (tiebreaker) is backwards, flip it and rerun the query
        $id_inequality += 1;
        $id_inequality %= 2;

        // $query_copy->where('objects.id', $id_inequalities[$id_inequality], $current->id)->order_by('id', $order)->limit(1);
        $query_copy->where('objects.id', '!=', $current->id)->order_by('id', $order)->limit(1);
        $result = $query_copy->find();
    }
     */

    $query->where('objects.id', '!=', $current->id)->limit(1);
    $result = $query->find();
    return $result;
    } 


    public function next($sort_field, $current_id=NULL, $lattice=NULL)
    {
      return $this->adjacent_record($sort_field, 'next', $current_id, $lattice);
    }

    public function prev($sort_field, $current_id=NULL, $lattice=NULL)
    {
      return $this->adjacent_record($sort_field, 'prev', $current_id, $lattice);
    }

    public function add_object($objectTypeName, $data = array(), $lattice = NULL, $rosetta_id = NULL, $language_id = NULL)
    {

      $new_object_type = ORM::Factory('objecttype', $objectTypeName);

      $new_object = $this->add_lattice_object($objectTypeName, $lattice, $rosetta_id, $language_id);


      /*
       * Set up any translated peer objects
     */
    if ( ! $rosetta_id)
    {
      $languages = Graph::languages();
      foreach ($languages as $translation_language)
      {           
        if ($translation_language->id == $new_object->language_id)
        {
          continue;
        }

        if ($this->loaded())
        {
          $translated_parent = $this->get_translated_object($translation_language->id);

          $translated_parent->add_lattice_object($new_object->objecttype->objecttypename, $lattice, $new_object->rosetta_id, $translation_language->id);
        } else {
          Graph::object()->add_lattice_object($new_object->objecttype->objecttypename, $lattice,  $new_object->rosetta_id, $translation_language->id);
        }

      }
    }


    $new_object->update_content_data($data);

    /*
     * adding of components is delayed until after alternate language objects creates,
     * because data trees need to be built before components go looking for rosetta ids
     */
    $new_object->add_components();

    return $new_object->id;

    }



    /*
     * Called only at object creation time, this function add automatic components to an object as children and also recurses
     * this functionality down the tree.
     */
    private function add_components()
    {


      // chain problem
      $containers = core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list', $this->objecttype->objecttypename));
      foreach ($containers as $c)
      {
        $arguments['title'] = $c->getAttribute('label');
        if ( ! ORM::Factory('objecttype', $c->getAttribute('name'))->loaded())
        {
          $this->objecttype->configure_element($c);
        }
        $this->add_object($c->getAttribute('name'), $arguments);
      }

      // look up any components and add them as well
      // configured components
      $components = core_lattice::config('objects', sprintf('//objectType[@name="%s"]/components/component', $this->objecttype->objecttypename));
      foreach ($components as $c)
      {
        $arguments = array();
        if ($label = $c->getAttribute('label'))
        {
          $arguments['title'] = $label;
        }
        if ($c->hasChildNodes())
        {
          foreach ($c->childNodes as $data)
          {
            $arguments[$data->tag_name] = $data->value;
          }
        }
        // We have a problem here
        // with data.xml populated components
        // the item has already been added by the add_object recursion, but gets added again here
        // what to do about this??/on

        $component_already_present = FALSE;
        if (isset($arguments['title']))
        {
          $check_for_preexisting_object = Graph::object()
            ->lattice_children_filter($this->id)
            ->join('contents', 'LEFT')->on('objects.id',  '=', 'contents.object_id')
            ->where('title', '=', $arguments['title'])
            ->find();
          if ($check_for_preexisting_object->loaded())
          {
            $component_already_present = TRUE;
          }
        }

        if ( ! $component_already_present)
        {
          $this->add_object($c->getAttribute('objectTypeName'), $arguments);
        }
      }


    }


    public function create_object($objectTypeName, $rosetta_id=NULL, $language_id=NULL)
    {
      if ($this->loaded())
      {
        throw new Kohana_Exception('Create cannot be called on a loaded object');
      } 
      if ( ! $objectTypeName)
      {
        throw new Kohana_Exception('Create cannot be called without a valid objectTypeName: '.$objectTypeName );
      }

      ! $rosetta_id ?  $translation_rosetta_id = Graph::new_rosetta() : $translation_rosetta_id = $rosetta_id;

      if ($language_id == NULL)
      {
        $this->language_id == NULL ? $language_id = Graph::default_language() : $language_id = $this->language_id;
      }

      $this->set_object_type($objectTypeName);
      $this->language_id = $language_id;
      $this->rosetta_id = $translation_rosetta_id;
      $this->slug = self::create_slug();

      // check for enabled publish/unpublish. 
      // if not enabled, insert as published
      $t_settings = core_lattice::config('objects', sprintf('//objectType[@name="%s"]', $this->objecttype->objecttypename));
      $t_settings = $t_settings->item(0);
      $this->published = 1;
      if ($t_settings)
      { // entry won't exist for Container objects
        if ($t_settings->getAttribute('allow_toggle_publish') == 'TRUE')
        {
          $this->published = 0;
        }
      }

      $this->dateadded = new Database_Expression('now()');
      $this->_save();

      $this->reset_role_access();
      return $this;

    }

    private function _create_object($objectTypeName, $rosetta_id = NULL, $language_id = NULL)
    {

      $new_object = Graph::object();
      $new_object->create_object($objectTypeName, $rosetta_id, $language_id);
      $new_object = Graph::object($new_object->id);
      return $new_object;

    }



    /*
     * Function: update_content_data($data)
     * Add defaults to content table 
     * This happens after the lattice point is set 
     * in case content tables are dependent on lattice point
     * */
    private function update_content_data($data)
    {

      // load defaults for this object type
      foreach ($this->objecttype->defaults() as $field => $default)
      {
        if ( ! isset($data[$field]))
        {
          $data[$field] = $default;
        }
      }


      if ( ! count($data))
      {
        return $this;
      }

      if (isset($data['published']) )
      {
        $this->published = $data['published'];
        unset($data['published']);
      }



      $lookup_templates = core_lattice::config('objects', '//objectType');
      $object_types = array();
      foreach ($lookup_templates as $t_config)
      {
        $object_types[] = $t_config->getAttribute('name');
      }
      // add submitted data to content table
      foreach ($data as $field => $value)
      {

        // need to switch here on type of field
        switch ($field)
        {
        case 'slug':
        case 'decoupleSlugTitle':
          $this->$field = $data[$field];
          continue(2);
        case 'title':
          $this->$field = $data[$field];
          continue(2);
        }

        $field_infoXPath = sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $this->objecttype->objecttypename, $field);
        $field_info = core_lattice::config('objects', $field_infoXPath)->item(0);
        if ( ! $field_info)
        {
          throw new Kohana_Exception("No field info found in objects.xml while adding new object, using Xpath :xpath", array(':xpath' => $field_infoXPath));
        }

        switch ($field_info->tagName)
        {
        case 'file':
        case 'image':
          // Get the file out of the FILES array

          if (isset($_FILES[$field]))
          {
            // Kohana::$log->add(Log::ERROR, 'Adding via post file');
            $file = Model_Object::save_http_post_file($this->id, $field, $_FILES[$field]);
          } else {
            $file = ORM::Factory('file');
            $file->filename = $value;
            $file->save();
            $this->$field = $file->id;
          }
          break;
        default:
          $this->$field = $data[$field];
          break;
        }
      }
      $this->_save();
      return $this;

    }



    /*
     * function add_element_object
     * An element object is an object that is part of another object's content. Examples
     * include links, files or images (in the coming full implementation) or other
     * user defined complex objects.
     * 
     */

    public function add_element_object($objectTypeName, $element_name, $data=array(), $rosetta_id = NULL, $language_id = NULL)
    {
      $new_object_type = ORM::Factory('objecttype', $objectTypeName);

      $new_object = $this->_create_object($objectTypeName, $rosetta_id, $language_id);


      // and set up the element relationship
      $element_relationship = ORM::Factory('objectelementrelationship');
      $element_relationship->object_id = $this->id;
      $element_relationship->elementobject_id = $new_object->id;
      $element_relationship->name = $element_name;
      $element_relationship->save();

      // Postpone dealing with content record until after lattice point is set
      // in case content table logic depends on lattice point.
      $new_object->insert_content_record();
      $new_object->update_content_data($data);

      /*
       * Set up any translated peer objects
     */
    if ( ! $rosetta_id)
    {
      $languages = Graph::languages();
      foreach ($languages as $translation_language)
      {

        if ($translation_language->id == $new_object->language_id)
        {
          continue;
        }

        if ($this->loaded())
        {
          $translated_parent = $this->get_translated_object($translation_language->id);

          $translated_parent->add_element_object($new_object->objecttype->objecttypename, $element_name, $data, $new_object->rosetta_id, $translation_language->id);
        } else {
          Graph::object()->add_element_object($new_object->objecttype->objecttypename, $element_name, $data, $new_object->rosetta_id, $translation_language->id);
        }

      }
    }

    /*
     * adding of components is delayed until after alternate language objects creates,
     * because data trees need to be built before components go looking for rosetta ids
     * element_objects will almost never have components, but we support it anyway
     */
    $new_object->add_components();

    return $new_object;

    }

    public function move($new_lattice_parent, $lattice='lattice', $old_lattice_parent=NULL)
    {
      $old_lattice_parent == NULL ? $old_lattice_parent = $this->get_lattice_parent() : $old_lattice_parent = Graph::object($old_lattice_parent);
      $new_lattice_parent = Graph::object($new_lattice_parent);
      $old_lattice_parent->remove_lattice_relationship('lattice',$this);
      $new_lattice_parent->add_lattice_relationship('lattice',$this);

    }

    public function add_lattice_relationship($lattice, $new_object_id)
    {

      if ( ! is_numeric($new_object_id))
      {
        $new_object_id = Graph::object($new_object_id);
      }

      if ($this->check_lattice_relationship($lattice, $new_object_id))
      {
        return;
      }

      if ( ! is_object($lattice))
      {
        $lattice = Graph::lattice($lattice);
      }

      $object_relationship = ORM::Factory('objectrelationship');
      $object_relationship->lattice_id = $lattice->id;
      $object_relationship->object_id = $this->id;
      $object_relationship->connectedobject_id = $new_object_id;
      $object_relationship->save();

      // calculate sort order
      $sort = DB::select('sortorder')->from('objectrelationships')
        ->where('lattice_id', '=', $lattice->id)
        ->where('object_id', '=', $this->id)
        ->order_by('sortorder','DESC')->limit(1)
        ->execute()->current();
      $object_relationship->sortorder = $sort['sortorder'] + 1;

      $object_relationship->save();
    }

    public function check_lattice_relationship($lattice, $new_object_id)
    {
      if ( ! is_object($lattice))
      {
        $lattice = Graph::lattice($lattice);
      }

      $object_relationship = ORM::Factory('objectrelationship')
        ->where('lattice_id', '=', $lattice->id)
        ->where('object_id', '=', $this->id)
        ->where('connectedobject_id', '=', $new_object_id)
        ->find(); 

      if ($object_relationship->loaded())
      {
        return TRUE;
      } else {
        return FALSE;
      }
    }

    public function remove_lattice_relationship($lattice, $remove_object_id)
    {
      if ( ! is_object($lattice))
      {
        $lattice = Graph::lattice($lattice);
      }

      $object_relationship = ORM::Factory('objectrelationship');
      $object_relationship->where('lattice_id', '=', $lattice->id);
      $object_relationship->where('object_id', '=', $this->id);
      $object_relationship->where('connectedobject_id', '=', $remove_object_id);
      $object_relationship->find();
      if ($object_relationship->loaded())
      {
        $object_relationship->delete();
      }

    }


    private function add_lattice_object($objectTypeName, $lattice = NULL, $rosetta_id = NULL, $language_id = NULL)
    {

      $new_object = $this->_create_object($objectTypeName, $rosetta_id, $language_id);

      // The objet has been built, now set it's lattice point
      $lattice = Graph::lattice();
      $this->add_lattice_relationship($lattice->id, $new_object->id);


      $new_object->insert_content_record();

      return $new_object;

    }

    public function clear_lattice_connections($lattice)
    {
      if ( ! is_object($lattice))
      {
        $lattice = Graph::lattice($lattice);
      }

      die('Not yet implemented');
    }

    public function get_translated_object($language_id)
    {
      $parent_rosetta_id = $this->rosetta_id;
      $translated_object = Graph::object()
        ->where('rosetta_id', '=', $this->rosetta_id)
        ->where('objects.language_id', '=', $language_id)
        ->find();
      if ( ! $translated_object->loaded())
      {
        throw new Kohana_Exception('No matching translated object for rosetta :rosetta and language :language',
          array(':rosetta'=>$this->rosetta_id,
          ':language'=>$language_id)
        );
      }
      return $translated_object;
    }



    public function set_object_type($object_type_class_or_name)
    {
      $object_type = NULL;
      if ( ! is_object($object_type_class_or_name))
      {

        $objectTypeName = $object_type_class_or_name;

        $object_type = ORM::Factory('objecttype', $objectTypeName);

        if ( ! $object_type->id)
        {


          // check objects.xml for configuration
          $x_path =  sprintf('//objectType[@name="%s"]', $objectTypeName);
          $x_path_list =  sprintf('//list[@name="%s"]', $objectTypeName);
          if ($object_type_config = core_lattice::config('objects', $x_path)->item(0))
          {
            // there's a config for this object_type
            // go ahead and configure it
            Graph::configure_object_type($objectTypeName);
            $object_type = ORM::Factory('objecttype', $objectTypeName);
          } elseif ($object_type_config = core_lattice::config('objects', $x_path_list)->item(0))
          { 
            Graph::configure_object_type($objectTypeName);
            $object_type = ORM::Factory('objecttype', $objectTypeName);
          } else {
            throw new Kohana_Exception('No config for object_type ' . $objectTypeName .' '.$x_path);
          }
        }
      } else {
        $object_type = $object_type_class_or_name;
      }
      $this->objecttype_id = $object_type->id;
      $this->__set('objecttype', $object_type);

      return $this; // chainable
    }

    public function add_role_access($role)
    {
      $role = ORM::Factory('role', array('name'=>$role));
      if ($this->has('roles', $role))
      {
        return;
      }
      $this->add('roles', $role );
    }

    public function remove_role_access($role)
    {
      $this->remove('roles', ORM::Factory('role', array('name'=>$role)));
    }

    public function check_role_access($role)
    {
      return $this->has('roles', ORM::Factory('role', array('name'=>$role)));
    }

    /*
     * Function: reset_role_access
     * Reset the access roles for this object to the defaults of it's objecttype
     */
    public function reset_role_access()
    {
      $roles = $this->roles->find_all();
      foreach ($roles as $role)
      {
        $this->remove_role_access($role->name);
      }

      $default_roles = $this->objecttype->initial_access_roles;
      if ($default_roles)
      {
        foreach ($default_roles as $role)
        {
          $this->add_role_access($role);
        }
      }

    }


    /*twg - access for individual users (client-restricted reel) */
    public function add_user_access($user)
    {
      $user = ORM::Factory('user', array('name'=>$user));
      if ($this->has('users', $user))
      {
        return;
      }
      $this->add('users', $user );
    }
    public function remove_user_access($user)
    {
      $this->remove('users', ORM::Factory('user', array('name'=>$user)));
    }

    public function check_user_access($user)
    {
      $users = ORM::Factory('user', array('username'=>$user));
      return $this->has('users', $users);
    }

    public function is_access_controlled()
    {
      // if there's a match for this in the obj/rel table, then it is access controlled
      $check = ORM::Factory('objectrelationship',$this->id);
      return $this->loaded();
    }

    /*
     * Function: reset_user_access
     clear all user access from object 
     */
    public function reset_user_access()
    {
      // delete from objects_users where object_id = $this->id
      $this->remove('users',ORM::Factory('object_user',array('object_id'=>$this->id)));
    }


    public function get_meta_objectTypeName($lattice)
    {
      $x_path = sprintf('//objectType[@name="%s"]/elements/associator[@lattice="%s"]', 
        $this->objecttype->objecttypename,
        $lattice);
      // echo $x_path;

      $config = core_lattice::config('objects', $x_path); 
      if ( ! $config->item(0))
      {
        return NULL;
      }
      return $config->item(0)->getAttribute('meta_objectTypeName');
    }
	
	
	public function offsetExists($offset)
	{
		return TRUE; // TODO: Fix this
	}
	public function offsetGet($offset) 
	{
		return $this->__get($offset);
	}
	public function offsetSet($offset, $value) 
	{
		return $this->__set($offset, $value);
	}
	public function offsetUnset ($offset) 
	{
		return TRUE; //can't unset in this class
	}
}
?>
