<?

Class Lattice_Controller_Associator extends Controller_Lattice {

	public function action_associate($parentId, $objectId, $lattice){
    Graph::object($parentId)->addLatticeRelationship($lattice, $objectId);
	}

	public function action_dissociate($parentId, $objectId, $lattice){
    Graph::object($parentId)->removeLatticeRelationship($lattice, $objectId);
	}

  public function action_getPage($parentId, $name, $pageNum=0, $word=""){
    $parent = Graph::object($parentId);
    if(!$parent->loaded()){
      throw new Kohana_Exception('Parent object not found, invalid parentId?');
    }

    $element = latticecms::getElementDomNode(Graph::object($parentId), $name);
    $filters = Associator::getFiltersFromDomNode($element);
    $modifiedFilters = array();
    foreach($filters as $filter){
      $filter['match'] = $word;
      $filter['matchFields']  = 'title';
      $modifiedFilters[] = $filter;
    }
    $a = new Associator($parentId, $element->getAttribute('lattice'), $modifiedFilters);
    $this->response->body($a->renderPoolItems());
  }

  public function action_filterPoolByWord($parentId, $name, $pageNum=0,$word=""){
    $parent = Graph::object($parentId);
    if(!$parent->loaded()){
      throw new Kohana_Exception('Parent object not found, invalid parentId?');
    }

    $element = latticecms::getElementDomNode(Graph::object($parentId), $name);
    $filters = Associator::getFiltersFromDomNode($element);
    $modifiedFilters = array();
    foreach($filters as $filter){
      $filter['match'] = $word;
      $filter['matchFields']  = 'title';
      $modifiedFilters[] = $filter;
    }
    
    //paginate here
    $a = new Associator($parentId, $element->getAttribute('lattice'), $modifiedFilters);
    $this->response->body($a->renderPoolItems());
  }
  
  public function action_filterPoolByTag($parentId, $name, $tag) {
    $parent = Graph::object($parentId);
     if(!$parent->loaded()){
       throw new Kohana_Exception('Parent object not found, invalid parentId?');
     }
     
  }


}
