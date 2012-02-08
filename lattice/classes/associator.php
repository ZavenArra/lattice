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

  public function render(){
    $view = new View('lattice_associator');
    $view->pool = $this->pool;
    $view->associatedChildren = $this->associated;
    return $view->render();
  }
}
