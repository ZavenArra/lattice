<?
/* @package Lattice */

Class Associator {

  public $parentId = NULL;
  public $parent = NULL;
  public $lattice = NULL;
  public $filters = NULL;
  public $pool = array();
  public $associated = array();
  //set this as needed when calling paged results
  //right now this is set on an instance, by actions that pre load $this->pool
  public $numPages = 2;
  
  protected $label;
  protected $poolLabel;
  protected $pageLength;
  //this is page size for paginator
  //this doesn't matter anymore because we're paginating
  private $maxPoolSize = 80;
  private $pageNum = 1;
  public static function getFiltersFromDomNode($node){
    $filtersNodeList = lattice::config('objects', 'filter', $node);
    $filters = array();
    foreach($filtersNodeList as $filter){
      $setting = array();
      $setting['from'] = $filter->getAttribute('from');
      $setting['objectTypeName'] = $filter->getAttribute('objectTypeName');
      $setting['tagged'] = $filter->getAttribute('tagged');
      $setting['function'] = $filter->getAttribute('function');
      $filters[] = $setting;
    }
    return $filters;

  }


  //TODO
  public function setViewName($viewName){throw new Kohana_Exception('Not Implemented');} //to support multi-lattice single custom view
  public function setAssociatorName($associatorName){throw new Kohana_Exception('Not Implemented');} //to support mutli-instance single lattice



  public function __construct($parentId, $lattice, $filters=NULL, $loadPool=NULL){
    $this->parentId = $parentId;
    $this->parent = Graph::object($this->parentId);
    $this->lattice = $lattice;
    $this->filters = $filters; 
    $this->pageLength = Kohana::config('cms.associatorPageLength');

    foreach($this->parent->getLatticeChildren($this->lattice) as $child){
      $this->associated[] = $child;
    }

    if(is_array($loadPool)){
      $this->pool = $loadPool;
    }

    //load pool
    if($filters){

      $objects = Graph::object();

      foreach($filters as $filter){

        if(isset($filter['from']) && $filter['from']){
          $from = Graph::object($filter['from']);
          ($filter['lattice']) ? $lattice = $filter['lattice'] : $lattice = 'lattice';
          $objects = $from->latticeChildrenQuery($lattice);
        }

        if(isset($filter['tagged']) && $filter['tagged']){
          $objects->taggedFilter($filter['tagged']); 
        }

        if(isset($filter['objectTypeName']) && $filter['objectTypeName']){
          $t = ORM::Factory('objectType', $filter['objectTypeName']);
          if(!$t->loaded()){
            Graph::configureObjectType($filter['objectTypeName']);
            $t = ORM::Factory('objecttype', $filter['objectTypeName']);
            if(!$t->loaded()){
              throw new Kohana_Exception($filter['objectTypeName'] .' Not Found');
            }
          }
          $objects->where('objecttype_id', '=', $t->id);
        }

        if(isset($filter['match']) && $filter['match']){
          $matchFields = explode(',',$filter['matchFields']);
          $wheres = array();
          foreach($matchFields as $matchField){
            $wheres[] = array($matchField, 'LIKE', '%'.$filter['match'].'%'); 
          }
          $objects->contentFilter($wheres);

        }

        if(isset($filter['function']) && $filter['function']){
          $callback = explode('::', $filter['function']);
          //$options is an arbitrary array of extra options
          $options = null;
         // Kohana::$log->add(Kohana_Log::INFO, print_r($callback,1));
          $objects = call_user_func($callback, $objects, $parentId, $options);
        }


        $objects->where('objects.language_id', '=', Graph::defaultLanguage());
        $objects->publishedFilter();
        //$objects->limit($this->maxPoolSize);
        //just return an array of id's then load the pool object
        $results = $objects->find_all()->as_array(NULL, 'id');
        //check our filtered objects are correct
//        Kohana::$log->add(Kohana_Log::INFO,"filtered objects");

//        Kohana::$log->add(Kohana_Log::INFO, print_r($results,1));
        //compact the array to remove redundant keys
        $res = array();
        foreach ($results as $id) {
          $object = Graph::object($id);
          if(!$this->parent->checkLatticeRelationship($lattice, $object)){
            $res[$id] = $id;
          }
        }
        $results = $res;

        if ($lattice =="artistprojects"){
          Kohana::$log->add(Kohana_Log::INFO, print_r($filter,1));
          Kohana::$log->add(Kohana_Log::INFO, "results count ".count($results)." num pages ".$this->numPages )->write();
          Kohana::$log->add(Kohana_Log::INFO, "results count ".count($results)." num pages ".$this->numPages )->write();
          
        }


        $this->numPages = ceil(count($results)/$this->pageLength);
//        Kohana::$log->add(Log::INFO, $this->parentId);
        
        //get slice the first page, then load the objects from their id's
        $results = array_slice($results,0,$this->pageLength);
        foreach($results as $id){
          $object = Graph::object($id);
          $this->pool[$id] =$object;  
          if ($lattice =="artistprojects"){
             Kohana::$log->add(Log::INFO,"what object type is this: ". $object->objecttypename)->write();
          }
        }
      }	
      
    } else if(!is_array($loadPool)) {

      $objects = Graph::object()
        ->where('id', '!=', $parentId)
        ->where('objects.language_id', '=', Graph::defaultLanguage())
        ->publishedFilter()
        ->limit($this->maxPoolSize)
        ->find_all();
      $this->pool = $objects;
      //echo "second";
      //var_dump($this->pool);
    }

  }

  public function setLabel($label){
    $this->label = $label;
  }
  public function setPageLength($pageLength){
    $this->pageLength = $pageLength;
  }

  public function setPoolLabel($poolLabel){
    $this->poolLabel = $poolLabel;
  }

  public function render($viewName = NULL){
    if($viewName &&  ($view = Kohana::find_file('views', 'lattice/associator/'.$viewName) )){
      $view = new View('lattice/associator/'.$viewName);
    } else {
      $view = new View('lattice/associator');
    }
    
    
    $view->pool = $this->poolItemViews($viewName);

    $view->associated = array();
    foreach($this->associated as $associatedItem){
      $view->associated[] = $this->getItemView($associatedItem, $viewName);
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

  public function renderPoolItems(){
    
    return(implode("\n",$this->poolItemViews($this->lattice)));
  }

  private function poolItemViews($viewName = NULL){
    $poolItemViews = array();
    foreach($this->pool as $poolItem){
      $poolItemViews[] = $this->getItemView($poolItem, $viewName);
    }
    return $poolItemViews;
  }

  private function getItemView($item, $viewName){

    if($viewName && $view = Kohana::find_file('views/lattice/associator/'.$viewName, $item->objecttype->objecttypename)){
      $view = new View('lattice/associator/'.$viewName.'/'.$item->objecttype->objecttypename);
    } else if($viewName && $view = Kohana::find_file('views/lattice/associator/'.$viewName, 'item')){ 
      $view = new View('lattice/associator/'.$viewName.'/'.'item');
    } else if($view = Kohana::find_file('views/lattice/associator/', $item->objecttype->objecttypename)){ 
      $view = new View('lattice/associator/'.$item->objecttype->objecttypename);
    } else  {
      $view = new View('lattice/associator/item');
    }
    $view->object = $item;

    $view->selected = false;

    return $view;

  }



}
