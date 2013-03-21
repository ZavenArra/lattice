<?php

Class Kohana_Initializer_Cms {

  public function initialize()
  {

    Graph::configure_object_type(Kohana::config('cms.graph_root_node'), TRUE);
    Graph::add_root_node(Kohana::config('cms.graph_root_node'));

    Lattice_Initializer::add_message('configured graph root node');

  }


}
