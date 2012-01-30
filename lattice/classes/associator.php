<?

Class Associator {

  public $parentId = NULL;
  public $lattice = NULL;
  public $filters = array();

  public function __construct($parentId, $lattice, $filters=array()){
    $this->parentId = $parentId;
    $this->lattice = $lattice;
    $this->filters = $filters; 
  }

  public function render(){
    $view = new View('lattice_associator');
    $object = Graph::object($this->parentId);
    $latticeChildren = $object->getLatticeChildren($this->lattice);
    $view->associatedChildren = $latticeChildren;
    return $view->render();
  }
}
