<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Model for Object
 *
 * @author deepwinter1
 */
class Model_Object extends ORM {
   
    protected $_table_name = 'pages';

   
    protected $_belongs_to = array(
        'template' => array()
    );
    protected $_has_one = array(
        'template' => array()
    );
    
    protected $_has_many = array(
        'tag' => array(
            'model' => 'tag',
            'through' => 'objects_tags'
        )
    );
    
    public $content = null;
    private $object_fields = array('loaded', 'template', 'primary_key', 'primary_val');

    public function __construct($id=NULL) {
        parent::__construct($id);
        //	$this->object_fields = array_merge($this->object_fields, array_keys($this->_column_cache) );
    }

    /**
     *    * Allows a model to be loaded by username or email address.
     *       */
    public function unique_key($id) {
        if (!empty($id) AND is_string($id) AND !ctype_digit($id)) {
            return 'slug';
        }

        return parent::unique_key($id);
    }

    /*
     *   Function: __get
     *     Custom getter for this model, links in appropriate content table
     *       when related object 'content' is requested
     *         */

    public function __get($column) {

        if ($column == 'contenttable' && !isset($this->_related[$column])) {
            $content = ORM::factory(inflector::singular('contents'));
            $content->setTemplateName($this->template->templatename); //set the templatename for dbmapping
            $this->_related[$column] = $content->where('page_id', '=', $this->id)->find();
            if (!$this->_related[$column]->_loaded) {
                throw new Kohana_User_Exception('BAD_MOP_DB', 'no content record for page ' . $this->id);
            }
            return $this->_related[$column];
        } else if ($column == 'parent') {
            return ORM::Factory('object', $this->parentid); 
        } else {
            return parent::__get($column);
        }
    }

    /*
      Function: __set
      Custom setter, saves to appropriate contenttable
     */
	public function __set($column, $value){
		if($column=='contenttable'){
			$this->_changed[$column] = $column;

			// Object is no longer saved
			$this->_saved = FALSE;

			$this->object[$column] = $this->load_type($column, $value);

		} else {
			if(is_object($value)){
				return parent::__set($column, $value);
			} else {
				return parent::__set($column, mopcms::convertNewlines($value));
			}

		}
	}

