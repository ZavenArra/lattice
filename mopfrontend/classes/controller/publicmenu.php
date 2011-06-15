<?

Class Controller_PublicMenu extends Controller_MOP {


	public function action_index(){
		$this->view = new View('publicnav');

		$topLevel = ORM::Factory('object')
			->where('parentid', '=', 0)
			->publishedFilter()
			->noContainerObjects()
			->find_all();
		//need ignores

		$navi = array();
		foreach($topLevel as $object){
			$entry = array();
			$entry['title'] = $object->contenttable->title;
			$entry['slug'] = $object->slug;
			$entry['path'] = $object->slug;

			$navi[$object->slug] = $entry;
		}

		//check for children
		foreach($navi as $slug => $entry){

			$object = ORM::Factory('object', $slug);
			$children = ORM::Factory('object')
				->where('parentid', '=', $object->id)
				->publishedFilter()
				->noContainerObjects()
				->find_all();
			if(count($children)){
				$entry['children'] = array();
				foreach($children as $child){
					$childEntry = array();
					$childEntry['title'] = $child->contenttable->title;
					$childEntry['slug'] = $child->slug;
					$childEntry['path'] = $object->slug.'/'.$child->slug;
					$navi[$slug]['children'][] = $childEntry;
				}
			}
		}


		$this->view->navi = $navi;
		$this->response->body($this->view->render());

	}

}
