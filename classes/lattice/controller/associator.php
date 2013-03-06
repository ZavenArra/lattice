<?php

Class Lattice_Controller_Associator extends Controller_Lattice {

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
    $parent = Graph::object($parent_id);
    if ( ! $parent->loaded())
    {
      throw new Kohana_Exception('Parent object not found, invalid parent_id?');
    }

    $element = latticecms::get_element_dom_node(Graph::object($parent_id), $name);
    $filters = Associator::get_filters_from_dom_node($element);
    $modified_filters = array();
    foreach ($filters as $filter)
    {
      $filter['match'] = $word;
      $filter['match_fields']  = 'title';
      $modified_filters[] = $filter;
    }
    $a = new Associator($parent_id, $element->get_attribute('lattice'), $modified_filters);
    $this->response->body($a->render_pool_items());
  }

  public function action_filter_pool_by_word($parent_id, $name, $page_num=0,$word="")
  {

    Kohana::$log->add( Kohana_Log::INFO,"++ action_filter_pool_by_word: " . $parent_id . ", name: " . $name . ", " . $page_num . ", " . $word  )->write();

    $parent = Graph::object($parent_id);

    if ( ! $parent->loaded())
    {
      throw new Kohana_Exception('Parent object not found, invalid parent_id?');
    }

    $element = latticecms::get_element_dom_node(Graph::object($parent_id), $name);
    $filters = Associator::get_filters_from_dom_node($element);
    $modified_filters = array();
    foreach ($filters as $filter)
    {
      $filter['match'] = $word;
      $filter['match_fields']  = 'title';
      $modified_filters[] = $filter;
    }

    Kohana::$log->add( Kohana_Log::INFO,"\tmodified Filters: " . print_r( $modified_filters, TRUE ) )->write();

    // paginate here
    $a = new Associator($parent_id, $element->get_attribute('lattice'), $modified_filters);
    $this->response->body($a->render_pool_items());
    $this->response->data(array("num_pages"=>$a->num_pages));

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
