<?

Class Associator {

  public $parentId = NULL;
  public $parent = NULL;
  public $lattice = NULL;
  public $filters = NULL;
  public $pool = array();
  public $associated = array();

  private $maxPoolSize = 50;

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
        if($filter['from']){
          $from = Graph::object($filter['from']);
          ($filter['lattice']) ? $lattice = $filter['lattice'] : $lattice = 'lattice';
          $objects = $from->latticeChildrenQuery($lattice);
        }
        if($filter['objectTypeName']){
          $t = ORM::Factory('objectType', $filter['objectTypeName']);
          $objects->where('objecttype_id', '=', $t->id);
        }
        if(isset($filters['tagged']) && $filters['tagged']){

        }

        $objects->where('language_id', '=', Graph::defaultLanguage());
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

    $view->pool = array();
    foreach($this->pool as $poolItem){
      $view->pool[] = $this->getItemView($poolItem, $viewName);
    }

    $view->associated = array();
    foreach($this->associated as $associatedItem){
      $view->associated[] = $this->getItemView($associatedItem, $viewName);
    }

    $view->parentId = $this->parentId;
    $view->lattice = $this->lattice;

    return $view->render();
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
