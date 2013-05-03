<?php defined('SYSPATH') or die('No direct access allowed.');


class Lattice_Controller_Latticedevtools extends Core_Controller_Lattice
{
	public function action_index()
	{
		$this->response->body('this is the output');
	}

	public function action_graph($id=NULL)
	{

		$object = NULL;
		if($id){
			$object = graph::object($id);
		} else {
			$object = graph::get_lattice_root();
		}

		if(!is_object($object) )
		{
			throw new Kohana_Exception("$id is not a proper graph member");
		}

		$object_type_name = $object->objecttype->objecttypename;


		$children = $object->get_lattice_children();

		// Don't need this, the current object is the 'parent' to display
		// $parent = $object->get_lattice_parent();

		echo "{$object->title} &raquo; {$object->slug} <br /> | <br />";
		if(!is_object($children) )
		{
			throw new Kohana_Exception("Database error finding children");
		}

		foreach($children as $child)
		{
			echo "{$child->title} &raquo; {$child->slug} <br /> | <br /> ";
		}

		echo " --- end ---";

	}
}
