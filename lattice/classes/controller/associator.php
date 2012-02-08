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

	}

	public function action_disassociate($parentId, $objectId, $lattice){

	}
}
