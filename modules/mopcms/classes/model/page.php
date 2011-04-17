<?
/*
*
* Class: Model for Page
*
*/
class Model_Page extends ORM {
	protected $belongs_to = array('template');
	public $content = null;

	private $object_fields = array('loaded', 'template', 'primary_key', 'primary_val');

	public function __construct($id){
		parent::__construct($id);
	//	$this->object_fields = array_merge($this->object_fields, array_keys($this->_column_cache) );
	}
	  /**
		 *    * Allows a model to be loaded by username or email address.
		 *       */
	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'slug';
		}

		return parent::unique_key($id);
	}


	/*
	 *   Function: __get
	 *     Custom getter for this model, links in appropriate content table
	 *       when related object 'content' is requested
	 *         */
	public function __get($column){

    if($column=='contenttable' && !isset($this->related[$column])){
      if(!Kohana::config('mop.legacy')){
        $content = ORM::factory( inflector::singular('contents') );
      } else {
        $content = ORM::factory( inflector::singular($this->template->contenttable) );
      }
      $content->setTemplateName($this->template->templatename); //set the templatename for dbmapping
      $this->related[$column]=$content->where('page_id',$this->id)->find();
      if(!$this->related[$column]->loaded){
        throw new Kohana_User_Exception('BAD_MOP_DB', 'no content record for page '.$this->id);
      }
      return $this->related[$column];
		} else if($column=='parent'){
			return ORM::Factory('page', $this->parentid); 
		}	else {
			return parent::__get($column);
		}
	}


	/*
	Function: __set
	Custom setter, saves to appropriate contenttable
	Interestingly enough, it doesn't pass throug here
	*/
	public function __set($column, $value){
		if($column=='contenttable'){
			$this->changed[$column] = $column;

			// Object is no longer saved
			$this->saved = FALSE;

			$this->object[$column] = $this->load_type($column, $value);

		} else {

			switch(Kohana::config('cms.templates.'.$this->template->templatename.'.'.$column.'.type')){
			case 'multiSelect':
				return $this->saveObject();
				break;	
			default:
        if(is_object($value)){
          return parent::__set($column, $value);
        } else {
          return parent::__set($column, cms::convertNewlines($value));
        }
				break;
			}

		}
	}

	/*
	Function: save()
	Custom save function, makes sure the content table has a record when inserting new page
	*/
	public function save(Validation $validation = NULL) {
		$inserting = false;
		if($this->loaded == FALSE){
			$inserting = true;
		}

		if($inserting){
			//and we need to update the sort, this should be the last
			if(Kohana::config('cms.newObjectPlacement')=='top'){
				$spage = ORM::Factory('page');
				$spage->select('min(sortorder) as minsort ')->where('parentid', $this->parentid)->find();
				$this->sortorder = $spage->minsort - 1;
			} else {
				$spage = ORM::Factory('page');
				$spage->select('max(sortorder) as maxsort ')->where('parentid', $this->parentid)->find();
				$this->sortorder = $spage->maxsort + 1;
			}
			$this->dateadded = new Database_Expr('now()');
		}

		parent::save();
		//if inserting, we add a record to the content table if one does not already exists
		if($inserting){
      if(!Kohana::config('mop.legacy')){
        $content = ORM::Factory('content');
      } else {
        $content = ORM::Factory($this->template->contenttable);
      }
			if(!$content->where('page_id',$this->id)->find()->loaded){
        if(!Kohana::config('mop.legacy')){
          $this->db->insert('contents', array('page_id'=>$this->id));
        } else {
          $this->db->insert(inflector::plural($this->template->contenttable), array('page_id'=>$this->id));
        }

        if(!Kohana::config('mop.legacy')){
          $content = ORM::factory( 'content' );
        } else {
          $content = ORM::factory( inflector::singular($this->__get('template')->contenttable) );
        }
				$content->setTemplateName($this->template->templatename); //set the templatename for dbmapping
				$this->related['contenttable']=$content->where('page_id', $this->id)->find();
			}
		}
	}

	public function updateWithArray($data){
		foreach($data as $field=>$value){
			switch($field){
			case 'slug':
			case 'decoupleSlugTitle':
				case 'dateAdded':
					case 'published':
						case 'activity':
						$this->__set($field, $value);
						break;
					default:
						$this->contenttable->$field = $value;
						break;
			}
		}	
		$this->contenttable->save();
		$this->save();
		return $this->id;
	}

	public function getContentAsArray(){

		$fields = ORM::Factory('objectmap')
			->where('template_id', $this->template->id)
			->find_all();
		foreach($fields as $map){
			$content[$map->column] = $this->contenttable->{$map->column};
		}
		return $content;
	}


	public function setDataQueryWhere($key, $value){
		$this->dataQueryTargets = array();
	}



	public function getContent(){
		return $this->getPageContent();
	}

	public function getPageContent(){
		$content=array();
		$content['id'] = $this->id;
		$content['title'] = $this->__get('contenttable')->title;
		$content['slug'] = $this->slug;
		$content['dateadded'] = $this->dateadded;
		$content['templateName'] = $this->template->templatename;

		$fields = ORM::Factory('objectmap')
			->where('template_id', $this->template->id)
			->find_all();
		foreach($fields as $map){
      if(mop::config('objects', sprintf('//template[@name="%s"]/elements/*[@field="%s"]', $this->template->templatename, $map->column))->length){
        $content[$map->column] = $this->contenttable->{$map->column};
      }
		}

		//find any lists
		foreach(mop::config('objects', sprintf('//template[@name="%s"]/elements/list', $this->template->templatename)) as $list){

			$family = $list->getAttribute('family');	
			$content[$family] = $this->getListContentAsArray($family);
		}

		return $content;
	}

	public function getListContentAsArray($family){
		$iter = $this->getListContent($family);
		$content = array();
		foreach($iter as $item){
			$content[] = $item->getPageContent();
		}
		return $content;
	}



	public function getListContent($family){
		//get container
		$cTemplate = ORM::Factory('template', $family);
		$container = ORM::Factory('page')
			->where('template_id', $cTemplate->id)
			->where('parentid', $this->id)
			->where('activity IS NULL')
			->find();

		//get children of
		Kohana::log('info', 'hasdfasd');
		return $container->getPublishedChildren();
	}


	public function getPublishedChildren(){

		$children = ORM::Factory('page')
			->where('parentid', $this->id)
			->where('published', 1)
			->where('activity IS NULL')
			->orderby('sortorder')
			->find_all();
		return $children;
	}

	public function getChildren(){

		$children = ORM::Factory('page')
			->where('parentid', $this->id)
			->where('activity IS NULL')
			->orderby('sortorder')
			->find_all();
		return $children;
	}
	public function getNextPublishedPeer(){
		$next = ORM::Factory('page')
			->where('parentid', $this->parentid)
			->where('published', 1)
			->where('activity IS NULL')
			->orderby('sortorder', 'ASC')
			->where('sortorder > '.$this->sortorder)
			->limit(1)
			->find();
		if($next->loaded){
			return $next;
		} else{
			return null;
		}
	}

	public function getPrevPublishedPeer(){
		$next = ORM::Factory('page')
			->where('parentid', $this->parentid)
			->where('published', 1)
			->where('activity IS NULL')
			->orderby('sortorder', 'DESC')
			->where('sortorder < '.$this->sortorder)
			->limit(1)
			->find();
		if($next->loaded){
			return $next;
		} else{
			return null;
		}
	}

	public function getFirstPublishedPeer(){
		$first = ORM::Factory('page')
			->where('parentid', $this->parentid)
			->where('published', 1)
			->where('activity IS NULL')
			->orderby('sortorder', 'ASC')
			->limit(1)
			->find();
		if($first->loaded){
			return $first;
		} else{
			return null;
		}
	}

	public function getLastPublishedPeer(){
		$last = ORM::Factory('page')
			->where('parentid', $this->parentid)
			->where('published', 1)
			->where('activity IS NULL')
			->orderby('sortorder', 'DESC')
			->limit(1)
			->find();
		if($last->loaded){
			return $last;
		} else{
			return null;
		}
	}

	public function getParent(){
		$parent = ORM::Factory('page', $this->parentid);
		return $parent;
	}

	public function saveField($field, $value){
		$this->contenttable->$field = $value;
		$this->contenttable->save();
		return $this->contenttable->$field;
	}


	public function saveUploadedFile($field, $fileName, $type, $tmpName){
		$tmpName = $this->moveUploadedFileToTmpMedia($tmpName);
		return $this->saveFile($field, $fileName, $type, $tmpName); 
	}

	/*
	 *
	 *	Returns: file model of saved file
	 * */
	public function saveUploadedImage($field, $fileName, $type, $tmpName){
			$tmpName = $this->moveUploadedFileToTmpMedia($tmpName);
			$file = $this->saveImage($field, $fileName, $type, $tmpName); 

		return $file;
	}

	private function moveUploadedFileToTmpMedia($tmpName){
		$saveName = cms::makeFileSaveName('tmp').microtime();

		if(!move_uploaded_file($tmpName, cms::mediapath().$saveName)){
			$result = array(
				'result'=>'failed',
				'error'=>'internal error, contact system administrator',
			);
			return $result;
		}
		Kohana::log('info', 'moved file to '.cms::mediapath().$saveName);

		return $saveName;

	}

	public function saveFile($field, $fileName, $type, $tmpName){
		if(!is_object($file = $this->contenttable->$field)){
			$file = ORM::Factory('file', $this->contenttable->$field);
		}	

		$file->unlinkOldFile();
		$saveName = cms::makeFileSaveName($fileName);

		if(!copy(cms::mediapath().$tmpName, cms::mediapath().$saveName)){
			throw new MOP_Exception('this is a MOP Exception');
		}
		unlink(cms::mediapath().$tmpName);
		
		$file->filename = $saveName;	
		$file->mime = $type;
		$file->save(); //inserts or updates depending on if it got loaded above

		$this->contenttable->$field = $file->id;
		$this->contenttable->save();

		return $file;

	}

	public function verifyImage($field, $tmpName){
		$origwidth = $size[0];
		$origheight = $size[1];
		Kohana::log('info', var_export($parameters, true));
		if(isset($parameters['minheight']) &&  $origheight < $parameters['minheight']){
			$result = array(
				'result'=>'failed',
				'error'=>'Image height less than minimum height',
			);
			return $result;
		}
		if(isset($parameters['minwidth']) && $origwidth < $parameters['minwidth']){
			$result = array(
				'result'=>'failed',
				'error'=>'Image width less than minimum width',
			);
			return $result;
		}
		Kohana::log('info', "passed min tests with {$origwidth} x {$origheight}");

	}

	public function saveImage($field, $fileName, $type, $tmpName){
		//do the saving of the file
		$file = $this->saveFile($field, $fileName, $type, $tmpName);
		Kohana::log('info', 'Returning to saveImage');


		$imageFileName = $this->processImage($file->filename, $field);

		return $file;
		
	}

	/*
	 * Functon: processImage($filename, $parameters)
	 * Create all automatice resizes on this image
	 */
	public function processImage($filename, $field){

		//First check for tiff, and convert if necessary
		$ext = substr(strrchr($filename, '.'), 1);
		switch($ext){
		case 'tiff':
		case 'tif':
		case 'TIFF':
		case 'TIF':
			Kohana::log('info', 'Converting TIFF image to JPG for resize');

			$imageFileName =  $filename.'_converted.jpg';
			$command = sprintf('convert %s %s',addcslashes(cms::mediapath().$filename, "'\"\\ "), addcslashes(cms::mediapath().$imageFileName, "'\"\\ "));
			Kohana::log('info', $command);
			system(sprintf('convert %s %s',addcslashes(cms::mediapath().$filename, "'\"\\ "),addcslashes(cms::mediapath().$imageFileName, "'\"\\ ")));
			break;
		default:
			$imageFileName = $filename;
			break;
		}

		Kohana::log('info', $imageFileName);


		//do the resizing
    $templatename = $this->template->templatename;
		$resizes = mop::config('objects', sprintf('//template[@name="%s"]/elements/*[@field="%s"]/resize', 
      $templatename,
			$field
		)
	);
		foreach($resizes as $resize){

			if($prefix = $resize->getAttribute('name')){
				$prefix = $prefix.'_';
			} else {
				$prefix = '';
			}
			$newFilename = $prefix.$imageFileName;
			$saveName = cms::mediapath().$newFilename;

			cms::resizeImage($imageFileName, $newFilename, 
				$resize->getAttribute('width'),
				$resize->getAttribute('height'),
				$resize->getAttribute('forceDimension'), 
				$resize->getAttribute('crop')
			);

			if(isset($oldFilename) && $newFilename != $prefix.$oldFilename){
				if(file_exists(cms::mediapath().$oldFilename)){
					unlink(cms::mediapath().$oldFilename);
				}
			}
		}	
		//and create thumbnail
		$uiresize = Kohana::config('cms.uiresize');
		cms::resizeImage($imageFileName, $uiresize['prefix'].'_'.$imageFileName, $uiresize['width'], $uiresize['height'], $uiresize['forceDimension'], $uiresize['crop']);


		return $imageFileName;
	}


	public function saveMappedPDF(){
		$result = $this->saveFile();
		if($result['result'] == 'success'){
			//rebuild the associations

			$associations = unserialize($this->contenttable->field_associations);
			if(!is_array($associations)){
				$associations = array();
			}
			//get fields from pdf
			$p = PDF_new();
			$indoc = PDF_open_pdi_document($p, $result['src'], "");
			if ($indoc == 0) {
				die("Error: " . PDF_get_errmsg($p));
			}
			$blockcount = PDF_pcos_get_number($p, $indoc, "length:pages[0]/blocks");
			/* Loop over all blocks on the $page */
			$blocks = array();
			for ($i = 0; $i <  $blockcount; $i++) {
				$blocks[PDF_pcos_get_string($p, $indoc, "pages[0]/blocks[" . $i . "]/Name")] = true;
			}
			//take out blocks that have been removed
			$remove = array();
			foreach($associations as $key=>$value){
				if(!isset($blocks[$key])){
					$remove[] = $key;
				}
			}
			foreach($remove as $removal){
				unset($associations[$removal]);
			}
			//add in any new blocks
			$keys = array_keys($associations);
			foreach($blocks as $key=>$value){
				if(!in_array($key, $keys)){
					$associations[$key] = '';
				}
			}
			//and save serialized value
			$this->contenttable->field_associations = serialize($associations);
			$this->contenttable->save();
			//$result['fieldAssociations'] = $associations;

			//and build the html
			$fieldmapView = new View('ui_fieldmap');
			$fieldmapView->options = $this->contenttable->getFieldmapOptions();
			$fieldmapView->values = $this->contenttable->field_associations;
			$result['html'] = str_replace("\n", '',$fieldmapView->render() ) ;
			$result['html'] = str_replace("\t", '', $result['html']);
			$result['html'] = str_replace('"', 'mop_token_2009', $result['html']);
			//$result['html'] = 'date_completed select id="date_completed" name="date_completed" class="pulldown field-date_completed"';
		
		}
		return $result;
	}

	//this is gonna change a lot!
	//this only supports a very special case of multiSelect objects
	public function saveObject(){
		$object = ORM::Factory('page', $this->contenttable->$_POST['field']);
		if(!$object->template_id){
			$object->template_id = 0;
		}

		$element['options'] = array();
		foreach(Kohana::config('cms.templates.'.$object->template->templatename) as $field){
			if($field['type'] == 'checkbox'){
				$options = $field['field'];
			}
		}
		foreach($options as $field){
			$object->contenttable->$field  = 0;
		}

		foreach($_POST['values'] as $value){
			$object->contenttable->$value = 1;
		}
		$object->save();
		return true;
	}

	
	public function saveFieldMapping($field, $value){
		$this->contenttable->trans_start();
		$map = false;
		if($this->contenttable->field_associations){
			$map = unserialize($this->contenttable->field_associations);
		}
		if(!$map){
			$map = array();
		}
		$map[$field] = $value;
		$this->contenttable->field_associations = serialize($map);
		$this->contenttable->save();
		$this->contenttable->trans_complete();
		return true;
	}


	/* Query Filters */
	public function templateFilter($templates){
		if(!$templates){
			return $this;
		}
			$db = new Database();
		if(strpos(',', $templates)){
			$tNames = explode(',', $templates);
			$tIds = array();
			foreach($tNames as $tname){
				$result = $db->query("Select id from templates where templatename = '$templates'");
				$tIds[] = $result->current()->id;
			}
			$this->in('template_id', $tIds);
		} else if ($templates == 'all'){
			//set no filter
		} else {
			$result = $db->query("Select id from templates where templatename = '$templates'");
			$this->where('template_id', $result->current()->id);
		}
		return $this;
	}

	public function parentFilter($parentid){
		$this->where('parentid', $parentid);	
	}

	public function noContainerObjects(){
			$db = new Database();
			$res = $db->query("Select id from templates where nodeType = 'container'");
			$tIds = array();
			foreach($res as $container){
				$tIds[] = $container->id;
			}
			if(count($tIds)){
				$this->notin('template_id', $tIds);
			}
			return $this;
	}

	public function publishedFilter(){
		$this->where('published', 1)
			->where('activity IS NULL');
		return $this;
	}

	public function taggedFilter(){

	}



}
?>
