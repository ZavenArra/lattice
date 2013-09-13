<?php

Class Lattice_Controller_Associator extends Core_Controller_Lattice {

  public function action_associate($parent_id, $object_id, $lattice)
  {
    Graph::object($parent_id)->add_lattice_relationship($lattice, $object_id);
  }

  public function action_dissociate($parent_id, $object_id, $lattice)
  {
    Graph::object($parent_id)->remove_lattice_relationship($lattice, $object_id);
  }

  public function action_get_page($parent_id, $name, $page_num=0, $word="")
  {

$this->action_filter_pool_by_word($parend_id, $name, $page_num, $word);

  }

  public function action_filter_pool_by_word($parent_id, $name, $page_num=0,$word="")
  {
    $parent = Graph::object($parent_id);

    if ( ! $parent->loaded())
    {
      throw new Kohana_Exception('Parent object not found, invalid parent_id?');
    }

    $element = Cms_Core::get_element_dom_node(Graph::object($parent_id), $name);
    $filters = CMS_Associator::get_filters_from_dom_node($element);
    $modified_filters = array();
    foreach ($filters as $filter)
    {
      $filter['match'] = $word;
      $filter['match_fields']  = 'title';

			// Setting page for every filter is actually wrong, and reflects a problem in the filter combination logic
			$filter['page'] = $page_num;

      $modified_filters[] = $filter;
    }

    $a = new CMS_Associator($parent_id, $element->getAttribute('lattice'), $modified_filters);
		// TODO: it may be better to paginate right here
    $this->response->body($a->render_pool_items());
    $this->response->data(array("total_pages"=>$a->num_pages));

  }

	public function action_autocomplete_options($parend_id, $name, $word) {
		// no default implementation at this time
		$this->response->data(array("search_keys" => array()));
	}


  public function action_filter_pool_by_tag($parent_id, $name, $tag)
  {
    $parent = Graph::object($parent_id);
    if ( ! $parent->loaded())
    {
      throw new Kohana_Exception('Parent object not found, invalid parent_id?');
    }

  }


}
