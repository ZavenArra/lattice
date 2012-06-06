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

	public function action_addTag($id){
		$object = Graph::object($id);
		$object->addTag($_POST['tag']);
	}

	public function action_removeTag($id){
		$object = Graph::object($id);
		$object->removeTag($_POST['tag']);
	}

	public function action_getTags($id){
		$tags = Graph::object($id)->getTagStrings();
		$this->response->data(array('tags'=>$tags));
	}
	

}
