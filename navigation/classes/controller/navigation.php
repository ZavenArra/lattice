<?
/**
* Class: Navigation_Controller 
*
*
*/

class Controller_Navigation extends Controller_MOP{
   
	private $defaultAddCategoryText = '';
	private $defaultAddLeafText = '';

	public function __construct($request, $response){
		parent::__construct($request, $response);

		$this->defaultAddCategoryText = Kohana::config('navigation.addCategoryText');
		$this->defaultAddLeafText = Kohana::config('navigation.addLeafText');
	}


	public function action_index($deeplink=null){
		
		//$this->view = new View(strtolower($this->controllername));
		////this should check and extend
		$this->view = new View('navigation');
		$this->response->body($this->view->render());

	}

	/*
	 *
	 * Override this function to use nav on other data sources
	 *
	 */
   public function getTier($parentId, $deeplinkPath=array(), &$follow=false){
		 $parent = Graph::object($parentId);
		 if(!$parent->loaded()){
				throw new Kohana_Exception('Invalid object id sent to getTier');
		 }
			
		$items = Graph::object($parent->id)
              ->latticeChildrenQuery()
              ->activeFilter()
              ->order_by('sortorder')
              ->find_all();
      
		if($items){
			$sendItemContainers = array(); //these will go first
			$sendItemObjects = array();
			foreach($items as $child){
				if(strtolower($child->objecttype->nodeType) == 'container'){
					//we might be skipping this node

					//echo sprintf('//objectType[@name="%s"]/elements/list[@family="%s"]', $parent->objecttype->objecttypename, $child->objecttype->objecttypename);
					$display = mop::config('objects', sprintf('//objectType[@name="%s"]/elements/list[@family="%s"]', 
						$parent->objecttype->objecttypename,
						$child->objecttype->objecttypename))
						->item(0)
						->getAttribute('display');
					if($display == 'inline'){
						continue;
					}
				}
				$sendItem = Navigation::getNodeInfo($child);

				//implementation of deeplinking
				$sendItem['follow'] = false;
				if (in_array($child->id, $deeplinkPath)) {
               $sendItem['follow'] = true;
               $follow = true;

               //and deeplinking for categories
               $follow_tier = false;
               $children = $this->getTier($child->id, $deeplinkPath, $follow_tier);
               if ($follow_tier == true) {
                  $sendItem['follow'] = true;
                  $follow = 'true';
               }
               $sendItem['children'] = $children;
            }

				if(strtolower($child->objecttype->nodeType)=='container'){
					$sendItemContainers[] = $sendItem;
				} else {
					$sendItemObjects[] = $sendItem;
				}
			}
			//this puts the folders first
			$sendItemObjects = array_merge($sendItemContainers, $sendItemObjects);
         

			//add in any modules
			//if(!$parent->loaded()){
			if($parent->id == Graph::getRootNode(Kohana::config('cms.graphRootNode'))->id ){
				$cmsModules = mop::config('cmsModules', '//module');
				foreach($cmsModules as $m){

					$entry = array();
					$entry['id'] = $m->getAttribute('controller');
					$entry['slug'] = $m->getAttribute('controller');
					$entry['nodeType'] = 'module';
					$entry['contentType'] = 'module';
					$entry['title'] = $m->getAttribute('label');
					$sendItemObjects[] = $entry;
				}
			}
         return $sendItemObjects;
      }
      
      return null;
      
   }
	
	public function action_getTier($parentId, $deeplink=NULL){
      
      //plan all parents for following deeplink
      $deeplinkPath = array();

      if($deeplink){
         $objectId = $deeplink;
         while($objectId){
            $object = Graph::object($objectId);
            $deeplinkPath[] = $object->id;
            $objectId = $object->parentid;
         }
         $deeplinkPath = array_reverse($deeplinkPath);
      
      }
  
      //this database call happens twice, should be a class variable?
      $parent = Graph::object($parentId);
      
      
      $sendItemObjects = $this->getTier($parentId, $deeplinkPath);

      $this->response->data(array('nodes' => $sendItemObjects));

      $nodes = array();
      foreach ($sendItemObjects as $item) {

         $nodeView = new View('navigationNode');
         $nodeView->content = $item;
         $nodes[] = $nodeView->render();
      }

      $this->response->body($this->renderTierView($parent, $nodes));
   }

	private function renderTierView($parent, $nodes){

      $tierView = new View('navigationTier');
      $tierView->nodes = $nodes;

      $tierMethodsDrawer = new View('tierMethodsDrawer');
			$addableObjects = $parent->objecttype->addableObjects;

			if(moputil::checkAccess('superuser')){
				foreach($this->getObjectTypes() as $objectType){
					$addableObject = array();
					$addableObject['objectTypeId'] = $objectType['objectTypeName'];
					$addableObject['objectTypeAddText'] = "Add a ".$objectType['objectTypeName'];
					$addableObject['nodeType'] = $objectType['nodeType'];
					$addableObject['contentType'] = $objectType['contentType'];
					$addableObjects[] = $addableObject;
				}
			}
      $tierMethodsDrawer->addableObjects = $addableObjects;

      $tierView->tierMethodsDrawer = $tierMethodsDrawer->render();
			return $tierView->render();

	}

	public function getObjectTypes(){
		$objectTypes = array();
		foreach(mop::config('objects', '//objectType') as $objectType){
			$entry = array();
			$entry['objectTypeName'] = $objectType->getAttribute('name');	
			$entry['label'] = $objectType->getAttribute('name').' label';	
			$entry['nodeType'] = $objectType->getAttribute('nodeType');	
			$entry['contentType'] = $objectType->getAttribute('contentType');	
			$objectTypes[] = $entry;
		}
		return $objectTypes;
	}
		
}

?>