	/*
	Function: save()
	Custom save function, makes sure the content table has a record when inserting new page
	*/
	public function save(Validation $validation = NULL) {

		$inserting = false;
		if($this->_loaded == FALSE){
			$inserting = true;
		}

		if($inserting){
			//and we need to update the sort, this should be the last
			//
			if($this->parentid!=NULL){
				if(Kohana::config('cms.newObjectPlacement')=='top'){

					$sort = DB::query(Database::SELECT,
						'select min(sortorder) as minsort from pages where parentid = '.$this->parentid)->execute()->current();
					$this->sortorder = $sort['minsort']-1;

				} else {
					$query = 'select max(sortorder) as maxsort from pages where parentid = '.$this->parentid;
					$sort = DB::query(Database::SELECT, $query)->execute()->current();
					$this->sortorder = $sort['maxsort']+1;

				}
				$this->dateadded = 'now()';
			}
		}

		parent::save();
		//if inserting, we add a record to the content table if one does not already exists
		if($inserting){
      if(!Kohana::config('mop.legacy')){
        $content = ORM::Factory('content');
      } else {
        $content = ORM::Factory($this->template->contenttable);
      }
			if(!$content->where('page_id', '=', $this->id)->find()->loaded()){
				$content = ORM::Factory('content');
				$content->page_id = $this->id;
				$content->save();

				$content->setTemplateName($this->template->templatename); //set the templatename for dbmapping
				$this->_related['contenttable']=$content;
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
			->where('template_id', '=', $this->template->id)
			->find_all();
		foreach($fields as $map){
			$content[$map->column] = $this->contenttable->{$map->column};
		}
		return $content;
	}


	public function setDataQueryWhere($key, $value){
		$this->dataQueryTargets = array();
	}


   public function addTag($tagName){
      $tag = ORM::Factory('tag')->where('tag', '=', $tagName)->find();
      if(!$tag->loaded()){
         $tag = ORM::Factory('tag');
         $tag->tag = $tagName;
         $tag->save();
      }
      $this->add('tag', $tag);
      return $this;
   }
   
   public function removeTag($tagName){
      $tag = ORM::Factory('tag')->where('tag', '=', $tagName)->find();
      if(!$tag->loaded()){
         throw new Kohana_Exception("Tag :tagName does not exist in the database.", array(':tagName'=>$tagName));
      }
      $this->remove('tag', $tag);
      return $this;
   }
   
   public function getTags(){
      $tagObjects = ORM::Factory('objects_tag')
              ->where('object_id', '=', $this->id)
              ->find_all();
      $tags = array();
      foreach($tagObjects as $tagObject){
         $tags[] = $tagObject->as_array();
      }
      return $tags;
   }
   
   public function getPublishedObjectBySlug($slug){
      
      return $this->where('slug', '=', $slug)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->find();
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

		$fields = mop::config('objects', sprintf('//template[@name="%s"]/elements/*', $this->template->templatename));

		foreach ($fields as $fieldInfo) {
         $field = $fieldInfo->getAttribute('field');
         if (mop::config('objects', sprintf('//template[@name="%s"]/elements/*[@field="%s"]', $this->template->templatename, $field))->length) {
            $content[$field] = $this->contenttable->{$field};
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
		$container = ORM::Factory('object')
			->where('template_id', '=', $cTemplate->id)
			->where('parentid', '=', $this->id)
			->where('activity', 'IS', NULL)
			->find();

		//get children of
		Kohana::$log->add(Log::INFO, 'hasdfasd');
		return $container->getPublishedChildren();
	}


	public function getPublishedChildren(){

		$children = ORM::Factory('object')
			->where('parentid', '=', $this->id)
			->where('published', '=', 1)
			->where('activity', 'IS', NULL)
			->order_by('sortorder')
			->find_all();
		return $children;
	}

	public function getChildren(){

		$children = ORM::Factory('object')
			->where('parentid', '=', $this->id)
			->where('activity', 'IS', NULL)
			->order_by('sortorder')
			->find_all();
		return $children;
	}
	public function getNextPublishedPeer(){
		$next = ORM::Factory('object')
			->where('parentid', '=', $this->parentid)
			->where('published', '=', 1)
			->where('activity', 'IS', NULL)
			->order_by('sortorder', 'ASC')
			->where('sortorder', '>', $this->sortorder)
			->limit(1)
			->find();
		if($next->loaded()){
			return $next;
		} else{
			return null;
		}
	}

	public function getPrevPublishedPeer(){
		$next = ORM::Factory('object')
			->where('parentid', '=', $this->parentid)
			->where('published', '=', 1)
			->where('activity', 'IS', NULL)
			->order_by('sortorder', 'DESC')
			->where('sortorder', '<', $this->sortorder)
			->limit(1)
			->find();
		if($next->loaded()){
			return $next;
		} else{
			return null;
		}
	}

	public function getFirstPublishedPeer(){
		$first = ORM::Factory('object')
			->where('parentid', '=', $this->parentid)
			->where('published', '=', 1)
			->where('activity', 'IS', NULL)
			->order_by('sortorder', 'ASC')
			->limit(1)
			->find();
		if($first->loaded()){
			return $first;
		} else{
			return null;
		}
	}

	public function getLastPublishedPeer(){
		$last = ORM::Factory('object')
			->where('parentid', '=', $this->parentid)
			->where('published', '=', 1)
			->where('activity', 'IS', NULL)
			->order_by('sortorder', 'DESC')
			->limit(1)
			->find();
		if($last->loaded()){
			return $last;
		} else{
			return null;
		}
	}

	public function getParent(){
		$parent = ORM::Factory('object', $this->parentid);
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
  		Kohana::$log->add(Log::INFO, 'clling save image'.$fileName);
			$file = $this->saveImage($field, $fileName, $type, $tmpName); 

		return $file;
	}

	private function moveUploadedFileToTmpMedia($tmpName){
		$saveName = mopcms::makeFileSaveName('tmp').microtime();

		if(!move_uploaded_file($tmpName, mopcms::mediapath().$saveName)){
			$result = array(
				'result'=>'failed',
				'error'=>'internal error, contact system administrator',
			);
			return $result;
		}
		Kohana::$log->add(Log::INFO, 'tmp moved file to '.mopcms::mediapath().$saveName);

		return $saveName;

	}

	public function saveFile($field, $fileName, $type, $tmpName){
		if(!is_object($file = $this->contenttable->$field)){
			$file = ORM::Factory('file', $this->contenttable->$field);
		}	

		$file->unlinkOldFile();
		$saveName = mopcms::makeFileSaveName($fileName);

		if(!copy(mopcms::mediapath().$tmpName, mopcms::mediapath().$saveName)){
			throw new MOP_Exception('this is a MOP Exception');
		}
		unlink(mopcms::mediapath().$tmpName);
		
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
		Kohana::$log->add(Log::INFO, var_export($parameters, true));
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
		Kohana::$log->add(Log::INFO, "passed min tests with {$origwidth} x {$origheight}");

	}

	public function saveImage($field, $fileName, $type, $tmpName){
		//do the saving of the file
		$file = $this->saveFile($field, $fileName, $type, $tmpName);
		Kohana::$log->add('info', 'Returning to saveImage');


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
			Kohana::$log->add(Log::INFO, 'Converting TIFF image to JPG for resize');

			$imageFileName =  $filename.'_converted.jpg';
			$command = sprintf('convert %s %s',addcslashes(mopcms::mediapath().$filename, "'\"\\ "), addcslashes(mopcms::mediapath().$imageFileName, "'\"\\ "));
			Kohana::$log->add(Log::INFO, $command);
			system(sprintf('convert %s %s',addcslashes(mopcms::mediapath().$filename, "'\"\\ "),addcslashes(mopcms::mediapath().$imageFileName, "'\"\\ ")));
			break;
		default:
			$imageFileName = $filename;
			break;
		}

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
			$saveName = mopcms::mediapath().$newFilename;

			mopcms::resizeImage($imageFileName, $newFilename, 
				$resize->getAttribute('width'),
				$resize->getAttribute('height'),
				$resize->getAttribute('forceDimension'), 
				$resize->getAttribute('crop')
			);

			if(isset($oldFilename) && $newFilename != $prefix.$oldFilename){
				if(file_exists(mopcms::mediapath().$oldFilename)){
					unlink(mopcms::mediapath().$oldFilename);
				}
			}
		}	
		//and create thumbnail
		$uiresize = Kohana::config('cms.uiresize');
		mopcms::resizeImage($imageFileName, $uiresize['prefix'].'_'.$imageFileName, $uiresize['width'], $uiresize['height'], $uiresize['forceDimension'], $uiresize['crop']);


		return $imageFileName;
	}


	//this is gonna change a lot!
	//this only supports a very special case of multiSelect objects
	public function saveObject(){
		$object = ORM::Factory('object', $this->contenttable->$_POST['field']);
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
			$this->where('template_id', '=', $result->current()->id);
		}
		return $this;
	}

	public function parentFilter($parentid){
		$this->where('parentid', '=', $parentid);	
	}

	public function noContainerObjects(){
			$res = ORM::Factory('template')
				->where('nodeType', '=', 'container')
				->find_all();
			$tIds = array();
			foreach($res as $container){
				$tIds[] = $container->id;
			}
			if(count($tIds)){
				$this->where('template_id', 'NOT IN',  DB::Expr('('. implode(',', $tIds).')' ) );
			}
			return $this;
	}

	public function publishedFilter(){
		$this->where('published', '=', 1)
			->where('activity', 'IS', NULL);
		return $this;
	}

	public function taggedFilter(){

	}


   /*
	Function: addObject($id)
	Private function for adding an object to the cms data
	Parameters:
	id - the id of the parent category
	template_id - the type of object to add
	$data - possible array of keys and values to initialize with
	Returns: the new page id
	*/

				/* Consider moving this into Object, and creating a hidden top level object that contains these objects
				 * then hidden objects or other kinds of data can be stored, but not within the cms object tree
				 * This makes sense for separating the CMS from the graph, and containing all addObject code within the model.
				 * */
  public function addObject($template_ident, $data = array()) {
      $template_id = ORM::Factory('template', $template_ident)->id;
      if (!$template_id) {
         //we're trying to add an object of template that doesn't exist in db yet
         //check objects.xml for configuration
         if ($templateConfig = mop::config('objects', sprintf('//template[@name="%s"]', $template_ident))->item(0)) {
            //there's a config for this template
            //go ahead and configure it
            mopcms::configureTemplate($templateConfig);
            $template_id = ORM::Factory('template', $template_ident)->id;
         } else {
            throw new Kohana_Exception('No config for template ' . $template_ident);
         }
      }


      //suggested new syntax
//      Graph::object($objectId)->addObject($template, $data);
      
		$newObject = Graph::object();
		$newObject->template_id = $template_id;

		//create slug
		if(isset($data['title'])){
			$newObject->slug = mopcms::createSlug($data['title'], $newObject->id);
		} else {
			$newObject->slug = mopcms::createSlug();
		}
		$newObject->parentid = $this->id;

		//calculate sort order
		$sort = DB::select(array('sortorder','maxsort'))->from('pages')->where('parentid', '=', $this->id)
			->order_by('sortorder')->limit(1)
			->execute()->current();
		$newObject->sortorder = $sort['maxsort']+1;

		$newObject->save();
	

		//check for enabled publish/unpublish. 
		//if not enabled, insert as published
		$template = ORM::Factory('template', $template_id);
		$tSettings = mop::config('objects', sprintf('//template[@name="%s"]', $template->templatename) ); 
		$tSettings = $tSettings->item(0);
		$newObject->published = 1;
		if($tSettings){ //entry won't exist for Container objects
			if($tSettings->getAttribute('allowTogglePublish') == 'true' ) {
				$newObject->published = 0;
			}
		}
		if(isset($data['published']) && $data['published'] ){
			$newObject->published = 1;
			unset($data['published']);
		}

		$newObject->save();

		//Add defaults to content table
		$newtemplate = ORM::Factory('template', $newObject->template_id);


		$lookupTemplates = mop::config('objects', '//template');
		$templates = array();
		foreach($lookupTemplates as $tConfig){
			$templates[] = $tConfig->getAttribute('name');	
		}
      Kohana::$log->add(Log::ERROR,'yuh');
		//add submitted data to content table
		foreach($data as $field=>$value){

			//need to switch here on type of field
			switch($field){
			case 'slug':
			case 'decoupleSlugTitle':
					$newObject->$field = $data[$field];
					continue(2);
			case 'title':
					$newObject->contenttable->$field = $data[$field];
					continue(2);
			}

			$fieldInfoXPath = sprintf('//template[@name="%s"]/elements/*[@field="%s"]', $newtemplate->templatename, $field);
			$fieldInfo = mop::config('objects', $fieldInfoXPath)->item(0);
			if(!$fieldInfo){
				throw new Kohana_Exception("No field info found in objects.xml while adding new object, using Xpath :xpath", array(':xpath'=>$fieldInfoXPath));
			}

			if(in_array($fieldInfo->tagName, $templates) && is_array($value) ){
				$clusterTemplateName = $fieldInfo->tagName;
				$clusterObjectId = mopcms::addObject(null, $clusterTemplateName, $value);
				$newObject->contenttable->$field = $clusterObjectId;
				continue;
			}


      Kohana::$log->add(Log::ERROR,$fieldInfo->tagName);
			switch($fieldInfo->tagName){
			case 'file':
			case 'image':
				//need to get the file out of the FILES array
				
				Kohana::$log->add(Log::ERROR, var_export($_POST, true));
				Kohana::$log->add(Log::ERROR, var_export($_FILES, true));
      Kohana::$log->add(Log::ERROR,'something'.$field);
				if(isset($_FILES[$field])){
          Kohana::$log->add(Log::ERROR,'Adding via post file');
					$file = mopcms::saveHttpPostFile($newObject->id, $field, $_FILES[$field]);
				} else {
					$file = ORM::Factory('file');
					$file->filename = $value;			
					$file->save();
					$newObject->contenttable->$field = $file->id;
				}
				break;
			default:
				$newObject->contenttable->$field = $data[$field];
				break;
			}
		}
		$newObject->contenttable->save();
		$newObject->save();

		//look up any components and add them as well

		//configured components
		$components = mop::config('objects', sprintf('//template[@name="%s"]/components/component',$newtemplate->templatename));
		foreach($components as $c){
			$arguments = array();
			if($label = $c->getAttribute('label')){
				$arguments['title'] = $label;
			}
			if($c->hasChildNodes()){
				foreach($c->childNodes as $data){
					$arguments[$data->tagName] = $data->value;
				}
			}
			mopcms::addObject($newObject->id, $c->getAttribute('templateName'), $arguments);
		}

		//containers (list)
		$containers = mop::config('objects', sprintf('//template[@name="%s"]/elements/list',$newtemplate->templatename));
		foreach($containers as $c){
			$arguments['title'] = $c->getAttribute('label');
			mopcms::addObject($newObject->id, $c->getAttribute('family'), $arguments);
		}

		return $newObject->id;
	}

	public static function makeFileSaveName($filename){
    $filename = str_replace('&', '_', $filename);

		$xarray = explode('.', $filename);
		$nr = count($xarray);
		$ext = $xarray[$nr-1];
		$name = array_slice($xarray, 0, $nr-1);
		$name = implode('.', $name);
		$i=1;
		if(!file_exists(mopcms::mediapath()."$name".'.'.$ext)){
			$i='';
		} else {
			for(; file_exists(mopcms::mediapath()."$name".$i.'.'.$ext); $i++){}
		}

		//clean up extension
		$ext = strtolower($ext);
		if($ext=='jpeg'){ $ext = 'jpg'; }

		return $name.$i.'.'.$ext;
	}

	public static function saveHttpPostFile($objectid, $field, $postFileVars){
          Kohana::$log->add(Log::ERROR,'Addasdfasd aing via post file');

      Kohana::$log->add(Log::ERROR, 'save uploaded');
      Kohana::$log->add(Log::ERROR, var_export($postFileVars, true));
		$object = ORM::Factory('object', $objectid);
		//check the file extension
		$filename = $postFileVars['name'];
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
		case 'tif':
		case 'tiff':
		case 'TIF':
		case 'TIFF':
      Kohana::$log->add(Log::ERROR, 'save uploaded');
			return $object->saveUploadedImage($field, $postFileVars['name'], 
																				$postFileVars['type'], $postFileVars['tmp_name']);
			break;

		default:
			return $object->saveUploadedFile($field, $postFileVars['name'], 
				$postFileVars['type'], $postFileVars['tmp_name']);
		}

	}

   

  
   
   
}
?>
