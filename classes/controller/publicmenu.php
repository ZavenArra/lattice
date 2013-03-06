<?

Class Controller_Public_menu extends Controller_Lattice {


	public function action_index(){
		$this->view = new View('publicnav');

      $top_level = Graph::get_root_node('cms_root_node')
              ->lattice_children_query('public_site') 
              ->published_filter()
              ->no_container_objects()
              ->find_all();


		$navi = array();
		foreach($top_level as $object){
			$entry = array();
			$entry['title'] = $object->title;
			$entry['slug'] = $object->slug;
			$entry['path'] = $object->slug;

			$navi[$object->slug] = $entry;
		}

		//check for children
		foreach($navi as $slug => $entry){

         $children = Graph::object($slug)
            ->lattice_children_query($object->id)
 				->published_filter()
				->no_container_objects()
				->find_all();
			if(count($children)){
				$entry['children'] = array();
				foreach($children as $child){
					$child_entry = array();
					$child_entry['title'] = $child->title;
					$child_entry['slug'] = $child->slug;
					$child_entry['path'] = $object->slug.'/'.$child->slug;

					$children2 = Graph::object()
						->where('parent_id', '=', $child->id)
						->published_filter()
						->no_container_objects()
						->find_all();
					foreach($children2 as $child2){
						$child_entry2 = array();
						$child_entry2['title'] = $child2->title;
						$child_entry2['slug'] = $child2->slug;
						$child_entry2['path'] = $object->slug.'/'.$child->slug.'/'.$child2->slug;
						$child_entry['children'][] = $child_entry2;
					}




					$navi[$slug]['children'][] = $child_entry;
				}
			}
		}


		$this->view->navi = $navi;
		$this->response->body($this->view->render());

	}

}
