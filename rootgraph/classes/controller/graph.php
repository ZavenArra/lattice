<?

Class Controller_Graph extends Controller {

	public function action_index(){
		echo 'this is the graph';
	}

	public function action_addObject($parentId, $objectTypeId) {
		$data = $_POST;
		$newId = Graph::object($parentId)->addObject($objectTypeId, $data);
		return $newId;

	}
}
