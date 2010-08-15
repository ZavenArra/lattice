<?
/*
	Class: ListModule_Controller
	Not doing a 2nd pass on this for documentation, since it's very near to being reimplemented with
	object paradigm.
*/

class List_Controller extends Controller{

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
	  Function:  construct();
	*/
	public function __construct(){
		parent::__construct();

		//for now the isntance is just the name of this thing
		$this->collectionName = strtolower(substr(get_class($this), 0, -11));

		//support for custom listmodule item templates, but might not be necessary
		$custom = $this->collectionName.'_list_item';
		Kohana::log('info', 'list: looking for '.$custom);
		if(Kohana::find_file('views', $custom)){
			$this->itemview = $custom;
		} else {
			$this->itemview = 'list_item';
		}

		//get the dbmap
		if(! $this->sortdirection = Kohana::config('cms.lists.'.$this->collectionName.'.sortdirection')) {
			$this->sortdirection = Kohana::config('list.sortdirection');
		}

		//TODO:read the config and setupd
	}


	public function createIndexView(){
		$custom = $this->collectionName.'_list';
		if(Kohana::find_file('views', $custom)){
			$this->view = new View($custom);
		} else {
			$this->view = new View('list');		
		}

		$this->view->label = Kohana::config('cms.lists.'.$this->collectionName.'.label'); //how do we know what object we are in

		$this->buildIndexData();
		return $this->render();
	}


	public function buildIndexData(){
		$this->view->label = Kohana::config('cms.lists.'.$this->collectionName.'.'.$var);
		$this->view->class =  $this->view->moduleClass . ' sortDirection-'.$this->sortdirection;

		$listMembers = ORM::Factory('page', $this->parentObjectId)->getPublishedListMembers($this->collectionName);

		Kohana::log('info', 'listmodule with sort: '.$this->sortdirection);
		$list = ORM::Factory($this->model)
		->where('page_id', CMS_Controller::getPageId())
		->where('instance', $this->collectionName)
		->where('activity IS NULL') 
		->orderBy('sortorder', $this->sortdirection)
		->find_all();
		$html = '';

		foreach($list as $item){
			//actually just call cms_services and generate all the bits there
			$itemt = new View($this->itemview);
			$itemt->fields = $this->fields;
			$itemt->labels = $this->labels;
			$data = array();
			$data['id'] = $item->id;
			$data['page_id'] = $item->page_id;
			$data['instance'] = $item->instance;
			foreach(Kohana::config('cms.dbmap.'.$item->template->templatename) as $formfield => $dbfield){
				$data[$formfield] = $item->$formfield;
			}
			$itemt->data = $data;

			//files and imaages
			$itemt->files = array();
			if(count(Kohana::config($this->collectionName.'.files'))){
				$itemt->files['file'] = $this->makeFileArgs('file', $item->file);
			}
			$itemt->singleimages = array();
			if(count(Kohana::config($this->collectionName.'.singleimages'))){
				$itemt->singleimages['file'] = $this->makeFileArgs('singleimage',$item->file);
			}
			$itemt->instance = $this->collectionName;
			$html.=$itemt->render();
		}
	
		$this->view->items = $html;
		$this->view->instance = $this->collectionName;
		$this->view->fields = $this->fields;
		$this->view->labels = $this->labels;
		$this->view->className = $this->view->moduleClass;

	}

	/*
	Function: saveIPE($itemid)
	Wrapper to saveIPE in CMS_Services_Controller
	*/
	public function saveFieldMapping($itemid){
		$object = ORM::Factory($this->model, $itemid);
		return $object->saveFieldMapping($_POST['field'], $_POST['value']);
	}

	//this is the new one
	public function saveField($itemid){
		$object = ORM::Factory($this->model, $itemid);
		return $object->saveField($_POST['field'], $_POST['value']);
	}



	/*
	Function: saveFile($itemid)
	Wrapper to saveFile in CMS_Services_Controller

	Parameters:
	$itemid - the id of the item that the file is attached to
	$_POST['field'] - the identifier of the file in this specific list instance 
	(same as a field for ipe)
	$_FILES - the uploaded file gets put here by php
	*/
	public function saveFile($itemid){
		$object = ORM::Factory($this->model, $itemid);

		//check the file extension
		$filename = $_FILES[$_POST['field']]['name'];
		$ext = substr(strrchr($filename, '.'), 1);
		switch($ext){
			case 'jpeg':
			case 'jpg':
			case 'gif':
			case 'png':
			case 'JPEG':
			case 'JPG':
			case 'GIF':
			case 'PNG':
				$parameters = Kohana::config($this->collectionName.'.singleimages.'.$_POST['field'].'.resize');
				$uiimagesize = array('uithumb'=>Kohana::config('listmodule.uiresize'));
				if($parameters){
				$parameters['imagesizes'] = array_merge($uiimagesize, $parameters['imagesizes']);
				} else {
					$parameters['imagesizes'] = $uiimagesize;
				}
				
				if($parameters){
					return $object->saveImage($_POST['field'], $_FILES, $parameters);
				} else {
					return $cmss->saveFile($_POST['field'], $_FILES);
				}
				break;

			default:
				return $cmss->saveFile($_POST['field'], $_FILES);
		}

		
	}

