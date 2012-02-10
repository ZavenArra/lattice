<?

Class Associator {

  public $parentId = NULL;
  public $parent = NULL;
  public $lattice = NULL;
  public $filters = array();
  public $pool = array();
  public $associated = array();

  public function __construct($parentId, $lattice, $filters=array()){
    $this->parentId = $parentId;
    $this->parent = Graph::object($this->parentId);
    $this->lattice = $lattice;
    $this->filters = $filters; 
    
		//load pool
		foreach($filters as $filter){
			$objects = Graph::object();
			if($filter['from']){
				$objects->where('parentId', $this->parent->id);
			}
			if($filter['objectTypeName']){
				$t = ORM::Factory('objectType', $filter['objectTypeName']);
				$object->where('objecttype_id', $t->id);
			}
			if(isset($filters['tagged']) && $filters['tagged']){

			}
			$results = $objects->find_all();
			foreach($results as $object){
				$this->pool[$object->id] = $object;
			}
		}	

    $this->associated = $this->parent->getLatticeChildren($this->lattice);
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

    return $view->render();
  }

  private function getItemView($iItem, $viewName){

    if($viewName && $view = Kohana::find_file('views/lattice/associator/'.$viewName, $item->objecttype->objecttypename)){
      $view = $view[0];
      $view = new View($view);
    } else if($viewName && $view = Kohana::find_file('views/lattice/associator/'.$viewName, 'item')){ 
      $view = $view[0];
      $view = new View($view);
    } else  {
      $view = new View('lattice/associator/item');
    }
    return $view;

  }

}
