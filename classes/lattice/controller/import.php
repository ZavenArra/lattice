<?php defined('SYSPATH') or die('No direct access allowed.');

class Lattice_Controller_Import extends Controller {

	private $new_object_ids = array();

	private $legacy = false;

	public function __construct()
	{
		if ( ! cms_util::check_role_access('superuser') AND PHP_SAPI != 'cli' )
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

	public function action_import($xml_file='data')
	{
		$mtime = microtime();
		$mtime = explode(' ', $mtime);
		$mtime = $mtime[1] + $mtime[0];
		$starttime = $mtime;

		unset($mtime);
		
		echo "Starting import - if you don't see the word Done at the end of the output, it means PHP killed the script before it completed";
		if (Kohana::config('lattice.live'))
		{
			die('import is disabled on sites marked live');
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
		$this->insert_data($xml_file, NULL, core_lattice::config($xml_file, 'nodes')->item(0) );

		Cms_Core::regenerate_images();

		$this->insert_relationships($xml_file);
		
		//unset xml file
		unset($xml_file);
		
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

	public function action_legacy($xml_file='data'){
		$this->legacy = true;
		$this->action_import($xml_file);
	}

	public function insert_relationships($xml_file)
	{	
		$lattices = core_lattice::config($xml_file, 'relationships/lattice');
		foreach ($lattices as $latticeDOM)
		{
			$this->add_relationships_for_lattice($xml_file, $latticeDOM);
		}
		$lattices = NULL;
		unset($lattices);
	}

	private function add_relationships_for_lattice($xml_file, $latticeDOM)
	{
		echo 'Inserting relationships for '.$latticeDOM->getAttribute('name');
		$lattice = Graph::lattice($latticeDOM->getAttribute('name'));
		$relationships = core_lattice::config($xml_file, 'relationship', $latticeDOM);
		
		foreach ($relationships as $relationship)
		{
			$this->add_relationship($lattice, $relationship);
		}
		$relationships = NULL;
		unset($relationships);
		$lattice = NULL;
		unset($lattice);
	}

	private function add_relationship($lattice, $relationship)
	{
		$parent_slug = $relationship->getAttribute('parent');  
		$child_slug = $relationship->getAttribute('child');  
		Graph::object($parent_slug)->add_lattice_relationship($lattice, $child_slug);
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
		}
		else 
		{
			$parent_object = Graph::get_root_node($this->root_node_object_type);
		}

		$xml_file = 'application/export/'.$xml_file.'/'.$xml_file.'.xml';

		$this->insert_data($xml_file, $parent_object->id, core_lattice::config($xml_file, 'nodes')->item(0) ); 

		$this->insert_relationships($xml_file);

		Cms_Core::generate_new_images($this->new_object_ids);
	}



	public function insert_data($xml_file, $parent_id = NULL, $context=NULL)
	{
		if ($parent_id == NULL)
		{
			$parent_object = Graph::get_root_node($this->root_node_object_type);
		} 
		else 
		{
			$parent_object = Graph::object($parent_id);
		}
		$items = core_lattice::config($xml_file, 'item', $context);
		$this->add_items_to_parent($xml_file, $parent_object, $items);

		$parent_object = NULL;
		unset($parent_object);
		$items = NULL;
		unset($items);
	}

	public function add_items_to_parent($xml_file, $parent_object, $items)
	{
		foreach ($items as $item)
		{
			$this->add_item_to_parent($xml_file, $parent_object, $item);
		}
	}

	private function check_for_component($parent_object, $title)
	{
		$preexisting_object = Graph::object()
							  ->lattice_children_filter($parent_object->id)
							  ->join('contents', 'LEFT')->on('objects.id',  '=', 'contents.object_id')
							  ->where('title', '=', $title)
							  ->find();
		$component = FALSE;
		if ($preexisting_object->loaded())
		{
			$component = $preexisting_object;
		}
		return $component;
	}	

	private function load_data_for_content($xml_file, $content, $item,  &$data, &$clusters_date)
	{

		$field = $content->getAttribute('name');

		switch ($field)
		{
			case 'title':
			case 'published':
				$data[$field] = $content->nodeValue;
				break;
			case 'slug':
				$data[$field] = $content->nodeValue;
				$data['decoupleSlugTitle'] = 1;
				break;
		}
		
		if(in_array($field, array('title', 'published', 'slug')))
		{
			// We're done if it's these fields
			return;
		}

		// need to look up field and switch on field type 
		$field_info = core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $item->getAttribute('objectTypeName'), $content->getAttribute('name')))->item(0);
		if ( ! $field_info)
		{
			throw new Kohana_Exception("Bad field in data/objects! \n" . sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $item->getAttribute('objectTypeName'), $content->getAttribute('name')));
		}

