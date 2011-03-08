<?

Class publicNav_Controller extends MOP_Controller_Core {


	public function createIndexView(){
		$this->view = new View('publicnav');

		$topLevel = ORM::Factory('page')
			->where('parentid', 0)
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

			$object = ORM::Factory('page', $slug);
			$children = ORM::Factory('page')
				->where('parentid', $object->id)
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

	}

}
