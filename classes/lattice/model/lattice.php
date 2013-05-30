<?php

/**
 * Lattice Model
 *
 *
 * @package    Lattice
 * @category   Model
 * @author     deepwinter1
 * 
 */


class Lattice_Model_Lattice extends ORM {

	public function get_relationships()
	{
		if ( ! $this->loaded())
		{
			throw new Kohana_Exception('Model is not loaded');
		}

		$relationships = ORM::Factory('objectrelationship')->where('lattice_id', '=', $this->id)->order_by('sortorder', 'DESC')->find_all();

		return $relationships;
	}
  
	/**
	 * Return all lattice
	 *
	 * @return  object
	 */
	public static function get_all_lattices()
	{
		return ORM::factory('lattice')->find_all();
	}
    
}

