<?

class Controller_Builder extends Controller {

  private $newObjectIds = array();

  public function __construct(){

    if(!latticeutil::checkRoleAccess('superuser') && PHP_SAPI != 'cli' ){
      die('Only superuser can access builder tool');
    }

    $this->rootNodeObjectType = Kohana::config('cms.graphRootNode');

  }

  public function destroy($dir) {
    $mydir = opendir($dir);
    while(false !== ($file = readdir($mydir))) {
      if($file != "." && $file != "..") {
        //   chmod($dir.$file, 0777);
        if(is_dir($dir.$file)) {
          chdir('.');
          destroy($dir.$file.'/');
          rmdir($dir.$file) or DIE("couldn't delete $dir$file<br />");
        }
        else
          unlink($dir.$file) or DIE("couldn't delete $dir$file<br />");
      }
    }
    closedir($mydir);
  }

  public function action_initializeSite($xmlFile='data'){

    $mtime = microtime();
    $mtime = explode(' ', $mtime);
    $mtime = $mtime[1] + $mtime[0];
    $starttime = $mtime;


    if(Kohana::config('lattice.live')){
      die('builder/initializeSite is disabled on sites marked live');
    }

    $db = Database::instance();
    $db->query(Database::DELETE, 'delete from objects');
    $db->query(Database::UPDATE, 'alter table objects AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from contents');
    $db->query(Database::UPDATE, 'alter table contents AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from objecttypes');
    $db->query(Database::UPDATE, 'alter table objecttypes AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from objectmaps');
    $db->query(Database::UPDATE, 'alter table objectmaps AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from objectrelationships');
    $db->query(Database::UPDATE, 'alter table objectrelationships AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from objectelementrelationships');
    $db->query(Database::UPDATE, 'alter table objectelementrelationships AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from rosettas');
    $db->query(Database::UPDATE, 'alter table rosettas AUTO_INCREMENT = 1');
    flush();
    ob_flush();

    //clean out media dir
    $this->destroy('application/media/');

    //reinitialize the graph
    Graph::configureObjectType($this->rootNodeObjectType);
    Graph::addRootNode($this->rootNodeObjectType);

    if($xmlFile != 'data'){
      //then we are loading an export
      $xmlFile = 'application/export/'.$xmlFile.'/'.$xmlFile.'.xml';
    }
    echo "\nInserting Data\n";
    $this->insertData($xmlFile, NULL, lattice::config($xmlFile, 'nodes')->item(0) );

    latticecms::regenerateImages();

    $this->insertRelationships($xmlFile);

    //and run frontend
    echo "\n Regenerating Frontend";
    $this->action_frontend();


    $memoryUseFollowingAction = memory_get_usage(true);

    $mtime = microtime();
    $mtime = explode(" ", $mtime);
    $mtime = $mtime[1] + $mtime[0];
    $endtime = $mtime;
    $totaltime = ($endtime - $starttime);
    echo '<!-- initializeSite took ' .$totaltime. ' seconds, and completed with memory usage of '.$memoryUseFollowingAction;
    echo 'done';

  }

  public function insertRelationships($xmlFile){

    $lattices = lattice::config($xmlFile, 'relationships/lattice');
    foreach($lattices as $latticeDOM){
      $lattice = Graph::lattice($latticeDOM->getAttribute('name'));
      $relationships = lattice::config($xmlFile, 'relationship', $latticeDOM);
      foreach($relationships as $relationship){
        $parentSlug = $relationship->getAttribute('parent');  
        $childSlug = $relationship->getAttribute('child');  
        //echo 'Adding lattice relationship';
        $parent = Graph::object($parentSlug)->addLatticeRelationship($lattice, $childSlug);
      }
      unset($relationships);
    }
    unset($lattices);
  }

  public function action_frontend(){
    $frontend = new Builder_Frontend();
    $frontend->index();

  }

  public function action_addData($xmlFile, $secondaryRootNodeObjectType=null){

    if($secondaryRootNodeObjectType && !$parentId = Graph::getRootNode($secondaryRootNodeObjectType)){
      Graph::configureObjectType($secondaryRootNodeObjectType);
      Graph::addRootNode($secondaryRootNodeObjectType);
      $parentObject = Graph::getRootNode($secondaryRootNodeObjectType);
    } else {
      $parentObject = Graph::getRootNode($this->rootNodeObjectType);
    }

    $xmlFile = 'application/export/'.$xmlFile.'/'.$xmlFile.'.xml';

    $this->insertData($xmlFile, $parentObject->id, lattice::config($xmlFile, 'nodes')->item(0) ); 

    $this->insertRelationships($xmlFile);

    latticecms::generateNewImages($this->newObjectIds);
  }



