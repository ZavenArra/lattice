<?

Class Associator_Controller extends Controller {



	public function createIndexView(){
		$this->view = new View('mop_associator');		
	//	$this->buildIndexData();
		return $this->render();
	}





	public function associate($parentId, $objectId){

	}

	public function disassociate($parentId, $objectId){

	}
}
