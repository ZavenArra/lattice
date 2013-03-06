<?php

class Controller_CMS extends Lattice_CMS {

  public function get_root_object()
  {
    $root_object_type = ORM::factory('object_type')->where('object_type_name', '=', Kohana::config('cms.graph_root_node'))->find();
    $root_object = Graph::object()->object_type_filter($root_object_type->id)->find();
    return $root_object;

  }


  public function cms_add_object($parent_id, $object_type_id, $data)
  {

    $new_id = Graph::object($parent_id)->add_object($object_type_id, $data);
    return $new_id;

  }

  public function cms_get_node_info($id)
  {

    // Dial up associated navi and ask for details
    return Navigation::get_node_info_by_id($id);

  }

  public function cms_get_node_html($id)
  {

    // Dial up associated navi and ask for details
    $item = Navigation::get_node_info_by_id($id);
    $node_view = new View('navigation_node');
    $node_view->content = $item;
    return $node_view->render();

  }



}
