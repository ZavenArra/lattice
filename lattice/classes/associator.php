<?
/* @package Lattice */

Class Associator {

  public $parentId = NULL;
  public $parent = NULL;
  public $lattice = NULL;
  public $filters = NULL;
  public $pool = array();
  public $associated = array();

  protected $label;
  protected $poolLabel;

  private $maxPoolSize = 50;

  //TODO
  public function setViewName($viewName){throw new Kohana_Exception('Not Implemented');} //to support multi-lattice single custom view
  public function setAssociatorName($associatorName){throw new Kohana_Exception('Not Implemented');} //to support mutli-instance single lattice

  public function __construct($parentId, $lattice, $filters=NULL){
    $this->parentId = $parentId;
    $this->parent = Graph::object($this->parentId);
    $this->lattice = $lattice;
    $this->filters = $filters; 
    
    foreach($this->parent->getLatticeChildren($this->lattice) as $child){
      $this->associated[] = $child;
    }

    //load pool
    if($filters){
      foreach($filters as $filter){
        $objects = Graph::object();

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
            throw new Kohana_Exception($filter['objectTypeName'] .' Not Found');
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
          $objects = call_user_func($callback, $objects, $parentId);
        }

        $objects->where('objects.language_id', '=', Graph::defaultLanguage());
        $objects->publishedFilter();
        $objects->limit($this->maxPoolSize);

        $results = $objects->find_all();
        foreach($results as $object){
          if(!$this->parent->checkLatticeRelationship($lattice, $object)){
            $this->pool[$object->id] = $object;  //scalability problem
          }
        }
      }	
    } else {
      $objects = Graph::object()
        ->where('id', '!=', $parentId)
        ->where('objects.language_id', '=', Graph::defaultLanguage())
        ->publishedFilter()
        ->limit($this->maxPoolSize)
        ->find_all();
      $this->pool = $objects;
    }

  }

  public function setLabel($label){
    $this->label = $label;
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