  public function insertData($xmlFile, $parentId = null, $context=null){
    if($parentId == null){
      $parentObject = Graph::getRootNode($this->rootNodeObjectType);
    } else {
      $parentObject = Graph::object($parentId);
    }


    $items = lattice::config($xmlFile, 'item', $context);
    foreach($items as $item){

      if(!$item->getAttribute('objectTypeName')){
        //echo $item->tagName;
        throw new Kohana_Exception("No objecttypename specified for Item " . $item->tagName);
      }


      $object = Graph::instance();
      $objectType = ORM::Factory('objecttype', $item->getAttribute('objectTypeName'));

      $data = array();
      $clustersData = array();
      $fields = lattice::config($xmlFile, 'field', $item );
      foreach($fields as $content){
        $field = $content->getAttribute('name');

        switch ($field) {
        case 'title':
          case 'published':
            $data[$field] = $content->nodeValue;
            continue(2);
          case 'slug':
            $data[$field] = $content->nodeValue;
            $data['decoupleSlugTitle'] = 1;
            continue(2);
        }


        //need to look up field and switch on field type 
        $fieldInfo = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $item->getAttribute('objectTypeName'), $content->getAttribute('name')))->item(0);
        if (!$fieldInfo) {
          throw new Kohana_Exception("Bad field in data/objects!\n" . sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $item->getAttribute('objectTypeName'), $content->getAttribute('name')));
        }

        //if an element is actually an object, prepare it for insert/update
        if (lattice::config('objects', sprintf('//objectType[@name="%s"]', $fieldInfo->tagName))->length > 0) {
          //we have a cluster..               
          $clusterData = array();
          foreach (lattice::config($xmlFile, 'field', $content) as $clusterField) {
            $clusterData[$clusterField->getAttribute('name')] = $clusterField->nodeValue;
          }

          $clustersData[$field] = $clusterData;
          //have to wait until object is inserted to respect translations
          //echo 'continuing';
          continue;
        }


        //special setup based on field type
        switch ($fieldInfo->tagName) {
        case 'file':
          case 'image':
            $path_parts = pathinfo($content->nodeValue);
            $savename = Model_Object::makeFileSaveName($path_parts['basename']);
            if (file_exists($content->nodeValue)) {
              copy(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . $content->nodeValue, Graph::mediapath($savename) . $savename);
              $data[$field] = $savename;
            } else {
              if($content->nodeValue){
                throw new Kohana_Exception( "File does not exist {$content->nodeValue} ");
              }
            }
            break;
          default:
            $data[$field] = $content->nodeValue;
            break;
        }

      }
      //now we check for a title collision
      //if there is a title collision, we assume that this is a component
      //already added at the next level up, in this case we just
      //update the objects data
      $component = false;
      if(isset($data['title']) && $data['title']){
        $preexistingObject = Graph::object()
          ->latticeChildrenFilter($parentObject->id)
          ->join('contents', 'LEFT')->on('objects.id',  '=', 'contents.object_id')
          ->where('title', '=', $data['title'])
          ->find();
        if($preexistingObject->loaded()){
          $component = $preexistingObject;
          //echo 'Found prexisting component: '.$preexistingObject->objecttype->objecttypename;
        }
      }

      //check for pre-existing object as list container
      //echo sprintf('//objectType[@name="%s"]/elements/list', $parentObject->objecttype->objecttypename);
      foreach(lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list', $parentObject->objecttype->objecttypename)) as $listContainerType){
        $preexistingObject = Graph::object()
          ->latticeChildrenFilter($parentObject->id)
          ->objectTypeFilter($listContainerType->getAttribute('name'))
          ->find();
        if($preexistingObject->loaded() && $preexistingObject->objecttype->objecttypename == $item->getAttribute('objectTypeName') ){
          //echo 'Found prexisting list container: '.$preexistingObject->objecttype->objecttypename .' '.$item->getAttribute('objectTypeName');
          $component = $preexistingObject;
        }
      }


      if($component){
        //echo 'Updating Object '.$component->objecttype->objecttypename."\n";
        //print_r($data);
        $component->updateWithArray($data);
        $objectId = $component->id;
      } else {
        //actually add the object
        //echo 'Adding Object '.$item->getAttribute('objectTypeName')."\n";
        //print_r($data);
        $objectId = $parentObject->addObject($item->getAttribute('objectTypeName'), $data);
        $this->newObjectIds[] = $objectId;
      }

      //and now update with elementObjects;
      if(count($clustersData)){
        $object = Graph::object($objectId);
        //echo "Updating clusters\n";
        $object->updateWithArray($clustersData);
      }


      //do recursive if it has children
      if(lattice::config($xmlFile, 'item', $item)->length ){
        $this->insertData($xmlFile, $objectId,  $item);
      }

      $lists = lattice::config($xmlFile, 'list', $item);
      foreach($lists as $list){
        //find the container
        $container = Graph::object()
          ->latticeChildrenFilter($objectId)
          ->objectTypeFilter($list->getAttribute('name'))
          ->find();

        //jump down a level to add object
        $this->insertData($xmlFile, $container->id, $list);
      }
      unset($lists);

    }
    unset($items);

  }


  public function action_regenerateImages(){
    try {
      latticecms::regenerateImages();
    } catch(Exception $e){
      print_r($e->getMessage() . $e->getTrace());
    }
    echo 'Done';
    flush();
    ob_flush();
  }

}
