<?php

class Lattice_Model_Content extends ORM {

	/**
	 * get all object content and order by title
	 *
	 * @param   array order
	 * @return  object 
	 */
	public static function sort_content_by_title($order)
	{
		return ORM::factory('content')->where('object_id', 'IN', $order)->order_by('title', 'ASC')->find_all();
	}

}
