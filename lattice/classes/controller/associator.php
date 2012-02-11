<?

Class Controller_Associator extends Controller_Lattice {

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
