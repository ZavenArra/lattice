<?

class Controller_Builder extends Controller {

	private $newObjectIds = array();

  public function __construct(){
		$this->rootNodeObjectType = Kohana::config('cms.graphRootNode');
	}

	public function destroy($dir) {
		$mydir = opendir($dir);
		while(false !== ($file = readdir($mydir))) {
			if($file != "." && $file != "..") {
	//			chmod($dir.$file, 0777);
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

		$db = Database::instance();
		$db->query(Database::DELETE, 'delete from objects');
		$db->query(Database::UPDATE, 'alter table objects AUTO_INCREMENT = 1');
		$db->query(Database::DELETE, 'delete from contents');
		$db->query(Database::UPDATE, 'alter table contents AUTO_INCREMENT = 1');
		$db->query(Database::DELETE, 'delete from objecttypes');
		$db->query(Database::UPDATE, 'alter table objecttypes AUTO_INCREMENT = 1');
    $db->query(Database::DELETE, 'delete from objectmaps');
		$db->query(Database::UPDATE, 'alter table objectmaps AUTO_INCREMENT = 1');
		flush();
		ob_flush();

		//clean out media dir
		$this->destroy('application/media/');
		
		//reinitialize the graph
		Graph::configureTemplate($this->rootNodeObjectType);
		Graph::addRootNode($this->rootNodeObjectType);

		if($xmlFile != 'data'){
			//then we are loading an export
			$xmlFile = 'application/export/'.$xmlFile.'/'.$xmlFile.'.xml';
		}
		echo "\nInserting Data\n";
		$this->insertData($xmlFile );

		mopcms::regenerateImages();

    //and run frontend
		echo "\n Regenerating Fronted";
    $this->action_frontend();

	}

  public function action_frontend(){
    $frontend = new Builder_Frontend();
    $frontend->index();

  }

  public function action_addData($xmlFile, $secondaryRootNodeObjectType=null){

		if($secondaryRootNodeObjectType && !$parentId = Graph::getRootNode($secondaryRootNodeObjectType)){
			Graph::configureTemplate($secondaryRootNodeObjectType);
			Graph::addRootNode($secondaryRootNodeObjectType);
			$parentObject = Graph::getRootNode($secondaryRootNodeObjectType);
		} else {
			$parentObject = Graph::getRootNode($this->rootNodeObjectType);
		}


		$this->insertData($xmlFile, $parentObject->id);	

		mopcms::generateNewImages($this->newObjectIds);
	}



	public function insertData($xmlFile, $parentId = null, $context=null){
		if($parentId == null){
			$parentObject = Graph::getRootNode($this->rootNodeObjectType);
		} else {
			$parentObject = Graph::object($parentId);
		}
 

		foreach(mop::config($xmlFile, 'item', $context)  as $item){
			$lists = array();
			if(!$item->getAttribute('objectTypeName')){
				echo $item->tagName;
            die("No objecttypename specified for Item ".$item->tagName."\n\n");
			}
      //echo "\n found contentnod ".$item->getAttribute('objectTypeName');
			flush();
			ob_flush();
			$object = ORM::Factory('object');
			$objectType = ORM::Factory('objecttype', $item->getAttribute('objectTypeName'));
			if($objectType->nodeType == 'container'){
			//	die("Can't add list family as objectType name in data.xml: {$objectType->objecttypename} \n");
			}

      //echo ')))'.$item->getAttribute('objectTypeName');
			$data = array();
			foreach(mop::config($xmlFile, 'field', $item ) as $content){
				$field = $content->getAttribute('name');
				//echo 'This Fielad '.$field."\n\n";
				switch($field){
				case 'title':
					$data[$field] = $content->nodeValue;	
					continue(2);
				case 'slug':
					$data[$field] = $content->nodeValue;	
					$data['decoupleSlugTitle'] = 1;
					continue(2);
				default:
					$data[$field] = $content->nodeValue;
					break;
				}


				//need to look up field and switch on field type	
				$fieldInfo = mop::config('objects', sprintf('//objectType[@name="%s"]/elements/*[@field="%s"]', $item->getAttribute('objectTypeName'), $content->getAttribute('name')))->item(0);
				if(!$fieldInfo){
					die("Bad field in data/objects!\n". sprintf('//objectType[@name="%s"]/elements/*[@field="%s"]', $item->getAttribute('objectTypeName'), $content->getAttribute('name')));
				}

				//special setup based on field type
				switch($fieldInfo->tagName){
				case 'file':
				case 'image':
						$path_parts = pathinfo($content->nodeValue);
						$savename = mopcms::makeFileSaveName($path_parts['basename']);	
						if(file_exists($content->nodeValue)){
							copy(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).$content->nodeValue, Graph::mediapath($savename).$savename);
						} else {
							if($content->nodeValue){
								echo "File does not exist {$content->nodeValue} \n";
								die();
							}
						}
						$data[$field] = $savename;
						break;
				default:
						$data[$field] = $content->nodeValue;
						break;
				}

			}
			$data['published'] = true;
			

			foreach(mop::config($xmlFile, 'object', $item) as $object){
				$clusterData = array();
				foreach(mop::config($xmlFile, 'field', $object) as $clusterField){
					$clusterData[$clusterField->getAttribute('name')] = $clusterField->nodeValue;
				}
				$data[$object->getAttribute('name')] = $clusterData;
			}


			//now we check for a title collision
			//if there is a title collision, we assume that this is a component
			//already added at the next level up, in this case we just
			//update the objects data
			$existing = ORM::Factory('object')
				->where('parentId', '=', $parentObject->id)
				->find_all();
			$component = null;
			foreach($existing as $aComponent){
				//echo "\n\n".$aComponent->contenttable->title;
        if(isset($data['title'])){
          if($aComponent->contenttable->title == $data['title']){
            $component = $aComponent;	
            break;
          }
        }
			}
			if($component){
				$component->updateWithArray($data);
				$objectId = $component->id;
			} else {
				$objectId = $parentObject->addObject($item->getAttribute('objectTypeName'), $data);
				$this->newObjectIds[] = $objectId;
			}

			//do recursive if it has children
			if(mop::config($xmlFile, 'item', $item)->length ){
				$this->insertData($xmlFile, $objectId,  $item);
			}

			foreach(mop::config($xmlFile, 'list', $item) as $list){
				//echo "FOUND A LIST\n\n";
				//find the container
				$listT = ORM::Factory('objectType', $list->getAttribute('family'));
				$container = ORM::Factory('object')
					->where('parentId', '=', $objectId)
					->where('objecttype_id', '=',  $listT->id)
					->find();
				//jump down a level to add object
				$this->insertData($xmlFile, $container->id, $list);
			}

		}

	}

}
