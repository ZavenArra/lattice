<?

class dumper_Controller extends Controller {


  public function __construct(){
		if(!is_writable('application/views/xmldumps/')){
		//	die('application/views/xmldumps/ must be writable');
		}
	}

  private function getObjectFields($object){
    $fields = array();
    $content = $object->getContent();
    foreach($content as $key=>$value){
      if($key=='templateName'){
        continue;
      }
      $field = $this->doc->createElement($key);
      //print_r($value);
      if(is_array($value)){

      } else if(is_object($value)){
        switch(get_class($value)){
        case 'File_Model':
          //or copy to directory and just use filename
					if($value->fullpath){
						$field->appendChild( $this->doc->createTextNode($value->fullpath));
					}
          break;
        case 'Page_Model':
          foreach($this->getObjectFields($value) as $subField){
            $field->appendChild($subField);
          }
          break;
        }
      } else {
        $field->appendChild( $this->doc->createTextNode($value));
      }
      $fields[] = $field;
    }
    return $fields;
  }

  private function getObjectFieldsMOPFormat($object){
    $fields = array();
    $content = $object->getContent();
    foreach($content as $key=>$value){
      if($key=='templateName' || $key == 'dateadded'){
        continue;
      }
			if($key=="slug" && $value=""){
				continue;
			}
      $field = $this->doc->createElement('field');
			$fieldAttr = $this->doc->createAttribute('name');
			$fieldValue = $this->doc->createTextNode($key);
			$fieldAttr->appendChild($fieldValue);
			$field->appendChild($fieldAttr);
      //print_r($value);
      if(is_array($value)){

      } else if(is_object($value)){
        switch(get_class($value)){
        case 'File_Model':
          //or copy to directory and just use filename
					if($value->fullpath){
						$field->appendChild( $this->doc->createTextNode($value->fullpath));
					}
          break;
        case 'Page_Model':
          foreach($this->getObjectFields($value) as $subField){
            //$field->appendChild($subField);
						echo "sub objects not yet supported for mop export\n";
          }
          break;
        }
      } else {
        $field->appendChild( $this->doc->createTextNode($value));
      }
      $fields[] = $field;
    }
    return $fields;
  }

  private function exportTier($objects){

    $nodes = array();
    foreach($objects as $object){
      $item = $this->doc->createElement($object->template->templatename);

      foreach($this->getObjectFields($object) as $field){
        $item->appendChild($field);
      }

      //and get the children
      $childObjects = ORM::Factory('object')
        ->where('activity IS NULL')
        ->where('published = 1')
        ->where('parentid', $object->id)
        ->find_all();
      foreach($this->exportTier($childObjects) as $childItem){
        $item->appendChild($childItem);
      }
      $nodes[] = $item;
    }

    return $nodes;
  }

  private function exportTierMOPFormat($objects){

    $nodes = array();
    foreach($objects as $object){
      $item = $this->doc->createElement('item');
			$templateAttr = $this->doc->createAttribute('templateName');
			$templateValue = $this->doc->createTextNode($object->template->templatename);
			$templateAttr->appendChild($templateValue);
			$item->appendChild($templateAttr);

      foreach($this->getObjectFieldsMOPFormat($object) as $field){
        $item->appendChild($field);
      }

      //and get the children
      $childObjects = ORM::Factory('object')
        ->where('activity IS NULL')
        ->where('published = 1')
        ->where('parentid', $object->id)
        ->find_all();
      foreach($this->exportTierMOPFormat($childObjects) as $childItem){
        $item->appendChild($childItem);
      }
      $nodes[] = $item;
    }

    return $nodes;
  }


	public function exportMOPFormat($xslt=''){
		//get directory listing of application/media

    $this->doc = new DOMDocument('1.0', 'UTF-8');
    $this->doc->formatOutput = true;
		$data = $this->doc->createElement('data');

    $objects = ORM::Factory('object')
      ->where('activity IS NULL')
      ->where('published', 1)
      ->where('parentid', 0)
      ->find_all();

    foreach($this->exportTierMOPFormat($objects) as $item){
      $data->appendChild($item);
    }
		$this->doc->appendChild($data);
    

    $this->doc->save('application/media/export.xml');

	}


	public function export($xslt=''){
		//get directory listing of application/media

    $this->doc = new DOMDocument('1.0', 'UTF-8');
    $this->doc->formatOutput = true;
		$data = $this->doc->createElement('data');

    $objects = ORM::Factory('object')
      ->where('activity IS NULL')
      ->where('published', 1)
      ->where('parentid', 0)
      ->find_all();

    foreach($this->exportTier($objects) as $item){
      $data->appendChild($item);
    }
    
		$this->doc->appendChild('data');
    $this->doc->save('application/media/export.xml');

    exit;
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
					die("Bad field in builder!\n". sprintf('//template[@name="%s"]/elements/*[@field="%s"]', $item->getAttribute('templateName'), $content->tagName));
				}
        //echo "\ntagname\t".$fieldInfo->tagName."\n";

				//special setup based on field type
				switch($fieldInfo->tagName){
				case 'file':
				case 'image':
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
			$existing = ORM::Factory('object')
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
				$component->updateWithArray($data);
				$objectId = $component->id;
			} else {
				$objectId = cms::addObject($parentId, $item->getAttribute('templateName'), $data);
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
				$container = ORM::Factory('object')
					->where('parentid', $objectId)
					->where('template_id', $listT->id)
					->find();
				//jump down a level to add object
				$this->insertData($xmlFile, $container->id, $list);
			}

		}

		//and regenerate all files
	}

}
