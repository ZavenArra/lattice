<?
/**
 * Class: Navigation_Controller 
 *
 *
 */

class Controller_Navigation extends Controller_Lattice{

  private $defaultAddCategoryText = '';
  private $defaultAddLeafText = '';

  public function __construct($request, $response){
    parent::__construct($request, $response);
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
      ->order_by('objectrelationships.sortorder', 'ASC');
    $items = $items->find_all();

    if($items){
      $sendItemContainers = array(); //these will go first
      $sendItemObjects = array();
      foreach($items as $child){
        if(strtolower($child->objecttype->nodeType) == 'container'){
          //we might be skipping this node
          $display = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list[@name="%s"]', 
            $parent->objecttype->objecttypename,
            $child->objecttype->objecttypename))
            ->item(0);
          if(!is_object($display)){
            //this child object doesn't match a configured list
            continue;
          }
          $display = $display->getAttribute('display');

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
          $childTier = $this->getTier($child->id, $deeplinkPath, $follow_tier);
          if ($follow_tier == true) {
            $sendItem['follow'] = true;
            $follow = 'true';
          }
          $sendItem['tier'] = $childTier;
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
      if($parent->id == Graph::getRootNode(Kohana::config('cms.graphRootNode'))->id ){
        $cmsModules = lattice::config('cmsModules', '//module');
        foreach($cmsModules as $m){
          $controller = $m->getAttribute('controller');
          $roles = Kohana::config(strtolower($controller).'.authrole', FALSE, FALSE); 
          $accessGranted = latticeutil::checkAccess($roles);
          if(!$accessGranted){
            continue;
          }

          $entry = array();
          $entry['id'] = $m->getAttribute('controller');
          $entry['slug'] = $m->getAttribute('controller');
          $entry['nodeType'] = 'module';
          $entry['contentType'] = 'module';
          $entry['title'] = $m->getAttribute('label');
          $sendItemObjects[] = $entry;
        }
      }
      $html = $this->renderTierView($parent, $sendItemObjects);
      $tier = array(
        'nodes' => $sendItemObjects,
        'html' => $html
      );
      return $tier;
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
        $parent = $object->getLatticeParent();
        if($parent){
          $objectId = $parent->id;
        } else {
          $objectId = NULL;
        } 
      }
      $deeplinkPath = array_reverse($deeplinkPath);

    }

    //this database call happens twice, should be a class variable?
    $parent = Graph::object($parentId);


    $tier = $this->getTier($parentId, $deeplinkPath);


    $this->response->data(array('tier' => $tier));

  }

  private function renderTierView($parent, $nodes){

    $tierView = new View('navigationTier');
    $nodesHtml = array();
    foreach($nodes as $node){
      $nodeView = new View('navigationNode');
      $nodeView->content = $node; 
      $nodesHtml[] = $nodeView->render();
    }
    $tierView->nodes = $nodesHtml;

    $tierMethodsDrawer = new View('tierMethodsDrawer');
    $addableObjects = $parent->objecttype->addableObjects;

    if(latticeutil::checkAccess('superuser')){
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
    foreach(lattice::config('objects', '//objectType') as $objectType){
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
