<?

Class Controller_Graph {
	public function action_addObject($parentId, $objectTypeId) {
		$data = $_POST;
		$newId = Graph::object($parentId)->addObject($objectTypeId, $data);
		return $newId;

	}
}