		// if an element is actually an object, prepare it for insert/update
		if (core_lattice::config('objects', sprintf('//objectType[@name="%s"]', $field_info->tagName))->length > 0)
		{
			// we have a cluster..               
			$cluster_data = array();
			foreach (core_lattice::config($xml_file, 'field', $content) as $cluster_field)
			{
				$cluster_data[$cluster_field->getAttribute('name')] = $cluster_field->nodeValue;
			}

			$clusters_data[$field] = $cluster_data;
			// have to wait until object is inserted to respect translations
			return;
		}

		// special setup based on field type
		switch ($field_info->tagName)
		{
			case 'file':
			case 'image':
				$path_parts = pathinfo($content->nodeValue);
				$savename = Model_Object::make_file_save_name($path_parts['basename']);
				if (file_exists($content->nodeValue))
				{
					copy(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . $content->nodeValue, Graph::mediapath($savename) . $savename);
					$data[$field] = $savename;
				}
				else 
				{
					if ($content->nodeValue)
					{
						//throw new Kohana_Exception( "File does not exist {$content->nodeValue} ");
						echo "File does not exist {$content->nodeValue} ";
					}	
				}
				break;
			default:
				$data[$field] = $content->nodeValue;
				break;
		}

      // $data array as modified by reference
	}


	public function add_item_to_parent($xml_file, $parent_object, $item)
	{
		if ( ! $item->getAttribute('objectTypeName'))
		{
		  throw new Kohana_Exception("No objecttypename specified for Item " . $item->tagName);
		}

		$object = Graph::instance();
		$object_type = ORM::Factory('objecttype', $item->getAttribute('objectTypeName'));

		$data = array();
		$clusters_data = array();
		$fields = core_lattice::config($xml_file, 'field', $item );
		foreach ($fields as $content)
		{
			$this->load_data_for_content($xml_file, $content, $item, $data, $clusters_data);
		}

		// now we check for a title collision
		// if there is a title collision, we assume that this is a component
		// already added at the next level up, in this case we just
		// update the objects data
		$component = FALSE;
		if (isset($data['title']) AND $data['title'])
		{
			$component = $this->check_for_component($parent_object, $data['title']);
		}

    // check for pre-existing object as list container, another kind of potential collision
		$list_container = $this->check_for_list_container($parent_object, $item);
		if($list_container)
		{
			$component = $list_container;
		}

		// If we found an existing object, update that one, otherwise go ahead and instert a new object
		if ($component)
		{
			// echo 'Updating Object '.$component->objecttype->objecttypename."\n";
			$component->update_with_array($data);
			$object_id = $component->id;
		} 
		else 
		{
			// actually add the object
			// echo 'Adding Object '.$item->getAttribute('objectTypeName')."\n";
			$object_id = $parent_object->add_object($item->getAttribute('objectTypeName'), $data);

			if($object_id != NULL) 
			{
				$this->new_object_ids[] = $object_id;
			}
		}

		// and now update with element_objects;
		if (count($clusters_data))
		{
			$object = Graph::object($object_id);
			// echo "Updating clusters\n";
			$object->update_with_array($clusters_data);
		}

		if($this->legacy){
			// do recursive if it has children
			if (core_lattice::config($xml_file, 'item', $item)->length )
			{
				$this->insert_data($xml_file, $object_id,  $item);
			}

			// and lastly, insert data for lists
			$lists = core_lattice::config($xml_file, 'list', $item);
			foreach ($lists as $list)
			{
				// find the container
				$container = Graph::object()
					->lattice_children_filter($object_id)
					->object_type_filter($list->getAttribute('name'))
					->find();
				// jump down a level to add object
				$this->insert_data($xml_file, $container->id, $list);
			}

		}
    unset($lists);

  }

	private function check_for_list_container($parent_object, $item)
	{
		$component = FALSE;
		foreach (core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list', $parent_object->objecttype->objecttypename)) as $list_container_type)
		{
			$preexisting_object = Graph::object()
								->lattice_children_filter($parent_object->id)
								->object_type_filter($list_container_type->getAttribute('name'))
								->find();
			if ($preexisting_object->loaded() AND $preexisting_object->objecttype->objecttypename == $item->getAttribute('objectTypeName') )
			{
				$component = $preexisting_object;
				break;
			}
		}
		//If there somehow were multiple conflicts, this will just return the first one
		//Multiple conflicts would mean a very poorly designer object architecture in objects.xml
		return $component;
	}

	public function action_regenerate_images()
	{
		try 
		{
			Cms_Core::regenerate_images();
		} 
		catch(Exception $e)
		{
			print_r($e->get_message() . $e->get_trace());
		}
		echo 'Done';
		flush();
		ob_flush();
	}

	//Legacy, for xml exports that contain hierarchical structure
  
	public function legacy_destroy($dir)
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

	public function action_legacy_import($xml_file='data')
	{
		$mtime = microtime();
		$mtime = explode(' ', $mtime);
		$mtime = $mtime[1] + $mtime[0];
		$starttime = $mtime;

		unset($mtime);
		
		echo "Starting import - if you don't see the word Done at the end of the output, it means PHP killed the script before it completed";
		if (Kohana::config('lattice.live'))
		{
			die('import is disabled on sites marked live');
		}

		// clean out media dir
		$this->legacy_destroy('application/media/');

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
		$this->legacy_insert_data($xml_file, NULL, core_lattice::config($xml_file, 'nodes')->item(0) );

		Cms_Core::regenerate_images();

		$this->legacy_insert_relationships($xml_file);
		
		//unset xml file
		unset($xml_file);
		
		// and run frontend
		echo "\n Regenerating Frontend";
		$this->legacy_action_frontend();

		$memory_use_following_action = memory_get_usage(TRUE);

		$mtime = microtime();
		$mtime = explode(" ", $mtime);
		$mtime = $mtime[1] + $mtime[0];
		$endtime = $mtime;
		$totaltime = ($endtime - $starttime);
		echo '<! -- initialize_site took ' .$totaltime. ' seconds, and completed with memory usage of '.$memory_use_following_action;
		echo 'Initialize Site Complete';
	}

	public function legacy_insert_relationships($xml_file)
	{	
		$lattices = core_lattice::config($xml_file, 'relationships/lattice');
		foreach ($lattices as $latticeDOM)
		{
			$this->legacy_add_relationships_for_lattice($xml_file, $latticeDOM);
		}
		$lattices = NULL;
		unset($lattices);
	}

	private function legacy_add_relationships_for_lattice($xml_file, $latticeDOM)
	{
		echo 'Inserting relationships for '.$latticeDOM->getAttribute('name');
		$lattice = Graph::lattice($latticeDOM->getAttribute('name'));
		$relationships = core_lattice::config($xml_file, 'relationship', $latticeDOM);
		
		foreach ($relationships as $relationship)
		{
			$this->legacy_add_relationship($lattice, $relationship);
		}
		$relationships = NULL;
		unset($relationships);
		$lattice = NULL;
		unset($lattice);
	}

	private function legacy_add_relationship($lattice, $relationship)
	{
		$parent_slug = $relationship->getAttribute('parent');  
		$child_slug = $relationship->getAttribute('child');  
		Graph::object($parent_slug)->add_lattice_relationship($lattice, $child_slug);
	}

	public function legacy_action_frontend()
	{
		$frontend = new Builder_Frontend();
		$frontend->index();
	}

	public function legacy_action_add_data($xml_file, $secondary_root_node_object_type=NULL)
	{
		if ($secondary_root_node_object_type AND ! $parent_id = Graph::get_root_node($secondary_root_node_object_type))
		{
		  Graph::configure_object_type($secondary_root_node_object_type);
		  Graph::add_root_node($secondary_root_node_object_type);
		  $parent_object = Graph::get_root_node($secondary_root_node_object_type);
		}
		else 
		{
			$parent_object = Graph::get_root_node($this->root_node_object_type);
		}

		$xml_file = 'application/export/'.$xml_file.'/'.$xml_file.'.xml';

		$this->legacy_insert_data($xml_file, $parent_object->id, core_lattice::config($xml_file, 'nodes')->item(0) ); 

		$this->legacy_insert_relationships($xml_file);

		Cms_Core::generate_new_images($this->new_object_ids);
	}



	public function legacy_insert_data($xml_file, $parent_id = NULL, $context=NULL)
	{
		if ($parent_id == NULL)
		{
			$parent_object = Graph::get_root_node($this->root_node_object_type);
		} 
		else 
		{
			$parent_object = Graph::object($parent_id);
		}
		$items = core_lattice::config($xml_file, 'item', $context);
		$this->legacy_add_items_to_parent($xml_file, $parent_object, $items);

		$parent_object = NULL;
		unset($parent_object);
		$items = NULL;
		unset($items);
	}

	public function legacy_add_items_to_parent($xml_file, $parent_object, $items)
	{
		foreach ($items as $item)
		{
			$this->legacy_add_item_to_parent($xml_file, $parent_object, $item);
		}
	}

	private function legacy_check_for_component($parent_object, $title)
	{
		$preexisting_object = Graph::object()
							  ->lattice_children_filter($parent_object->id)
							  ->join('contents', 'LEFT')->on('objects.id',  '=', 'contents.object_id')
							  ->where('title', '=', $title)
							  ->find();
		if ($preexisting_object->loaded())
		{
			$component = $preexisting_object;
		}
	}	

	private function legacy_load_data_for_content($xml_file, $content, $item,  &$data, &$clusters_date)
	{

		$field = $content->getAttribute('name');

		switch ($field)
		{
			case 'title':
			case 'published':
				$data[$field] = $content->nodeValue;
				break;
			case 'slug':
				$data[$field] = $content->nodeValue;
				$data['decoupleSlugTitle'] = 1;
				break;
		}
		
		if(in_array($field, array('title', 'published', 'slug')))
		{
			// We're done if it's these fields
			return;
		}

		// need to look up field and switch on field type 
		$field_info = core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $item->getAttribute('objectTypeName'), $content->getAttribute('name')))->item(0);
		if ( ! $field_info)
		{
			throw new Kohana_Exception("Bad field in data/objects! \n" . sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $item->getAttribute('objectTypeName'), $content->getAttribute('name')));
		}

		// if an element is actually an object, prepare it for insert/update
		if (core_lattice::config('objects', sprintf('//objectType[@name="%s"]', $field_info->tagName))->length > 0)
		{
			// we have a cluster..               
			$cluster_data = array();
			foreach (core_lattice::config($xml_file, 'field', $content) as $cluster_field)
			{
				$cluster_data[$cluster_field->getAttribute('name')] = $cluster_field->nodeValue;
			}

			$clusters_data[$field] = $cluster_data;
			// have to wait until object is inserted to respect translations
			return;
		}

		// special setup based on field type
		switch ($field_info->tagName)
		{
			case 'file':
			case 'image':
				$path_parts = pathinfo($content->nodeValue);
				$savename = Model_Object::make_file_save_name($path_parts['basename']);
				if (file_exists($content->nodeValue))
				{
					copy(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . $content->nodeValue, Graph::mediapath($savename) . $savename);
					$data[$field] = $savename;
				}
				else 
				{
					if ($content->nodeValue)
					{
						//throw new Kohana_Exception( "File does not exist {$content->nodeValue} ");
						echo "File does not exist {$content->nodeValue} ";
					}	
				}
				break;
			default:
				$data[$field] = $content->nodeValue;
				break;
		}

      // $data array as modified by reference
	}


	public function legacy_add_item_to_parent($xml_file, $parent_object, $item)
	{
		if ( ! $item->getAttribute('objectTypeName'))
		{
		  throw new Kohana_Exception("No objecttypename specified for Item " . $item->tagName);
		}

		$object = Graph::instance();
		$object_type = ORM::Factory('objecttype', $item->getAttribute('objectTypeName'));

		$data = array();
		$clusters_data = array();
		$fields = core_lattice::config($xml_file, 'field', $item );
		foreach ($fields as $content)
		{
			$this->legacy_load_data_for_content($xml_file, $content, $item, $data, $clusters_data);
		}

		// now we check for a title collision
		// if there is a title collision, we assume that this is a component
		// already added at the next level up, in this case we just
		// update the objects data
		$component = FALSE;
		if (isset($data['title']) AND $data['title'])
		{
			$component = $this->legacy_check_for_component($parent_object, $data['title']);
		}

    // check for pre-existing object as list container, another kind of potential collision
		$list_container = $this->legacy_check_for_list_container($parent_object, $item);
		if($list_container)
		{
			$component = $list_container;
		}

		// If we found an existing object, update that one, otherwise go ahead and instert a new object
		if ($component)
		{
			// echo 'Updating Object '.$component->objecttype->objecttypename."\n";
			$component->update_with_array($data);
			$object_id = $component->id;
		} 
		else 
		{
			// actually add the object
			// echo 'Adding Object '.$item->getAttribute('objectTypeName')."\n";
			$object_id = $parent_object->add_object($item->getAttribute('objectTypeName'), $data);

			if($object_id != NULL) 
			{
				$this->new_object_ids[] = $object_id;
			}
		}

		// and now update with element_objects;
		if (count($clusters_data))
		{
			$object = Graph::object($object_id);
			// echo "Updating clusters\n";
			$object->update_with_array($clusters_data);
		}

		// do recursive if it has children
		if (core_lattice::config($xml_file, 'item', $item)->length )
		{
			$this->legacy_insert_data($xml_file, $object_id,  $item);
		}

		// and lastly, insert data for lists
		$lists = core_lattice::config($xml_file, 'list', $item);
		foreach ($lists as $list)
		{
			// find the container
			$container = Graph::object()
						->lattice_children_filter($object_id)
						->object_type_filter($list->getAttribute('name'))
						->find();
			// jump down a level to add object
			$this->legacy_insert_data($xml_file, $container->id, $list);
		}
    unset($lists);

  }

	private function legacy_check_for_list_container($parent_object, $item)
	{
		$component = FALSE;
		foreach (core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list', $parent_object->objecttype->objecttypename)) as $list_container_type)
		{
			$preexisting_object = Graph::object()
								->lattice_children_filter($parent_object->id)
								->object_type_filter($list_container_type->getAttribute('name'))
								->find();
			if ($preexisting_object->loaded() AND $preexisting_object->objecttype->objecttypename == $item->getAttribute('objectTypeName') )
			{
				$component = $preexisting_object;
				break;
			}
		}
		//If there somehow were multiple conflicts, this will just return the first one
		//Multiple conflicts would mean a very poorly designer object architecture in objects.xml
		return $component;
	}

	public function legacy_action_regenerate_images()
	{
		try 
		{
			Cms_Core::regenerate_images();
		} 
		catch(Exception $e)
		{
			print_r($e->get_message() . $e->get_trace());
		}
		echo 'Done';
		flush();
		ob_flush();
	}
  
}
