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
		flush();
		ob_flush();

		echo "\nInserting Data\n";
		$this->insertData();

		cms::regenerateImages();

	}
	public function insertData($parentId = 0, $context=null){

		foreach(mop::config('data', 'item', $context)  as $item){
      echo "\n found contentnod";
			flush();
			ob_flush();
			$object = ORM::Factory('page');
			$template = ORM::Factory('template', $item->getAttribute('templateName'));
      if(!$template->id){
				die("Bad template name ".$item->getAttribute('templateName')."\n");
			}

			//$object->template_id = $template->id;
			//$object->published = true;
			//$object->parentid = $parentId;
			//$object->save();
      echo ')))'.$item->getAttribute('templateName');
			$data = array();
			foreach(mop::config('data', '*', $item ) as $content){
				echo $content->tagName;
				if($content->tagName == 'item'){
					//do nothing, catch downstairs
					continue;
				}
        $field = $content->tagName;
				//need to look up field and switch on field type	
				$fieldInfo = mop::config('backend', sprintf('//template[@name="%s"]/*[@name="%s"]', $item->getAttribute('templateName'), $content->tagName));
				if(!$fieldInfo){
					die("Bad field!\n". sprintf('//template[@name="%s"]/*[@name="%s"]', $item->getAttribute('templateName'), $content->tagName));
				}
				$data[$field] = $content->nodeValue;
			}
			$data['published'] = true;
			echo 'parent'.$parentId;
			cms::addObject($parentId, $template->id, $data);

			//do recursive if it has children
      if(mop::config('data', 'item', $item) ){
        $this->insertData($object->id,  $item);
      }
		}
	}

}