	public function saveMappedPDF($itemid){
		$object = ORM::Factory($this->model, $itemid);
		return $object->saveMappedPDF();
	}

	/*
	Function: addItem()
	Adds a list item

	Returns:
	the rendered template of the new item
	*/
	public function addItem($pageId){
		//read config, make the item, load template
		//config must load instance somehow
		$sort = ORM::Factory($this->model)
		->select('max(sortorder)+1 as newsort')
		->where('instance', $this->collectionName)
		->find();

		//insert the collection record if it does not exist already
		$collection = ORM::Factory('collection')
			->where('collectionName', $this->collectionName)
			->find();
		if(!$collection->loaded){
			$collection = ORM::Factory('collection');
			$collection->collectionName = $this->collectionName;
			$collection->save();
		}
		
		$item = ORM::Factory($this->model);
		$item->page_id = $pageId;
		$item->collection_id = $collection->id;
		$item->save();

		//save fields into item
		foreach($this->fields as $field=>$type){
			if(isset($_POST[$field])){
				$item->$field = $_POST[$field];
			}
		}
		$item->sortorder = $sort->newsort;
		$item->save();

		//and get data
		$data = array();
		$data['id'] = $item->id;
		$data['page_id'] = $item->page_id;
		$data['instance'] = $item->instance;
		foreach($this->dbmap as $formfield => $dbfield){
			$data[$formfield] = $item->$dbfield;
		}


		$this->view = new View($this->itemview);
		$this->view->instance = $this->collectionName;
		$this->view->data = $data;
		$this->view->fields = $this->fields;
		$this->view->labels = $this->labels;
		$this->view->files = array();
		if(count(Kohana::config($this->collectionName.'.files'))){
			$this->view->files['file'] = $this->makeFileArgs('file');
		}
		$this->view->singleimages = array();
		if(count(Kohana::config($this->collectionName.'.singleimages'))){
			$this->view->singleimages['file'] = $this->makeFileArgs('singleimage');
		}
		return $this->view->render();
	}

	public function makeFileArgs($type, $id=null){
		$maxlength = ini_get('upload_max_filesize');
		if(!strpos($maxlength, 'M')){
			throw new Kohana_User_Exception('invalid upload_max_filesize', 'invalid upload_max_filesize');
		}

		$maxlength = substr($maxlength, 0, -1) * 1024 *1024;
		$args = array();
		$args['id']=null;
		$args['ext'] = '';
		$args['maxlength'] = $maxlength;
		$args['extensions'] = Kohana::config($this->collectionName.'.'.$type.'s'.'.file'.'.extensions');
		if($id==null){
			return $args;
		}	
		$file = ORM::Factory('file')->where('id', $id)->find(); //why is this find necessary?
		if($file->loaded==true){
			$args['id'] = $id; 
			$parse = explode('.', $file->filename);
			$args['ext'] = $parse[count($parse)-1];
			$args['filename'] = $file->filename;
			$thumbSrc = 'uithumb_'.$file->filename;
			if(!file_exists('staging/application/media/'.$thumbSrc)){
				$thumbSrc = $file->filename;
			} 
			$args['thumbSrc'] = $thumbSrc;
			$size = @getimagesize($thumbSrc);
			$args['width'] = $size[0];
			$args['height'] = $size[1];
		} 
		return $args;
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

	/*
	Function: saveSortOrder
	Saves sort order of some ids
	This is a candidate for going into cms_services, with generalization

	Parameters:
	$_POST['sortorder'] - comma delineated string of ids
	*/
	public function saveSortOrder(){
		$order = explode(',', $_POST['sortorder']);

		for($i=0; $i<count($order); $i++){
			if(!is_numeric($order[$i])){
				throw new Kohana_User_Exception('bad sortorder string', 'bad sortorder string');
			}
			$item = ORM::factory($this->model, $order[$i]);
			$item->sortorder = $i+1;
			$item->save();
		}

	}
}

?>
