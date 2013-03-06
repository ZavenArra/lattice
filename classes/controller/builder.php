<?php

class Controller_Builder extends Controller {

  private $new_object_ids = array();

  public function __construct()
  {

    if ( ! latticeutil::check_role_access('superuser') AND PHP_SAPI != 'cli' )
    {
      die('Only superuser can access builder tool');
    }

    $this->root_node_object_type = Kohana::config('cms.graph_root_node');

  }

  public function destroy($dir)
  {
    $mydir = opendir($dir);
    while(FALSE !== ($file = readdir($mydir)))
    {
      if ($file != "." AND $file != "..")
      {
        //    chmod($dir.$file, 0777);
        if (is_dir($dir.$file))
        {
          chdir('.');
          destroy($dir.$file.'/');
          rmdir($dir.$file) or DIE("couldn't delete $dir$file<br />");
        }
        else
          unlink($dir.$file) or DIE("couldn't delete $dir$file<br />");
      }
    }
    closedir($mydir);
  }

  public function action_initialize_site($xml_file='data')
  {

    $mtime = microtime();
    $mtime = explode(' ', $mtime);
    $mtime = $mtime[1] + $mtime[0];
    $starttime = $mtime;


    if (Kohana::config('lattice.live'))
    {
      die('builder/initialize_site is disabled on sites marked live');
    }

    // clean out media dir
    $this->destroy('application/media/');

    $db = Database::instance();
    $db->query(Database::DELETE, 'delete from objects');
    $db->query(Database::UPDATE, 'alter table objects AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from contents');
    $db->query(Database::UPDATE, 'alter table contents AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from objecttypes');
    $db->query(Database::UPDATE, 'alter table objecttypes AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from objectmaps');
    $db->query(Database::UPDATE, 'alter table objectmaps AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from objectrelationships');
    $db->query(Database::UPDATE, 'alter table objectrelationships AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from objectelementrelationships');
    $db->query(Database::UPDATE, 'alter table objectelementrelationships AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from rosettas');
    $db->query(Database::UPDATE, 'alter table rosettas AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from tags');
    $db->query(Database::UPDATE, 'alter table tags AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from objects_tags');
    $db->query(Database::UPDATE, 'alter table objects_tags AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from tags_tagbuckets');
    $db->query(Database::UPDATE, 'alter table tags_tagbuckets AUTO_INCREMENT = 1');
    flush();
    ob_flush();

    // immediately reinitialize the graph
    Graph::configure_object_type($this->root_node_object_type, TRUE);
    Graph::add_root_node($this->root_node_object_type);

    if ($xml_file != 'data')
    {
      // then we are loading an export
      $xml_file = 'application/export/'.$xml_file.'/'.$xml_file.'.xml';
    }
    echo "\n_inserting Data\n";
    $this->insert_data($xml_file, NULL, lattice::config($xml_file, 'nodes')->item(0) );

    latticecms::regenerate_images();

    $this->insert_relationships($xml_file);

    // and run frontend
    echo "\n Regenerating Frontend";
    $this->action_frontend();


    $memory_use_following_action = memory_get_usage(TRUE);

    $mtime = microtime();
    $mtime = explode(" ", $mtime);
    $mtime = $mtime[1] + $mtime[0];
    $endtime = $mtime;
    $totaltime = ($endtime - $starttime);
    echo '<! -- initialize_site took ' .$totaltime. ' seconds, and completed with memory usage of '.$memory_use_following_action;
    echo 'Initialize Site Complete';

  }

  public function insert_relationships($xml_file)
  {

    $lattices = lattice::config($xml_file, 'relationships/lattice');
    foreach ($lattices as $latticeDOM)
    {
      $lattice = Graph::lattice($latticeDOM->get_attribute('name'));
      $relationships = lattice::config($xml_file, 'relationship', $latticeDOM);
      foreach ($relationships as $relationship)
      {
        $parent_slug = $relationship->get_attribute('parent');  
        $child_slug = $relationship->get_attribute('child');  
        // echo 'Adding lattice relationship';
        $parent = Graph::object($parent_slug)->add_lattice_relationship($lattice, $child_slug);
      }
      unset($relationships);
    }
    unset($lattices);
  }

  public function action_frontend()
  {
    $frontend = new Builder_Frontend();
    $frontend->index();

  }

  public function action_add_data($xml_file, $secondary_root_node_object_type=NULL)
  {

    if ($secondary_root_node_object_type AND ! $parent_id = Graph::get_root_node($secondary_root_node_object_type))
    {
      Graph::configure_object_type($secondary_root_node_object_type);
      Graph::add_root_node($secondary_root_node_object_type);
      $parent_object = Graph::get_root_node($secondary_root_node_object_type);
    } else {
      $parent_object = Graph::get_root_node($this->root_node_object_type);
    }

    $xml_file = 'application/export/'.$xml_file.'/'.$xml_file.'.xml';

    $this->insert_data($xml_file, $parent_object->id, lattice::config($xml_file, 'nodes')->item(0) ); 

    $this->insert_relationships($xml_file);

    latticecms::generate_new_images($this->new_object_ids);
  }



