<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Helps dev browse through objects without passing via the CMS
 *
 * @package    Lattice
 * @category   Devtools
 * @author     quincykwende
 * 
 */

class Lattice_Controller_Latticedevtools extends Core_Controller_Lattice
{

	public function __construct()
	{
		if ( ! cms_util::check_role_access('superuser') AND PHP_SAPI != 'cli' )
		{
			die('Only superuser can access Latticedevtools');
		}
	}

	public function action_index()
	{
		$this->action_graph();
	}

	/**
	 * Browser through objects
	 *
	 * @param   int/string id
	 * @return  null
	 */
	public function action_graph($id=NULL)
	{
		$object = NULL;

		if($id)
		{
			$object = graph::object($id);
		} 
		else 
		{
			$object = graph::get_lattice_root();
		}

		//throw exception if object not instantiated
		if(!is_object($object) )
		{
			throw new Kohana_Exception("$id is not a proper graph member");
		}

		$object_type_name = $object->objecttype->objecttypename;

		echo "Object Title: $object->title | Object Slug: $object->slug <br />";
		echo "Object Type: {$object->objecttype->objecttypename} <br />";

		// Clusters
		$elementRelationships = ORM::Factory('objectelementrelationship')->where('object_id', '=', $object->id)->find_all();
		
		foreach($elementRelationships as $cluster)
		{
			echo "Cluster: $cluster->name &raquo; <a href=\"".url::site('latticedevtools/graph/'.$cluster->elementobject_id)."\">$cluster->elementobject_id</a> <br /> "; 
		}

		// Latices
		//return lattice model :: TODO this needs to return only lattices of the current object
		$lattices = Model_Lattice::get_all_lattices();

		echo "<hr />";

		foreach($lattices as $lattice)
		{
			//get lattice children
			$children = $object->get_lattice_descendents($lattice->name);

			if(!is_object($children) )
			{
				throw new Kohana_Exception("Database error finding children");
			}

			if(count($children) != 0) 
			{
				
				echo "<h2> Lattice: $lattice->name </h2>";
				
				foreach($children as $child)
				{
					echo "$child->title &raquo; <a href=\"".url::site('latticedevtools/graph/'.$child->slug)."\">$child->slug</a> <br /> ";
				}
				
				echo "<hr />";
			}
			
		}

		echo " --- end ---";

	}

	public function action_sort()
	{
		$order = array(1, 5, 6);

		$contents = Model_Content::sort_content_by_title($order);

		$or = array();
		foreach($contents as $content):
			array_push($or, $content->object_id);
		endforeach;

		var_dump($or);

	}

	public function action_date()
	{
		$order = array(1, 5, 6);

		$objects = ORM::factory('object')->where('id', 'IN', $order)->order_by('dateadded', 'DESC')->find_all();

		$or = array();
		foreach($objects as $object):
			array_push($or, $object->id);
		endforeach;

		var_dump($or);

	}
}
