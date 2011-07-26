<?
/**
* Class: Navigation_Controller 
*
*
*/

class Controller_Navigation extends Controller_MOP{

	private $objectModel = 'object';

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

   public function getTier($parentId, $deeplinkPath=array(), &$follow=false){
      $parent = ORM::Factory($this->objectModel, $parentId); 
			

		$items = ORM::factory($this->objectModel);
		$items->where('parentId', '=',  $parentId);
		$items->where('activity', 'IS', NULL);
		$items->order_by('sortorder');
		$iitems = $items->find_all();
		if($iitems){
			$sendItemContainers = array(); //these will go first
			$sendItemObjects = array();
			foreach($iitems as $child){
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
					$entry['children'] = array();
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
            $object = ORM::Factory('object', $objectId);
            $deeplinkPath[] = $object->id;
            $objectId = $object->parentid;
         }
         $deeplinkPath = array_reverse($deeplinkPath);
      
      }
  
      //this database call happens twice, should be a class variable?
      $parent = ORM::Factory($this->objectModel, $parentId); 

      
      $sendItemObjects = $this->getTier($parentId, $deeplinkPath);

      $this->response->data(array('nodes' => $sendItemObjects));

      $nodes = array();
      foreach ($sendItemObjects as $item) {

         $nodeView = new View('navigationNode');
         $nodeView->content = $item;
         $nodes[] = $nodeView->render();
      }

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
      $this->response->body($tierView->render());
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