  public function insert_data($xml_file, $parent_id = NULL, $context=NULL)
  {
    if ($parent_id == NULL)
    {
      $parent_object = Graph::get_root_node($this->root_node_object_type);
    } else {
      $parent_object = Graph::object($parent_id);
    }


    $items = lattice::config($xml_file, 'item', $context);
    foreach ($items as $item)
    {

      if ( ! $item->get_attribute('object_type_name'))
      {
        // echo $item->tag_name;
        throw new Kohana_Exception("No objecttypename specified for Item " . $item->tag_name);
      }


      $object = Graph::instance();
      $object_type = ORM::Factory('objecttype', $item->get_attribute('object_type_name'));

      $data = array();
      $clusters_data = array();
      $fields = lattice::config($xml_file, 'field', $item );
      foreach ($fields as $content)
      {
        $field = $content->get_attribute('name');

        switch ($field)
        {
        case 'title':
        case 'published':
          $data[$field] = $content->node_value;
          continue(2);
        case 'slug':
          $data[$field] = $content->node_value;
          $data['decouple_slug_title'] = 1;
          continue(2);
        }

        // need to look up field and switch on field type 
        $field_info = lattice::config('objects', sprintf('// object_type[@name="%s"]/elements/*[@name="%s"]', $item->get_attribute('object_type_name'), $content->get_attribute('name')))->item(0);
        if ( ! $field_info)
        {
          throw new Kohana_Exception("Bad field in data/objects! \n" . sprintf('// object_type[@name="%s"]/elements/*[@name="%s"]', $item->get_attribute('object_type_name'), $content->get_attribute('name')));
        }

        // if an element is actually an object, prepare it for insert/update
        if (lattice::config('objects', sprintf('// object_type[@name="%s"]', $field_info->tag_name))->length > 0)
        {
          // we have a cluster..               
          $cluster_data = array();
          foreach (lattice::config($xml_file, 'field', $content) as $cluster_field)
          {
            $cluster_data[$cluster_field->get_attribute('name')] = $cluster_field->node_value;
          }

          $clusters_data[$field] = $cluster_data;
          // have to wait until object is inserted to respect translations
          // echo 'continuing';
          continue;
        }


        // special setup based on field type
        switch ($field_info->tag_name)
        {
        case 'file':
        case 'image':
          $path_parts = pathinfo($content->node_value);
          $savename = Model_Object::make_file_save_name($path_parts['basename']);
          if (file_exists($content->node_value))
          {
            copy(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . $content->node_value, Graph::mediapath($savename) . $savename);
            $data[$field] = $savename;
          } else {
            if ($content->node_value)
            {
              throw new Kohana_Exception( "File does not exist {$content->node_value} ");
            }
          }
          break;
        default:
          $data[$field] = $content->node_value;
          break;
        }

      }
      // now we check for a title collision
      // if there is a title collision, we assume that this is a component
      // already added at the next level up, in this case we just
      // update the objects data
      $component = FALSE;
      if (isset($data['title']) AND $data['title'])
      {
        $preexisting_object = Graph::object()
          ->lattice_children_filter($parent_object->id)
          ->join('contents', 'LEFT')->on('objects.id',  '=', 'contents.object_id')
          ->where('title', '=', $data['title'])
          ->find();
        if ($preexisting_object->loaded())
        {
          $component = $preexisting_object;
          // echo 'Found prexisting component: '.$preexisting_object->objecttype->objecttypename;
        }
      }

      // check for pre-existing object as list container
      // echo sprintf('//object_type[@name="%s"]/elements/list', $parent_object->objecttype->objecttypename);
      foreach (lattice::config('objects', sprintf('// object_type[@name="%s"]/elements/list', $parent_object->objecttype->objecttypename)) as $list_container_type)
      {
        $preexisting_object = Graph::object()
          ->lattice_children_filter($parent_object->id)
          ->object_type_filter($list_container_type->get_attribute('name'))
          ->find();
        if ($preexisting_object->loaded() AND $preexisting_object->objecttype->objecttypename == $item->get_attribute('object_type_name') )
        {
          // echo 'Found prexisting list container: '.$preexisting_object->objecttype->objecttypename .' '.$item->get_attribute('object_type_name');
          $component = $preexisting_object;
        }
      }


      if ($component)
      {
        // echo 'Updating Object '.$component->objecttype->objecttypename."\n";
        // print_r($data);
        $component->update_with_array($data);
        $object_id = $component->id;
      } else {
        // actually add the object
        // echo 'Adding Object '.$item->get_attribute('object_type_name')."\n";
        // print_r($data);
        $object_id = $parent_object->add_object($item->get_attribute('object_type_name'), $data);
        $this->new_object_ids[] = $object_id;
      }

      // and now update with element_objects;
      if (count($clusters_data))
      {
        $object = Graph::object($object_id);
        // echo "Updating clusters\n";
        $object->update_with_array($clusters_data);
      }


      // do recursive if it has children
      if (lattice::config($xml_file, 'item', $item)->length )
      {
        $this->insert_data($xml_file, $object_id,  $item);
      }

      $lists = lattice::config($xml_file, 'list', $item);
      foreach ($lists as $list)
      {
        // find the container
        $container = Graph::object()
          ->lattice_children_filter($object_id)
          ->object_type_filter($list->get_attribute('name'))
          ->find();

        // jump down a level to add object
        $this->insert_data($xml_file, $container->id, $list);
      }
      unset($lists);

    }
    unset($items);

  }


  public function action_regenerate_images()
  {
    try {
      latticecms::regenerate_images();
    } catch(Exception $e)
    {
      print_r($e->get_message() . $e->get_trace());
    }
    echo 'Done';
    flush();
    ob_flush();
  }

}
