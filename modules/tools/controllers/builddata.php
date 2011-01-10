<?

class build_Controller extends BuildData_Controller {

	public function initializeSite($xmlFile){

		//get directory listing of application/media
		//and unlink all files

		$db = Database::instance();
		$db->query('delete from pages');
		$db->query('alter table pages AUTO_INCREMENT = 1');
		$db->query('delete from content_larges');
		$db->query('alter table content_larges AUTO_INCREMENT = 1');
		$db->query('delete from contents');
		$db->query('alter table contents AUTO_INCREMENT = 1');
		flush();
		ob_flush();

		echo "\nInserting Data\n";
		$this->insertData($xmlFile);

		cms::regenerateImages();

    //and run frontend
    $frontend = new Frontend_Controller();
    $frontend->index();

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
      if(!$template->id){
				die("Bad template name ".$item->getAttribute('templateName')."\n");
				//or course just go ahead and insert here.
			} 
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
				case 'slug':
					$data[$field] = $content->nodeValue;	
					continue(2);
				default:
					$data[$field] = $content->nodeValue;
					break;
				}


				//need to look up field and switch on field type	
				$fieldInfo = mop::config('backend', sprintf('//template[@name="%s"]/elements/*[@field="%s"]', $item->getAttribute('templateName'), $content->getAttribute('name')))->item(0);
				if(!$fieldInfo){
					//check to see if this is a list field
					if(mop::config('backend',  sprintf('//template[@name="%s"]/elements/list[@family="%s"]', $item->getAttribute('templateName'), $content->getAttribute('name')))){
						//its a list, just  skip/continue we deal with this after the object has been inserted
						//add to array of lists to process
						$lists[] = $field;
						continue;
					}
					die("Bad field!\n". sprintf('//template[@name="%s"]/elements/*[@field="%s"]', $item->getAttribute('templateName'), $content->tagName));
				}
        //echo "\ntagname\t".$fieldInfo->tagName."\n";

				//special setup based on field type
				switch($fieldInfo->tagName){
				case 'singleFile':
				case 'singleImage':
          //echo "\nFILE: ";
						$path_parts = pathinfo($content->nodeValue);
						$savename = cms::makeFileSaveName($path_parts['basename']);	
						if(file_exists($content->nodeValue)){
							copy(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).$content->nodeValue, cms::mediapath($savename).$savename);
						} else {
							echo "File does not exist {$content->nodeValue} \n";
              die();
						}
						$data[$field] = $savename;
						break;
				case 'list':
					//echo "found a list\n";
					//skip this entirely and pick up later as child
					////this should never come throug here
										break;
				default:
						$data[$field] = $content->nodeValue;
						break;
				}

			}
			$data['published'] = true;
			//echo 'parent'.$parentId;
			//print_r($data);

			//now we check for a title collision
			//if there is a title collision, we assume that this is a component
			//already added at the next level up, in this case we just
			//update the objects data
			$existing = ORM::Factory('page')
				->where('parentid', $parentId)
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
				//echo 'COMPONENT';
				//print_r($data);
				$component->updateWithArray($data);
				$objectId = $component->id;
			} else {
				$objectId = cms::addObject($parentId, $template->id, $data);
			}

			//do recursive if it has children
			if(mop::config($xmlFile, 'item', $item)->length ){
				$this->insertData($objectId,  $item);
			}

			foreach(mop::config($xmlFile, 'list', $item) as $list){
				//echo "FOUND A LIST\n\n";
				//find the container
				$listT = ORM::Factory('template', $list->getAttribute('family'));
				$container = ORM::Factory('page')
					->where('parentid', $objectId)
					->where('template_id', $listT->id)
					->find();
				//jump down a level to add object
				$this->insertData($container->id, $list);
			}

		}

		//and regenerate all files
	}

}
