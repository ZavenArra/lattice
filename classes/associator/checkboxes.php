<?php
/* @package Lattice */

Class Associator_Checkboxes {

  public $parent_id = NULL;
  public $parent = NULL;
  public $lattice = NULL;
  public $filters = NULL;
  public $pool = array();
  public $associated = array();

  protected $label;
  protected $pool_label;

  private $max_pool_size = 350;

  public static function get_filters_from_dom_node($node)
  {
    $filters_node_list = lattice::config('objects', 'filter', $node);
    $filters = array();
    foreach ($filters_node_list as $filter)
    {
      $setting = array();
      $setting['from'] = $filter->get_attribute('from');
      $setting['object_type_name'] = $filter->get_attribute('object_type_name');
      $setting['tagged'] = $filter->get_attribute('tagged');
      $setting['function'] = $filter->get_attribute('function');
      $filters[] = $setting;
    }
    return $filters;

  }


  // TODO
  public function set_view_name($view_name)
  {
    throw new Kohana_Exception('Not Implemented');
  } // to support multi-lattice single custom view

  public function set_associator_name($associator_name)
  {
    throw new Kohana_Exception('Not Implemented');
  } // to support mutli-instance single lattice



  public function __construct($parent_id, $lattice, $filters=NULL, $load_pool=NULL)
  {
    $this->parent_id = $parent_id;
    $this->parent = Graph::object($this->parent_id);
    $this->lattice = $lattice;
    $this->filters = $filters; 

    foreach ($this->parent->get_lattice_children($this->lattice) as $child)
    {
      $this->associated[] = $child;
    }

    if (is_array($load_pool))
    {
      $this->pool = $load_pool;
    }

    // load pool
    if ($filters)
    {
      foreach ($filters as $filter)
      {
        $objects = Graph::object();

        if (isset($filter['from']) AND $filter['from'])
        {
          $from = Graph::object($filter['from']);
          ($filter['lattice']) ? $lattice = $filter['lattice'] : $lattice = 'lattice';
          $objects = $from->lattice_children_query($lattice);
        }

        if (isset($filter['tagged']) AND $filter['tagged'])
        {
          $objects->tagged_filter($filter['tagged']); 
        }



        if (isset($filter['object_type_name']) AND $filter['object_type_name'])
        {
          $t = ORM::Factory('object_type', $filter['object_type_name']);
          if (!$t->loaded())
          {
            Graph::configure_object_type($filter['object_type_name']);
            $t = ORM::Factory('objecttype', $filter['object_type_name']);
            if (!$t->loaded())
            {
              throw new Kohana_Exception($filter['object_type_name'] .' Not Found');
            }
          }
          $objects->where('objecttype_id', '=', $t->id);
        }
        if (isset($filter['match']) AND $filter['match'])
        {
          $match_fields = explode(',',$filter['match_fields']);
          $wheres = array();
          foreach ($match_fields as $match_field)
          {
            $wheres[] = array($match_field, 'LIKE', '%'.$filter['match'].'%'); 
          }
          $objects->content_filter($wheres);

        }

        if (isset($filter['function']) AND $filter['function'])
        {
          $callback = explode('::', $filter['function']);
          $objects = call_user_func($callback, $objects, $parent_id);
        }

        $objects->where('objects.language_id', '=', Graph::default_language());
        $objects->published_filter();
        $objects->limit($this->max_pool_size);

        $results = $objects->find_all();
        foreach ($results as $object)
        {
          if (!$this->parent->check_lattice_relationship($lattice, $object))
          {
            $this->pool[$object->id] = $object;  // scalability problem
          }
        }
      } 
    } elseif (!is_array($load_pool))
    {

      $objects = Graph::object()
        ->where('id', '!=', $parent_id)
        ->where('objects.language_id', '=', Graph::default_language())
        ->published_filter()
        ->limit($this->max_pool_size)
        ->find_all();
      $this->pool = $objects;
    }

  }

  public function set_label($label)
  {
    $this->label = $label;
  }

  public function set_pool_label($pool_label)
  {
    $this->pool_label = $pool_label;
  }

  public function render($view_name = NULL)
  {
    if ($view_name AND  ($view = Kohana::find_file('views', 'lattice/associator/'.$view_name) ))
    {
      $view = new View('lattice/associator/'.$view_name);
    } else {
      $view = new View('lattice/associator');
    }

    $view->pool = $this->pool_item_views($view_name);

    $view->associated = array();
    foreach ($this->associated as $associated_item)
    {
      $view->associated[] = $this->get_item_view($associated_item, $view_name);
    }

    $view->parent_id = $this->parent_id;
    $view->lattice = $this->lattice;

    $view->label = $this->label;
    $view->pool_label = $this->pool_label;
    return $view->render();
  }

  public function render_pool_items()
  {
    return(implode("\n",$this->pool_item_views($this->lattice)));
  }

  private function pool_item_views($view_name = NULL)
  {
    $pool_item_views = array();
    foreach ($this->pool as $pool_item)
    {
      $pool_item_views[] = $this->get_item_view($pool_item, $view_name);
    }
    return $pool_item_views;
  }

  private function get_item_view($item, $view_name)
  {

    if ($view_name AND $view = Kohana::find_file('views/lattice/associator/'.$view_name, $item->objecttype->objecttypename))
    {
      $view = new View('lattice/associator/'.$view_name.'/'.$item->objecttype->objecttypename);
      //       Kohana::$log->add(Log::ERROR, "A")->write();
    } elseif ($view_name AND $view = Kohana::find_file('views/lattice/associator/'.$view_name, 'item'))
    { 
      $view = new View('lattice/associator/'.$view_name.'/'.'item');
      //       Kohana::$log->add(Log::ERROR, "B")->write();
    } elseif ($view = Kohana::find_file('views/lattice/associator/', $item->objecttype->objecttypename))
    { 
      $view = new View('lattice/associator/'.$item->objecttype->objecttypename);
      //       Kohana::$log->add(Log::ERROR, "C " . $item . ", " . $view_name )->write();
    } else  {
      //       Kohana::$log->add(Log::ERROR, "D " . $item . ", " . $view_name )->write();
      $view = new View('lattice/associator/item');
    }
    $view->object = $item;

    $view->selected = FALSE;

    return $view;

  }

}

/*
Class Associator_Checkboxes {

  public static function make_pool($associated_views, $pool_views)
{
    if (count($associated_views))
{
      $keys = array_map(array('Associator_Checkboxes','title_index'), $associated_views);
      $associated_views = array_combine($keys, $associated_views);
    }
    $pool_views = array_combine( array_map(array('Associator_Checkboxes','title_index'), $pool_views),  $pool_views);
    foreach ($associated_views as $key => $view)
{
      $view->selected = TRUE;
      $pool_views[$key] = $view;
    }

    array_walk($pool_views, array('Associator_Checkboxes', 'set_unique_element_id'));

    ksort($pool_views);

    return $pool_views;
  }

  private static function title_index($view)
{
    return $view->object->title;
  }

  private static function set_unique_element_id($view)
{
    $view->unique_element_id = Lattice_cms::unique_element_id();
  }

}*/
