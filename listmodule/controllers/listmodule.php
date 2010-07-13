<?
/*
	Class: ListModule_Controller
	Not doing a 2nd pass on this for documentation, since it's very near to being reimplemented with
	object paradigm.
*/

class ListModule_Controller extends Controller {

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
	protected $model = 'list'; //this could dynamicaly picked depending on setup, you know



	//Ok I THINK THAT FOR NOW, GONNA NEED THE EXTRA CLASSES IN THE APPs MODULES dir


	/*
	  Function:  Constructor, 
	*/
	public function __construct(){
		parent::__construct();

		//for now the isntance is just the name of this thing
		$this->instance = strtolower(substr(get_class($this), 0, -11));

		//support for custom listmodule item templates, but might not be necessary
		$custom = $this->instance.'_listmodule_item';
		Kohana::log('info', 'listmodule: looking for '.$custom);
		if(Kohana::find_file('views', $custom)){
			$this->itemview = $custom;
		} else {
			$this->itemview = 'listmodule_item';
		}
		Kohana::log('info', 'listmodule: using listmodule item template: '.$custom);

		//get the dbmap
		$this->dbmap = Kohana::config($this->instance.'.dbmap');
		$this->fields = Kohana::config($this->instance.'.fields');
		$this->labels = Kohana::config($this->instance.'.labels');
		if(! $this->sortdirection = Kohana::config($this->instance.'.sortdirection')) {
			$this->sortdirection = Kohana::config('listmodule.sortdirection');
		}

		if(!is_array($this->dbmap)){
			throw new Kohana_User_Exception('BAD LIST SETUP', 'No dbmap for '.$this->instance);
		}
		if(!is_array($this->fields)){
			throw new Kohana_User_Exception('BAD LIST SETUP', 'No fields for '.$this->instance);
		}
		if(!is_array($this->labels)){
			throw new Kohana_User_Exception('BAD LIST SETUP', 'No labels for '.$this->instance);
		}
		
		//TODO:read the config and setupd
	}


	//createIndexView is what gets called instead of INDEX on an ajax module load
	//this is b/c index would have a call to ->toWebpage()
	public function createIndexView(){
		$custom = $this->instance.'_listmodule';
		if(Kohana::find_file('views', $custom)){
			$this->template = new View($custom);
		} else {
			$this->template = new View('listmodule');		
		}

		$this->template->label = Kohana::config($this->instance.'.modulelabel');

		$this->buildIndexData();
		return $this->render();
	}


	public function buildIndexData(){
		$templatevars = array(
			'moduleLabel',
			'moduleClass',
		);
		foreach($templatevars as $var){
			$this->template->$var = Kohana::config($this->instance.'.'.$var);
		}
		//$this->template->moduleClass =  $this->template->moduleClass . ' sortDirection-'.$this->sortdirection;
		$this->template->class =  $this->template->moduleClass . ' sortDirection-'.$this->sortdirection;

		//load out of database
		//possibley should be contained within the mode, not totally sure
		//llist=ORM::Factory('list')->find_by_page_id(CMS_Controller::getPageId(), $this->instance);
		Kohana::log('info', 'listmodule with sort: '.$this->sortdirection);
		$list = ORM::Factory($this->model)
		->where('page_id', CMS_Controller::getPageId())
		->where('instance', $this->instance)
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
			if(isset($this->dbmap) && is_array($this->dbmap)){
				foreach($this->dbmap as $formfield => $dbfield){
					$data[$formfield] = $item->$dbfield;
				}
			}
			$itemt->data = $data;

			//files and imaages
			$itemt->files = array();
			if(count(Kohana::config($this->instance.'.files'))){
				$itemt->files['file'] = $this->makeFileArgs('file', $item->file);
			}
			$itemt->singleimages = array();
			if(count(Kohana::config($this->instance.'.singleimages'))){
				$itemt->singleimages['file'] = $this->makeFileArgs('singleimage',$item->file);
			}
			$itemt->instance = $this->instance;
			$html.=$itemt->render();
		}
	
		$this->template->items = $html;
		$this->template->instance = $this->instance;
		$this->template->fields = $this->fields;
		$this->template->labels = $this->labels;
		$this->template->className = $this->template->moduleClass;

	}

	/*
	Function: saveIPE($itemid)
	Wrapper to saveIPE in CMS_Services_Controller
	*/
	//possibly all modules should just subclass CMS_Services_Controller
	public function saveIPE($itemid){
		$cmss = new CMS_Services_Controller(ORM::Factory($this->model, $itemid));
		return $cmss->saveField($this->dbmap[$_POST['field']], $_POST['value']);
	}

	public function saveFieldMapping($itemid){
		$cmss = new CMS_Services_Controller(ORM::Factory($this->model, $itemid));
		return $cmss->saveFieldMapping($_POST['field'], $_POST['value']);
	}

	//this is the new one
	public function saveField($itemid){
		return	$this->saveIPE($itemid);
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
		$cmss = new CMS_Services_Controller(ORM::Factory($this->model, $itemid));

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
				$parameters = Kohana::config($this->instance.'.singleimages.'.$_POST['field'].'.resize');
				$uiimagesize = array('uithumb'=>Kohana::config('listmodule.uiresize'));
				if($parameters){
				$parameters['imagesizes'] = array_merge($uiimagesize, $parameters['imagesizes']);
				} else {
					$parameters['imagesizes'] = $uiimagesize;
				}
				
				if($parameters){
					return $cmss->saveImage($parameters);
				} else {
					return $cmss->saveFile();
				}
				break;

			default:
				return $cmss->saveFile();
		}

		
	}

	public function saveMappedPDF($itemid){
		$cmss = new CMS_Services_Controller(ORM::Factory($this->model, $itemid));
		return $cmss->saveMappedPDF();
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
		->where('instance', $this->instance)
		->find();
		
		$item = ORM::Factory($this->model);
		$item->page_id = $pageId;
		$item->instance = $this->instance;
		$item->save();

		//save fields into item
		foreach($this->fields as $field=>$type){
			if(isset($_POST[$field])){
				$item->{$this->dbmap[$field]} = $_POST[$field];
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


		$this->template = new View($this->itemview);
		$this->template->instance = $this->instance;
		$this->template->data = $data;
		$this->template->fields = $this->fields;
		$this->template->labels = $this->labels;
		$this->template->files = array();
		if(count(Kohana::config($this->instance.'.files'))){
			$this->template->files['file'] = $this->makeFileArgs('file');
		}
		$this->template->singleimages = array();
		if(count(Kohana::config($this->instance.'.singleimages'))){
			$this->template->singleimages['file'] = $this->makeFileArgs('singleimage');
		}
		return $this->template->render();
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
		$args['extensions'] = Kohana::config($this->instance.'.'.$type.'s'.'.file'.'.extensions');
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
