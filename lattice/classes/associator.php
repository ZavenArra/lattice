<?
/* @package Lattice */

Class Associator {

  public $parentId = NULL;
  public $parent = NULL;
  public $lattice = NULL;
  public $filters = NULL;
  public $pool = array();
  public $associated = array();

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

        if(isset($filter['objectTypeName']) && $filter['objectTypeName']){
          $t = ORM::Factory('objectType', $filter['objectTypeName']);
          $objects->where('objecttype_id', '=', $t->id);
        }
        if(isset($filter['tagged']) && $filter['tagged']){
          throw new Kohana_Exception('Not Implemented');
        }

        if(isset($filter['match']) && $filter['match']){
          $matchFields = explode(',',$filter['matchFields']);
          $wheres = array();
          foreach($matchFields as $matchField){
            $wheres[] = array($matchField, 'LIKE', '%'.$filter['match'].'%'); 
          }
          $objects->contentFilter($wheres);

        }

        $objects->where('language_id', '=', Graph::defaultLanguage());
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
        ->where('language_id', '=', Graph::defaultLanguage())
        ->publishedFilter()
        ->limit($this->maxPoolSize)
        ->find_all();
      $this->pool = $objects;
    }

  }

  public function render($viewName = NULL){
    if($viewName && $view = Kohana::find_file('views/lattice/associator', $viewName)){
      $view = $view[0];
      $view = new View($view);
    } else {
      $view = new View('lattice/associator');
    }

    $view->pool = $this->poolItemViews();

    $view->associated = array();
    foreach($this->associated as $associatedItem){
      $view->associated[] = $this->getItemView($associatedItem, $viewName);
    }

    $view->parentId = $this->parentId;
    $view->lattice = $this->lattice;

    return $view->render();
  }

  public function renderPoolItems(){
    return(implode("\n",$this->poolItemViews()));
  }

  private function poolItemViews(){
    $poolItemViews = array();
    foreach($this->pool as $poolItem){
      $poolItemViews[] = $this->getItemView($poolItem, $this->lattice);
    }
    return $poolItemViews;
  }

  private function getItemView($item, $viewName){

    if($viewName && $view = Kohana::find_file('views/lattice/associator/'.$viewName, $item->objecttype->objecttypename)){
      $view = $view[0];
      $view = new View($view);
    } else if($viewName && $view = Kohana::find_file('views/lattice/associator/'.$viewName, 'item')){ 
      $view = $view[0];
      $view = new View($view);
    } else  {
      $view = new View('lattice/associator/item');
    }
    $view->object = $item;
    return $view;

  }

}
