<?

Class Associator_Controller extends Controller {

	private $pool;
	private $associated;
	private $parent;
	private $field;

	public function __construct($filters, $object_id, $field){
		//load parent
		$this->parent = ORM::Factory('object', $object_id);

		//load pool
		foreach($filters as $filter){
			$objects = ORM::Factory('object');
			if($filter['from']){
				$objects->where('parentId', $this->parent->id);
			}
			if($filter['templateName']){
				$t = ORM::Factory('template', $filter['templateName']);
				$object->where('template_id', $t->id);
			}
			if(isset($filters['tagged']) && $filters['tagged']){

			}
			$results = $objects->find_all();
			foreach($results as $object){
				$this->pool[$object->id] = $object;
			}
		}	

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
		$this->view = new View('mop_associator');		
		$this->view->pool = $this->pool;
		$this->view->field = $this->field;
	}





	public function associate($parentId, $objectId){

	}

	public function disassociate($parentId, $objectId){

	}
}
