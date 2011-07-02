<?
/**
* Class: Navigation_Controller 
*
*
*/

class Controller_Navigation extends Controller_MOP{

	private $objectModel = 'page';

	private $navDataFields_page = array(
		'id'=>'id',
		'slug'=>'slug',
		'published'=>'published',
	);
	public $navDataFields_template = array(
		'nodeType',
		'contentType',
		'allowDelete',
		'allowTogglePublish',
		'landing',
		'allowChildSort',
		'addableObjects',
	);
	/*should title be stored in the PAGE table instead?*/
	private $navDataFields_content = array(
		'title'=>'title',
	);

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
	Function: getNavTree
	Recursively walk the entire nav tree

	Returns:
	A tree structure with each node as the following:
	array( 
		id
		identifier
		published
		nodeType
		contenttype	
		allowAddCategory
		allowAddLeaf
		landing
		addCategoryText
		addLeafText	
		allowDelete
		allowTogglePubish
		title
		follow
		children - array()
	)
	*/
	public function action_getNavTree($deeplink=NULL){
		$navtree = $this->_getNavTree_recurse(0, $deeplink);
		$this->response->data($navtree);
	}

	/*
		Function:getNode
		Public interface to request one node + child tree from the navigation controller
		Parameters:
			$id - the id of the noe
		Returns:
		Array of node data as specified by the controller, expected by js frontend.
	*/
	public function action_getNode($id){
		$item = ORM::factory($this->objectModel, $id);
		$return = $this->_loadNode($item);
		$return['children'] = $this->_getNavTree_recurse($id);
		return $return;
	}

	public function loadNode($id){
		$item = ORM::factory($this->objectModel, $id);
		return $this->_loadNode($item);

	}


	/*
		Function:_loadNode
		Private Utility function to get one node
	*/
	private function _loadNode(& $item){
		$sendItem = array();
		foreach($this->navDataFields_page as $send=>$field){
			$sendItem[$send] = $item->$field;
		}
		foreach($this->navDataFields_template as $field){
			$sendItem[$field] = $item->template->$field;
		}
		if(!count($sendItem['addableObjects'])){
			unset($sendItem['addableObjects']);
		}

		//this part should get removed or not
		try {
			if(!is_object($item->contenttable)){
				throw new Kohana_User_Exception('BAD_MOP_DB', 'template: ' . $item->template->templatename . ' table: '.$item->template->contenttable);
			}
			foreach($this->navDataFields_content as $send=>$field){
				$sendItem[$send] = $item->contenttable->$field;
			}
		} catch (Exception $e) {
			if($e->getCode() == 'BAD_MOP_DB'){
				Kohana::$log->add(Log::ERROR, $e->getMessage());
				foreach($this->navDataFields_content as $send=>$field){
					$sendItem[$send] = 'null';
				}
			} else {
				throw $e;
			}
		}
		if(!$sendItem['title']){
			$sendItem['title'] = $sendItem['slug'];
		}

		return $sendItem;
	}

	
	
	/*
	Function: _getNavTree_recurse
	Private utility to recursivly walk the nav tree starting with a parent id
	*/
	private function _getNavTree_recurse($parentid, $deeplink=NULL, &$follow=false){
		$parent = ORM::Factory($this->objectModel, $parentid); //it would be nice to be able to just look up the heap

		$items = ORM::factory($this->objectModel);
		$items->where('parentid', '=', $parentid);
		$items->where('activity', 'IS', NULL);
		$items->order_by('sortorder');
		if($iitems = $items->find_all()){
			$sendItemContainers = array(); //these will go first
			$sendItemObjects = array();
			foreach($iitems as $child){
				if(strtolower($child->template->nodeType) == 'container'){
					//we might be skipping this node

					//echo sprintf('//template[@name="%s"]/elements/list[@family="%s"]', $parent->template->templatename, $child->template->templatename);
					$display = mop::config('objects', sprintf('//template[@name="%s"]/elements/list[@family="%s"]', 
																										$parent->template->templatename,
                                                    $child->template->templatename))
                                                    ->item(0)
																										->getAttribute('display');
					if($display == 'inline'){
						continue;
					}
				}
				$sendItem = $this->_loadNode($child);
		
				//implementation of deeplinking
				$sendItem['follow'] = false;
				if($child->id == $deeplink){
					$sendItem['follow'] = true;
					$follow = true;
				}

				//and deeplinking for categories
				$follow_tier = false;
				$children = $this->_getNavTree_recurse($child->id, $deeplink, $follow_tier);
				if($follow_tier==true){
					$sendItem['follow'] = true;
					$follow='true';
				}
				$sendItem['children'] = $children;

				if(strtolower($child->template->nodeType)=='container'){
					$sendItemContainers[] = $sendItem;
				} else {
					$sendItemObjects[] = $sendItem;
				}
			}
			//this puts the folders first
			$sendItemObjects = array_merge($sendItemContainers, $sendItemObjects);


			//add in any objects
			if(!$parent->id){
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
			} else {
				//this is where we would handle the addition to modules on a template basis
			}

			return $sendItemObjects;
		} else {
			return array();
		}
	}



