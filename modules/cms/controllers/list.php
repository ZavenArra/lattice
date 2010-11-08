<?
/*
	Class: ListModule_Controller
	Not doing a 2nd pass on this for documentation, since it's very near to being reimplemented with
	object paradigm.
*/

class List_Controller extends CMS_Interface_Controller{

	/*
	*  Variable: page_id
	*  static int the global page id when operating within the CMS submodules get the page id
	*  we could just reference the primaryId attribute of Display as well...
	*/
	private static $page_id = NULL;


	/*
	Variable: model
	Main model for items content managed by this class
	*/
	protected $model = 'page'; 

	/*
	 * Variable: containerObject
	 * The parent object of the lists children
	 */
	protected $containerObject;


	/*
	  Function:  construct();
		Parameters:
			containerObject - The object that contains the items for the list.  This should not be null, 
			 but we allow it for call_user_func_array workaround
	*/
	public function __construct($containerObject = null){
		parent::__construct();

		$this->containerObject = $containerObject;

		//for now the isntance is just the name of this thing
		$this->listClass = substr(get_class($this), 0, -11);

		//support for custom listmodule item templates, but might not be necessary
		$custom = $this->listClass.'_list_item';
		Kohana::log('info', 'list: looking for '.$custom);
		if(Kohana::find_file('views', $custom)){
			$this->itemview = $custom;
		} else {
			$this->itemview = 'list_item';
		}

		//get the dbmap
		$this->sortdirection = mop::config('objects', sprintf('//list[@family="%s"]', $this->listClass))->item(0)->getAttribute('sortDirection');

		//TODO:read the config and setupd
	}


	public function createIndexView(){
		$custom = $this->listClass.'_list';
		if(Kohana::find_file('views', $custom)){
			$this->view = new View($custom);
		} else {
			$this->view = new View('list');		
		}

		$this->buildIndexData();
		return $this->render();
	}


	public function buildIndexData(){

		$listMembers = $this->containerObject->getChildren();

		$html = '';
		foreach($listMembers as $object){

			$htmlChunks = cms::buildUIHtmlChunksForObject($object);
			$itemt = new View($this->itemview);
			$itemt->uiElements = $htmlChunks;

			$data = array();
			$data['id'] = $object->id;
			$data['page_id'] = $this->containerObject->id;
			$data['instance'] = $this->listClass;
			$itemt->data = $data;

			$html.=$itemt->render();
		}
	
    //actually we need to do an absolute path for local config
		$listConfig =  mop::config('objects', sprintf('//list[@family="%s"]', $this->listClass))->item(0);
		$this->view->label =  $listConfig->getAttribute('label');
		$this->view->class =  $listConfig->getAttribute('cssClasses');
		$this->view->class .= ' allowChildSort-'.$listConfig->getAttribute('allowChildSort');
	 	$this->view->class .= ' sortDirection-'.$this->sortdirection;
		$this->view->items = $html;
		$this->view->instance = $this->listClass;

	}
	//this is the new one
	public function savefield($itemid){
		$object = ORM::Factory($this->model, $itemid);
		$object->contenttable->$_POST['field'] = $_POST['value'];
		$object->contenttable->save();
		return array('value'=>$object->contenttable->$_POST['field']);
	}

	private function buildContainerObject($parentid){
		$parent = ORM::Factory($this->model, $parentid);
		$containerTemplate = ORM::Factory('template', $this->listClass);
		$this->containerObject = ORM::Factory($this->model)
			->where('parentid', $parentid)
			->where('template_id', $containerTemplate->id)
			->where('activity IS NULL')
			->find();
	}

	/*
	Function: addItem()
	Adds a list item

	Returns:
	the rendered template of the new item
	*/
	public function addItem($parentid){
		$parent = ORM::Factory($this->model, $parentid);
		$this->buildContainerObject($parentid);

		//addable item should be specifid in the addItem call
		$template = mop::config('objects', sprintf('//list[@family="%s"]/addableObject', $this->listClass));
    if(!$template->length > 0){
      throw new Kohana_User_Exception('No List By That Name', 'Count not locate configuration in objects.xml for '.sprintf('//list[@family="%s"]/addableobject', $this->listClass) );
    }
    $template = $template->item(0);

		$data = array('published'=>'true');

		$newid = cms::addObject($this->containerObject->id,
    $template->getAttribute('templateName'), $data);

		$item = ORM::Factory('page', $newid);
		$htmlChunks = cms::buildUIHtmlChunksForObject($item);
		$itemt = new View($this->itemview);
		$itemt->uiElements = $htmlChunks;

		$data = array();
		$data['id'] = $newid;
		$data['page_id'] = $this->containerObject->id;;
		$data['instance'] = $this->listClass;


		$itemt->data = $data;

		$html = $itemt->render();

		return $html;
	}

	/*
	Function: deleteItem()
	Deletes an item (marks as deleted, but does not remove from database. 
	also sets sortorder to 0)

	Parameters:
	$itemid - the id of thd item to delete
	*/
	public function deleteItem($itemid){
		$item = ORM::Factory($this->model, $itemid);
		$item->activity = 'D';
		$item->sortorder = 0;
		$item->save();
		return 1;

	}

}

?>
