<?

Class Associator_Controller extends Controller {

	private $pool;
	private $associated;
	private $parent;
	private $field;

	public function __construct($filters, $object_id, $field){
		//load parent
		$this->parent = Graph::object($object_id);


		//get already associated objects
		//
		/*
		$association = ORM::Factory('association');
		$association_id = $association->getAssociationId($this->parent->id, $field);
		$associated = ORM::Factory('
*/

		$this->field = $field;

	}

	public function createIndexView(){
		$this->view = new View('lattice_associator');		
		$this->view->pool = $this->pool;
		$this->view->field = $this->field;
	}

	public function action_associate($parentId, $objectId, $lattice){
    Graph::object($parentId)->addLatticeRelationship($lattice, $objectId);
	}

	public function action_dissociate($parentId, $objectId, $lattice){
    Graph::object($parentId)->removeLatticeRelationship($lattice, $objectId);
	}

  public function action_filterPoolByWord($parentId, $name, $word){
    $element = latticecms::getElementConfig(Graph::object($parentId), $name);
    $filters = array( 
      array(
        'match' => $word
      )
    );
    $a = new Associator($parentId, $element['lattice'], $filters);
    $this->response->body($a->renderPoolItems());
  }

}
