<?
/*
*
* Class: Model for Page
*
*/
class Page_Model extends ORM {
	protected $belongs_to = array('template');
	public $content = null;

	private $object_fields = array('loaded', 'template', 'primary_key', 'primary_val');

	public function __construct($id){
		parent::__construct($id);
		$this->object_fields = array_merge($this->object_fields, array_keys($this->table_columns) );
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
				return parent::__set($column, cms::convertNewlines($value));
				break;
			}

		}
	}

	/*
	Function: save()
	Custom save function, makes sure the content table has a record when inserting new page
	*/
	public function save(){
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

	public function getContentAsArray(){

		if($fields = Kohana::config('cms_dbmap.'.$this->template->templatename)){
			foreach($fields as $key=>$value){
				$content[$key] = $this->contenttable->$key;
			}
		} else {
			$content = $this->contenttable->as_array();
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

		if($fields = Kohana::config('cms_dbmap.'.$this->template->templatename)){ 
			foreach($fields as $key=>$value){
				$content[$key] = $this->__get('contenttable')->$key;
			}
		} else {
			$content = $this->__get('contenttable')->as_array();
		}

		//get data from lists
		$blocks = Kohana::config('cms.templates.'.$this->__get('template')->templatename);
		if($blocks) {
			$modules = array();
			foreach($blocks as $block){
				if($block['type'] == 'module'){
					switch($block['controllertype']){
					case 'listmodule':
						$content[$block['modulename']] = $this->getListData($block['modulename']);
						break;
					default:
						break;
					}
				}
			}
		}

		return $content;
	}


	//EXPERIMENTAL
	// ok this doubles up code in site controller
	// in the future there shouldn't be a distinction between templates and lists
	// and that will resolve this doubling, which is dumb
	public function getListData($instance){
			if(! $sortdirection = Kohana::config($instance.'.sortdirection')){
				$sortdirection = Kohana::config('listmodule.sortdirection');
			}

			//for pagination, we generate the module
			//and then just go ahead and call the paginatedList stuff


			$dbmap = Kohana::config($instance.'.dbmap');
			$listitems = ORM::Factory('list')
			->where('instance', $instance)
			->where('activity IS NULL')
			->orderby('sortorder', $sortdirection);
			if($this->id){
				$listitems->where('page_id', $this->id);
			}
			$listitems = $listitems->find_all();
			$list = array();
			//this is a template for slurping out lists
			foreach($listitems as $item){
				$data = array();
				foreach($dbmap as $var => $dbfield){
					$data[$var] = $item->$var; //EXPERIMENTAL	
				}

				$files = Kohana::config($instance.'.files');
				if(is_array($files)){
					foreach($files as $key => $settings){
						$data[$key] = $item->$key;
					}
				}
				$singleimages = Kohana::config($instance.'.singleimages');
				if(is_array($singleimages)){
					foreach($singleimages as $key => $settings){
						$data[$key] = $item->$key;
					}
				}
				$list[] = $data;
			}
			return $list;
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


	public function saveFile($field, $postFiles){
		//check for valid file upload
		if(!isset($field)){
			Kohana::log('error', 'No field in Post');
			throw new Kohana_User_Exception('no field in POST', 'no field in POST');
		}
		Kohana::log('info', 'proceeding with saveFile');

		$file = ORM::Factory('file', $this->$field);
		
		$xarray = explode('.', $_postFiles[$field]['name']);
		$nr = count($xarray);
		$ext = $xarray[$nr-1];
		$name = array_slice($xarray, 0, $nr-1);
		$name = implode('.', $name);
		$i=1;
		if(!file_exists(cms::mediapath()."$name".'.'.$ext)){
			$i='';
		} else {
			for(; file_exists(cms::mediapath()."$name".$i.'.'.$ext); $i++){}
		}

		//clean up extension
		$ext = strtolower($ext);
		if($ext=='jpeg'){ $ext = 'jpg'; }

		$savename = $name.$i.'.'.$ext;

		if($this->savelocalfile){ //allow bypass of move_uploaded_file
			copy($this->savelocalfile, cms::mediapath().$savename);
		} else if(!move_uploaded_file($postFiles[$field]['tmp_name'], cms::mediapath().$savename)){
			$result = array(
					'result'=>'failed',
					'error'=>'internal error, contact system administrator',
				);
			return $result;
		}
		Kohana::log('info', 'moved file to '.cms::mediapath().$savename);

		if(!is_object($file = $this->contenttable->$field)){
			$file = ORM::Factory('file', $this->contenttable->$field);
		}	

		if($file->loaded){
			$oldFilename = $file->filename;
		}

		$file->filename = $savename;	
		$file->mime = $_FILES[$field]['type'];
		$file->save(); //inserts or updates depending on if it got loaded above

		$this->contenttable->$field = $file->id;
		$this->contenttable->save();

		if(isset($oldFilename) && ($savename != $oldFilename) ){
			Kohana::log('info', 'trying to unlink file');
			//then we have to get rid of the old file
			if(file_exists(cms::mediapath().$oldFilename)){
				Kohana::log('info', 'unlinking '.cms::mediapath().$oldFilename);
				unlink(cms::mediapath().$oldFilename);
			}
		}
		


		$parse = explode('.', $savename);
		$ext = $parse[count($parse)-1];
		$result = array(
			'id'=>$file->id,
			'src'=>$this->basemediapath.$savename,
			'filename'=>$savename,
			'ext'=>$ext,
			'result'=>'success',
		);
		Kohana::log('info', 'finished with saveFile '.var_export($result, true));
		return $result;

	}

	public function saveImage($field, $postFiles, $parameters){
		Kohana::log('info', 'Saving Image '.var_export($parameters, true) );
		if(!isset($field)){
			Kohana::log('error', 'No field in Post');
			throw new Kohana_User_Exception('no field in POST', 'no field in POST');
		}

		if($this->savelocalfile){
			$size = @getimagesize($this->savelocalfile);
		} else if(!$size = @getimagesize($postFiles[$field]['tmp_name'])){
			Kohana::log('error', 'Bad upload tmp image');
			throw new Kohana_User_Exception('bad upload tmp image', 'bad upload tmp image');
		}

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

		//get original file names so we can delete them
		$file = ORM::Factory('file', $this->contenttable->$field);
		if($file->loaded){
			$oldFilename = $file->filename;
		}

		//do the saving of the file
		$result = $this->saveFile();
		Kohana::log('info', 'Returning to saveImage');


		$imageFilename = cms::processImage($result['filename'], $parameters);
		

		if(file_exists(cms::mediapath().'uithumb_'.$imageFilename)){
			$resultpath = cms::mediapath().'uithumb_'.$imageFilename;
			$thumbSrc = Kohana::config('cms.basemediapath').'uithumb_'.$imageFilename;
		} else {
			$resultpath = cms::mediapath().$imageFilename;
			$thumbSrc = Kohana::config('cms.basemediapath').$imageFilename;
		}
		$size = getimagesize($resultpath);
		$result['width'] = $size[0];
		$result['height'] = $size[1];
		$result['thumbSrc']= $thumbSrc;

		//get rid of the old ones
		//but how to find them ???

		return $result;
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




}
?>
