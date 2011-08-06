<?

Class Controller_PublicMenu extends Controller_MOP {


	public function action_index(){
		$this->view = new View('publicnav');

      $topLevel = Graph::getRootNode('cmsRootNode')
              ->latticeChildrenQuery('publicSite') 
              ->publishedFilter()
              ->noContainerObjects()
              ->find_all();


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

         $children = Graph::object($slug)
            ->latticeChildrenQuery($object->id)
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
