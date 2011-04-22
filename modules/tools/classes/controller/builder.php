<?

class Controller_Builder extends Controller {

	private $newObjectIds = array();

  public function __construct(){
		if(!is_writable('application/views/generated/')){
			die('application/views/generated/ must be writable');
		}
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
		//get directory listing of application/media
		//and unlink all files

		$db = Database::instance();
		$db->query(Database::DELETE, 'delete from pages');
		$db->query(Database::UPDATE, 'alter table pages AUTO_INCREMENT = 1');
		$db->query(Database::DELETE, 'delete from contents');
		$db->query(Database::UPDATE, 'alter table contents AUTO_INCREMENT = 1');
		$db->query(Database::DELETE, 'delete from templates');
		$db->query(Database::UPDATE, 'alter table templates AUTO_INCREMENT = 1');
		flush();
		ob_flush();

		//clean out media dir
		$this->destroy('application/media/');
		$this->destroy('staging/application/media/');
		

		echo "\nInserting Data\n";
		$this->insertData($xmlFile);

		mopcms::regenerateImages();

    //and run frontend
		echo "\n Regenerating Fronted";
    $frontend = new Builder_Frontend();
    $frontend->index();

	}

  public function addData($xmlFile){
		$this->insertData($xmlFile);	

		cms::generateNewImages($this->newObjectIds);
	}



	public function insertData($xmlFile, $parentId = 0, $context=null){

		foreach(mop::config($xmlFile, 'item', $context)  as $item){
			$lists = array();
			if(!$item->getAttribute('templateName')){
				echo $item->tagName;
        die("No templatename specified for Item ".$item->tagName."\n\n");
			}
      //echo "\n found contentnod ".$item->getAttribute('templateName');
			flush();
			ob_flush();
			$object = ORM::Factory('page');
			$template = ORM::Factory('template', $item->getAttribute('templateName'));
			if($template->nodeType == 'container'){
				die("Can't add list family as template name in data.xml: {$template->templatename} \n");
			}

      //echo ')))'.$item->getAttribute('templateName');
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
				$fieldInfo = mop::config('objects', sprintf('//template[@name="%s"]/elements/*[@field="%s"]', $item->getAttribute('templateName'), $content->getAttribute('name')))->item(0);
				if(!$fieldInfo){
					die("Bad field in data/objects!\n". sprintf('//template[@name="%s"]/elements/*[@field="%s"]', $item->getAttribute('templateName'), $content->getAttribute('name')));
				}
        //echo "\ntagname\t".$fieldInfo->tagName."\n";

				//special setup based on field type
				switch($fieldInfo->tagName){
				case 'file':
				case 'image':
						$path_parts = pathinfo($content->nodeValue);
						$savename = mopcms::makeFileSaveName($path_parts['basename']);	
						if(file_exists($content->nodeValue)){
							copy(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).$content->nodeValue, mopcms::mediapath($savename).$savename);
						} else {
							echo "File does not exist {$content->nodeValue} \n";
              die();
						}
						$data[$field] = $savename;
						break;
				default:
						$data[$field] = $content->nodeValue;
						break;
				}

			}
			$data['published'] = true;
			//echo 'parent'.$parentId;
			//print_r($data);


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
			$existing = ORM::Factory('page')
				->where('parentid', '=', $parentId)
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
				$objectId = mopcms::addObject($parentId, $item->getAttribute('templateName'), $data);
				$this->newObjectIds[] = $objectId;
			}

			//do recursive if it has children
			if(mop::config($xmlFile, 'item', $item)->length ){
				$this->insertData($xmlFile, $objectId,  $item);
			}

			foreach(mop::config($xmlFile, 'list', $item) as $list){
				//echo "FOUND A LIST\n\n";
				//find the container
				$listT = ORM::Factory('template', $list->getAttribute('family'));
				$container = ORM::Factory('page')
					->where('parentid', '=', $objectId)
					->where('template_id', '=',  $listT->id)
					->find();
				//jump down a level to add object
				$this->insertData($xmlFile, $container->id, $list);
			}

		}

		//and regenerate all files
	}

}
