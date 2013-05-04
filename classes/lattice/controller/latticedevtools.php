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
			die('Only superuser can access builder tool');
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

		echo "$object->title &raquo; $object->slug";

		//return lattice model :: TODO this needs to return only lattices of the current object
		$lattices = Model_Lattice::get_all_lattices();
		
		echo "<hr />";
		
		foreach($lattices as $lattice)
		{
			echo "<h2> Lattice: $lattice->name </h2>";
			
			//get lattice children
			$children = $object->get_lattice_children($lattice->name);

			if(!is_object($children) )
			{
				throw new Kohana_Exception("Database error finding children");
			}

			if(count($children) == 0)
			{
				echo "There is no child for this lattice <br />";
			} 
			else 
			{
				foreach($children as $child)
				{
					echo "$child->title &raquo; <a href=\"".url::site('latticedevtools/graph/'.$child->slug)."\">$child->slug</a> <br /> ";
				}
			}
			echo "<hr />";
		}

		echo " --- end ---";

	}
}
