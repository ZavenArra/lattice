<?php

Class Controller_Graph extends Controller {

	public function action_index(){
		echo 'this is the graph';
	}

	public function action_add_object($parent_id, $object_type_id) {
		$data = $_POST;
		$new_id = Graph::object($parent_id)->add_object($object_type_id, $data);
		return $new_id;

	}

	public function action_add_tag($id){
		$object = Graph::object($id);
		$object->add_tag($_POST['tag']);
	}

	public function action_remove_tag($id){
		$object = Graph::object($id);
		$object->remove_tag($_POST['tag']);
	}

	public function action_get_tags($id){
		$tags = Graph::object($id)->get_tag_strings();
		$this->response->data(array('tags'=>$tags));
	}
	

}
