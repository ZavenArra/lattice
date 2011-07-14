<?

Class Controller_Graph {
	public function action_addObject($parentId, $templateId) {
		$data = $_POST;
		$newId = Graph::object($parentId)->addObject($templateId, $data);
		return $newId;

	}
}
