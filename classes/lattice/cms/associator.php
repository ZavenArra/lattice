<?php
/* @package Lattice */

Class Lattice_Cms_Associator {
  public $parent_id = NULL;
  public $parent = NULL;
  public $lattice = NULL;
  public $filters = NULL;
  public $pool = array();
  public $associated = array();
  //  set this as needed when calling paged results
  //  right now this is set on an instance, by actions that pre load $this->pool
  public $num_pages = 2;

  protected $label;
  protected $pool_label;
  protected $page_length;
  //  this is page size for paginator
  //  this doesn't matter anymore because we're paginating
  private $max_pool_size = 80;
  private $page_num = 1;
  public static function get_filters_from_dom_node($node)
  {
    $filters_node_list = core_lattice::config('objects', 'filter', $node);
    $filters = array();
    foreach ($filters_node_list as $filter)
    {
      $setting = array();
      $setting['from'] = $filter->getAttribute('from');
      $setting['objectTypeName'] = $filter->getAttribute('objectTypeName');
      $setting['tagged'] = $filter->getAttribute('tagged');
      $setting['function'] = $filter->getAttribute('function');
      $filters[] = $setting;
    }
    return $filters;

  }

  //  TODO
  //  to support multi-lattice single custom view
  public function set_view_name($view_name)
  { 
    throw new Kohana_Exception('Not Implemented');
  } 

  //  to support mutli-instance single lattice
  public function set_associator_name($associator_name)
  {
    throw new Kohana_Exception('Not Implemented');
  } 

  public function __construct($parent_id, $lattice, $filters=NULL, $load_pool=NULL)
  {
    $this->parent_id = $parent_id;
    $this->parent = Graph::object($this->parent_id);
    $this->lattice = $lattice;
    $this->filters = $filters; 
    $this->page_length = Kohana::config('cms.associator_page_length');


    foreach ($this->parent->get_lattice_descendents_paged($this->lattice) as $child)
    {
      $this->associated[] = $child;
		}


    if (is_array($load_pool))
    {
      $this->pool = $load_pool;
    } else if (is_object($load_pool)) {
			$this->pool = $load_pool;
    }

    if ($filters)
    {

      $objects = Graph::object();

      foreach ($filters as $filter)
      {

        if (isset($filter['from']) AND $filter['from'])
        {
          $from = Graph::object($filter['from']);
          ($filter['lattice']) ? $lattice = $filter['lattice'] : ( $lattice = 'lattice' );
          $objects = $from->lattice_descendents_query($lattice);
        }

        if (isset($filter['tagged']) AND $filter['tagged'])
        {
          $objects->tagged_filter($filter['tagged']); 
        }

        if (isset($filter['objectTypeName']) AND $filter['objectTypeName'])
        {
          $t = ORM::Factory('objecttype', $filter['objectTypeName']);
          if ( ! $t->loaded())
          {
            Graph::configure_object_type($filter['objectTypeName']);
            $t = ORM::Factory('objecttype', $filter['objectTypeName']);
            if ( ! $t->loaded())
            {
              throw new Kohana_Exception($filter['objectTypeName'] .' Not Found');
            }
          }
          $objects->where('objecttype_id', '=', $t->id);
        }


				// TODO: need better docs on what is allowed to be sent to this functions
				// currently, this func can be used to override everything above
        if (isset($filter['function']) AND $filter['function'])
        {
          $callback = explode('::', $filter['function']);

          $options = NULL;
          $objects = call_user_func($callback, $objects, $parent_id, $options);
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
				
        $objects->where('objects.language_id', '=', Graph::default_language());
        $objects->published_filter();
				$objects->order_by('slug');

        // just return an array of id's then load the pool object
				$results = $objects->find_all();

				$results = $results->as_array(NULL, 'id');
        // check our filtered objects are correct
        // compact the array to remove redundant keys
        $res = array();
        foreach ($results as $id)
        {
          $object = Graph::object($id);
          if ( ! $this->parent->check_lattice_relationship($lattice, $object))
          {
            $res[$id] = $id;
          }
        }

        $results = $res;

				$this->num_pages = ceil(count($results)/$this->page_length);

				$offset = 0;
				if (isset($filter['page'])){
					$offset = $filter['page'] * $this->page_length;
				}
				// And slice the results
				$results = array_slice($results, $offset, $this->page_length);

        foreach ($results as $id)
        {
          $object = Graph::object($id);
          $this->pool[$id] =$object;  
        }

      }	

		} 
		elseif ( ! $load_pool )
		{

			$objects = Graph::object()
				->where( 'id', '!=', $parent_id )
				->where( 'objects.language_id', '=', Graph::default_language() )
				->published_filter()
				->limit( $this->max_pool_size )
				->find_all();
			$this->pool = $objects;

		}

  }

  public function set_label($label)
  {
    $this->label = $label;
  }
  public function set_page_length($page_length)
  {
    $this->page_length = $page_length;
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
      $view->associated[] = $this->get_item_view($associated_item, $view_name, TRUE );
    }

    $view->parent_id = $this->parent_id;
    $view->lattice = $this->lattice;
    $view->label = $this->label;
    $view->pool_label = $this->pool_label;
    $view->page_length = $this->page_length;
    $view->num_pages = $this->num_pages;


    /*
      paginator vars- probably should be its own func
      these are messy too

     */

    $view->url_prepend = "ajax/html";
    //  echo strpos($original_uri,$action);
    //  pass our paginator params to the view
    //  $view->controller_name = $this->request->controller();
    //  $view->action = $action;
    //  $view->params = $this->request->param();
    //  $view->current_page = $view->params["param4"];

    /* end paginator vars*/ 
    return $view->render();
  }

  public function render_pool_items()
  {
    return( implode("\n",$this->pool_item_views($this->lattice) ) );
  }

  private function pool_item_views($view_name = NULL)
  {
    $pool_item_views = array();
    foreach ($this->pool as $pool_item)
    {
      $pool_item_views[] = $this->get_item_view($pool_item, $view_name, FALSE );
    }
    return $pool_item_views;
  }

  private function get_item_view($item, $view_name, $associated )
  {
    if ($view_name AND $view = Kohana::find_file('views/lattice/associator/'.$view_name, $item->objecttype->objecttypename))
    {
      $view = new View('lattice/associator/'.$view_name.'/'.$item->objecttype->objecttypename);
    } elseif ($view_name AND $view = Kohana::find_file('views/lattice/associator/'.$view_name, 'item'))
    { 
      $view = new View('lattice/associator/'.$view_name.'/'.'item');
    } elseif ($view = Kohana::find_file('views/lattice/associator/', $item->objecttype->objecttypename))
    { 
      $view = new View('lattice/associator/'.$item->objecttype->objecttypename);
    } else  {
      $view = new View('lattice/associator/item');
    }
    $view->object = $item;

    $view->associated = $associated;

    return $view;

  }



}
