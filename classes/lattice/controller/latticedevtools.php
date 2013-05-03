<?php defined('SYSPATH') or die('No direct access allowed.');


class Lattice_Controller_Latticedevtools extends Core_Controller_Lattice
{
	public function action_index()
	{
		$this->response->body('this is the output');
	}
	
	public function action_graph($id)
	{
		if(is_numeric($id))
		{
			//$object_id = $id;
		}
		else
		{
			//$slug = $id;
		}
		
		$object = graph::object($id);
		
		$object_type_name = $object->objecttype->objecttypename;
		

		$children = $object->get_lattice_children();
		
		$parent = $object->get_lattice_parent();
		
		
		echo "<center> {$parent->title} &raquo; {$parent->slug} <br /> | <br />";
		
		foreach($children as $child)
		{
			echo "{$child->title} &raquo; {$child->slug} <br /> | <br /> ";
		}
		
		echo "</center>";

	}
}