	public function action_getTier($parentid, $deeplink=NULL, &$follow=false){
		$parent = ORM::Factory($this->objectModel, $parentid); 

		$items = ORM::factory($this->objectModel);
		$items->where('parentid', '=',  $parentid);
		$items->where('activity', 'IS', NULL);
		$items->order_by('sortorder');
		$iitems = $items->find_all();
		if($iitems){
			$sendItemContainers = array(); //these will go first
			$sendItemObjects = array();
			foreach($iitems as $child){
				if(strtolower($child->template->nodeType) == 'container'){
					//we might be skipping this node

					//echo sprintf('//template[@name="%s"]/elements/list[@family="%s"]', $parent->template->templatename, $child->template->templatename);
					$display = mop::config('objects', sprintf('//template[@name="%s"]/elements/list[@family="%s"]', 
						$parent->template->templatename,
						$child->template->templatename))
						->item(0)
						->getAttribute('display');
					if($display == 'inline'){
						continue;
					}
				}
				$sendItem = $this->_loadNode($child);

				//implementation of deeplinking
				$sendItem['follow'] = false;
				if($child->id == $deeplink){
					$sendItem['follow'] = true;
					$follow = true;
				}

				//and deeplinking for categories
				$follow_tier = false;
				// $children = $this->_getNavTree_recurse($child->id, $deeplink, $follow_tier);
				if($follow_tier==true){
					$sendItem['follow'] = true;
					$follow='true';
				}
				// $sendItem['children'] = $children;

				if(strtolower($child->template->nodeType)=='container'){
					$sendItemContainers[] = $sendItem;
				} else {
					$sendItemObjects[] = $sendItem;
				}
			}
			//this puts the folders first
			$sendItemObjects = array_merge($sendItemContainers, $sendItemObjects);
         

			//add in any objects
			if(!$parent->loaded()){
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
			} else {
				//this is where we would handle the addition to modules on a template basis
			}

			$this->response->data(array('nodes'=>$sendItemObjects));

			$nodes = array();
			foreach($sendItemObjects as $item){

				$nodeView = new View('navigationNode');
				$nodeView->content = $item;
				$nodes[] = $nodeView->render();
			}

			$tierView = new View('navigationTier');
			$tierView->nodes = $nodes;

			$tierMethodsDrawer = new View('tierMethodsDrawer');
			$tierMethodsDrawer->addableObjects = $parent->template->addableObjects;

			$tierView->tierMethodsDrawer = $tierMethodsDrawer->render();
			$this->response->body($tierView->render());

		} 
	}

	public function getTemplates(){
		$templates = array();
		foreach(mop::config('objects', '//template') as $template){
			$entry = array();
			$entry['templateName'] = $template->getAttribute('name');	
			$entry['label'] = $template->getAttribute('name').' label';	
			$entry['nodeType'] = $template->getAttribute('nodeType');	
			$entry['contentType'] = $template->getAttribute('contentType');	
			$templates[] = $entry;
		}
		return $templates;
	}
		
}

?>
