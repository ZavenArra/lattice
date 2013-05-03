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

    echo "{$object->title} &raquo; {$object->slug} <br /> | <br />";

    $lattices = array('lattice', 'artist', 'whatever'); // TODO this needs to query database for all lattices
                                                        //  probably add an 'all_lattices' method to object or lattice model 

    foreach($lattices as $lattice){
      echo "Lattice: $lattice <br /><br />";

      $children = $object->get_lattice_children($lattice);

      if(!is_object($children) )
      {
        throw new Kohana_Exception("Database error finding children");
      }

      if(count($children) == 0){
        // echo something about empty children ?
      } else 
        foreach($children as $child)
        {
          echo "{$child->title} &raquo; <a href=\"".url::site('latticedevtools/graph/'.$child->slug)."\">{$child->slug}</a> <br /> | <br /> ";
        }
    }

		echo " --- end ---";

	}
}
