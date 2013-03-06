<?php
/* @package Lattice */

Class Associator {
  public $parent_id = NULL;
  public $parent = NULL;
  public $lattice = NULL;
  public $filters = NULL;
  public $pool = array();
  public $associated = array();
  // set this as needed when calling paged results
  // right now this is set on an instance, by actions that pre load $this->pool
  public $num_pages = 2;

  protected $label;
  protected $pool_label;
  protected $page_length;
  // this is page size for paginator
  // this doesn't matter anymore because we're paginating
  private $maxPoolSize = 80;
  private $pageNum = 1;
  public static function getFiltersFromDomNode($node)
  {
    $filtersNodeList = lattice::config('objects', 'filter', $node);
    $filters = array();
    foreach($filtersNodeList as $filter)
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

  // TODO
  // to support multi-lattice single custom view
  public function setViewName($view_name)
  { 
    throw new Kohana_Exception('Not Implemented');
  } 

  // to support mutli-instance single lattice
  public function setAssociatorName($associatorName)
  {
    throw new Kohana_Exception('Not Implemented');
  } 

  public function __construct($parent_id, $lattice, $filters=NULL, $load_pool=NULL)
  {
    $this->parentId = $parent_id;
    $this->parent = Graph::object($this->parentId);
    $this->lattice = $lattice;
    $this->filters = $filters; 
    $this->pageLength = Kohana::config('cms.associatorPageLength');

    foreach($this->parent->getLatticeChildrenPaged($this->lattice) as $child)
    {
      $this->associated[] = $child;
    }

    if(is_array($load_pool))
    {
      $this->pool = $load_pool;
    }
    $load_pool = array();

    if (is_array($load_pool))
    {
      foreach ($load_pool as $l)
      {
        $load_pool[] = $l->id;
      }

    }
    // load pool
    if($filters)
    {

      $objects = Graph::object();

      foreach($filters as $filter)
      {

        if(isset($filter['from']) AND $filter['from'])
        {
          $from = Graph::object($filter['from']);
          ($filter['lattice']) ? $lattice = $filter['lattice'] : ( $lattice = 'lattice' );
          $objects = $from->latticeChildrenQuery($lattice);
        }

        if(isset($filter['tagged']) AND $filter['tagged'])
        {
          $objects->taggedFilter($filter['tagged']); 
        }

        if(isset($filter['objectTypeName']) AND $filter['objectTypeName'])
        {
          $t = ORM::Factory('objectType', $filter['objectTypeName']);
          if(!$t->loaded())
          {
            Graph::configureObjectType($filter['objectTypeName']);
            $t = ORM::Factory('objecttype', $filter['objectTypeName']);
            if(!$t->loaded())
            {
              throw new Kohana_Exception($filter['objectTypeName'] .' Not Found');
            }
          }
          $objects->where('objecttype_id', '=', $t->id);
        }

        if(isset($filter['match']) AND $filter['match'])
        {
          $matchFields = explode(',',$filter['matchFields']);
          $wheres = array();
          foreach($matchFields as $matchField)
          {
            $wheres[] = array($matchField, 'LIKE', '%'.$filter['match'].'%'); 
          }
          $objects->contentFilter($wheres);

        }

        if(isset($filter['function']) AND $filter['function'])
        {
          $callback = explode('::', $filter['function']);

          $options = null;
          $objects = call_user_func($callback, $objects, $parent_id, $options);
        }


        $objects->where('objects.language_id', '=', Graph::defaultLanguage());
        $objects->publishedFilter();
        //just return an array of id's then load the pool object
        $results = $objects->find_all()->as_array(NULL, 'id');
        //check our filtered objects are correct
        //compact the array to remove redundant keys
        $res = array();
        foreach ($results as $id) {
          $object = Graph::object($id);
          if(!$this->parent->checkLatticeRelationship($lattice, $object))
          {
            $res[$id] = $id;
          }
        }
        $results = $res;
        $this->numPages = ceil(count($results)/$this->pageLength);
        //get slice the first page, then load the objects from their id's
        $params = explode("/",$_SERVER["REQUEST_URI"]);
        //print_r($params);
        //@TODO this is a kludge.  Oh well.
        if (isset($params[7]) AND $params[6]=="postingVideosAssociator")
        {
          //we're passing a page number - so slice the object ids
          $results = array_slice($results,($params[7]-1)*16,16);
        } else {
          $results = array_slice($results,0,$this->pageLength);
        }

        foreach($results as $id)
        {
          $object = Graph::object($id);
          $this->pool[$id] =$object;  
        }
      }	

    } else if(!is_array($load_pool)) {

      $objects = Graph::object()
        ->where( 'id', '!=', $parent_id )
        ->where( 'objects.language_id', '=', Graph::defaultLanguage() )
        ->publishedFilter()
        ->limit( $this->maxPoolSize )
        ->find_all();
      $this->pool = $objects;

    }

  }

  public function setLabel($label)
  {
    $this->label = $label;
  }
  public function setPageLength($page_length)
  {
    $this->pageLength = $page_length;
  }

  public function setPoolLabel($pool_label)
  {
    $this->poolLabel = $pool_label;
  }

  public function render($view_name = NULL)
  {
    if($view_name AND  ($view = Kohana::find_file('views', 'lattice/associator/'.$view_name) ))
    {
      $view = new View('lattice/associator/'.$view_name);
    } else {
      $view = new View('lattice/associator');
    }


    $view->pool = $this->poolItemViews($view_name);

    $view->associated = array();
    foreach($this->associated as $associatedItem)
    {
      $view->associated[] = $this->getItemView($associatedItem, $view_name, true );
    }

    $view->parentId = $this->parentId;
    $view->lattice = $this->lattice;
    $view->label = $this->label;
    $view->poolLabel = $this->poolLabel;
    $view->pageLength = $this->pageLength;
    $view->numPages = $this->numPages;



    /*
    paginator vars- probably should be its own func
    these are messy too

     */

    $view->urlPrepend = "ajax/html";
    //  echo strpos($original_uri,$action);
    //pass our paginator params to the view
    //    $view->controllerName = $this->request->controller();
    //    $view->action = $action;
    //    $view->params = $this->request->param();
    //    $view->currentPage = $view->params["param4"];
    /* end paginator vars*/ 
    return $view->render();
  }

  public function renderPoolItems()
  {
    return( implode("\n",$this->poolItemViews($this->lattice) ) );
  }

  private function poolItemViews($view_name = NULL)
  {
    $poolItemViews = array();
    foreach($this->pool as $poolItem)
    {
      $poolItemViews[] = $this->getItemView($poolItem, $view_name, false );
    }
    return $poolItemViews;
  }

  private function getItemView($item, $view_name, $associated )
  {

    if($view_name AND $view = Kohana::find_file('views/lattice/associator/'.$view_name, $item->objecttype->objecttypename))
    {
      $view = new View('lattice/associator/'.$view_name.'/'.$item->objecttype->objecttypename);
    } else if($view_name AND $view = Kohana::find_file('views/lattice/associator/'.$view_name, 'item'))
    { 
      $view = new View('lattice/associator/'.$view_name.'/'.'item');
    } else if($view = Kohana::find_file('views/lattice/associator/', $item->objecttype->objecttypename))
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
