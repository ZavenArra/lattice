<?

class BuildData_Controller extends Controller {

	public function index(){

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
		$this->insertData();

		cms::regenerateImages();

	}
	public function insertData($parentId = 0, $context=null){

		foreach(mop::config('data', 'item', $context)  as $item){
      echo "\n found contentnod ".$item->getAttribute('templateName');
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

			//$object->template_id = $template->id;
			//$object->published = true;
			//$object->parentid = $parentId;
			//$object->save();
      echo ')))'.$item->getAttribute('templateName');
			$data = array();
			foreach(mop::config('data', '*', $item ) as $content){
				echo 'Field'.$content->tagName."\n";
				switch($content->tagName){
				case 'item':
					//do nothing, catch later
					continue(2);
				case 'title':
				case 'slug':
					$data[$content->tagName] = $content->nodeValue;	
					continue(2);
				default:
					break;
				}


        $field = $content->tagName;
				//need to look up field and switch on field type	
				$fieldInfo = mop::config('backend', sprintf('//template[@name="%s"]/elements/*[@field="%s"]', $item->getAttribute('templateName'), $content->tagName))->item(0);
				if(!$fieldInfo){
					die("Bad field!\n". sprintf('//template[@name="%s"]/elements/*[@field="%s"]', $item->getAttribute('templateName'), $content->tagName));
				}

				//special setup based on field type
				switch($fieldInfo->tagName){
				case 'singleFile':
				case 'singleImage':
						$path_parts = pathinfo($content->nodeValue);
						$savename = cms::makeFileSaveName($path_parts['basename']);	
						if(file_exists($content->nodeValue)){
							copy($content->nodeValue, cms::mediapath($savename).$savename);
						} else {
							echo "File does not exist {$content->nodeValue} \n";
						}
						$data[$field] = $savename;
						break;
				default:
						$data[$field] = $content->nodeValue;
						break;
				}

			}
			$data['published'] = true;
			echo 'parent'.$parentId;
			print_r($data);
			$objectId = cms::addObject($parentId, $template->id, $data);

			//do recursive if it has children
      if(mop::config('data', 'item', $item) ){
        $this->insertData($objectId,  $item);
      }
		}

		//and regenerate all files
	}

}
