<?

class BuildData_Controller extends Controller {

	public function index(){
		$this->insertData();
	}
	public function insertData($parentId = 0, $prefix = '/data/'){
    echo 'inserting '.$prefix;

		foreach(mop::config('data', $prefix.'item')  as $item){
      echo 'found contentnode';
			flush();
			ob_flush();
			$object = ORM::Factory('page');
			$template = ORM::Factory('template', $item->getAttribute('templateName'));
      if(!$template->id){
				die("Bad template name ".$item->getAttribute('templateName')."\n");
			}
			$object->template_id = $template->id;
			$object->published = true;
			$object->parentid = $parentId;
			$object->save();
      echo ')))'.$item->getAttribute('templateName');
			//templatename IS NOT a unique identifier..
			echo count($item->childNodes);
			foreach(mop::config('data', sprintf($prefix.'item[@templateName="%s"]/*', $item->getAttribute('templateName'))) as $content){
				if($content->tagName == 'item'){
					//do nothing, catch downstairs
					continue;
				}
        $field = $content->tagName;
        if($field == 'title'){
          $object->slug = cms::createSlug($content->nodeValue);
        }
				$object->contenttable->$field = $content->nodeValue;
			}
      $object->save();
      $object->contenttable->save();

			//do recursive if it has children
      if(mop::config('backend', sprintf($prefix.'item[@templateName="%s"]/*', $item->getAttribute('templateName'))).'/item'){
        $this->insertData($object->id,  $prefix.'item/');
      }
		}
	}

}
