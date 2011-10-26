<?php

/**
 * Model_Object
 * The ORM Object that connects to the objects table in the database
 * This class also contains all functionality for using the object in the graph.
 * Model_Object hosts a content table for tracking content data, which is implemented
 * by extending 4 abstract methods from this class.
 * @author deepwinter1
 */
class Model_Object extends ORM {

   protected $_belongs_to = array(
       'objecttype' => array()
   );
   protected $_has_one = array(
       'objecttype' => array()
   );
	 protected $_has_many = array(
		 'tag' => array(
			 'model' => 'tag',
			 'through' => 'objects_tags'
		 )
	 );
	 //cache
	 private $latticeParents = array();

	 private $object_fields = array('loaded', 'objecttype', 'primary_key', 'primary_val');


	 protected $contentDriver = NULL;

	 protected $messages = array();


	 public function __construct($id=NULL) {


		 if (!empty($id) AND is_string($id) AND !ctype_digit($id)) {

			 //check for translation reference
			 if (strpos('_', $id)) {
				 $slug = strtok($id, '_');
				 $languageCode = strtok($id);
				 $object = Graph::object($slug);
				 $translatedObject = $object->translated($languageCode);
				 return $translatedObject;
			 } else {

				 $result = DB::select('id')->from('objects')->where('slug', '=', $id)->execute()->current();
				 $id = $result['id'];
			 }
		 }

		 parent::__construct($id);

		 if($this->loaded()){
			 $this->loadContentDriver();
		 }
	 }



	/*
	 * Variable: createSlug($title, $forPageId)
	 * Creates a unique slug to identify a object
	 * Parameters:
	 * $titleOrSlug - optional starting point for the slug
	 * $forPageId - optionally indicate the id of the object this slug is for to avoid false positive slug collisions
	 * Returns: The new, unique slug
	 */
	public static function createSlug($titleOrSlug=NULL, $forPageId=NULL){
		//create slug
		if($titleOrSlug!=NULL){
			$slug = preg_replace('/[^a-z0-9\- ]/', '', strtolower($titleOrSlug));
			$slug = str_replace(' ', '-', $slug);
			$slug = trim($slug);

         
			$checkSlug = Graph::object()
                 ->where('slug', '=', $slug);
         if ($forPageId != NULL) {
            $checkSlug->where('id', '!=', $forPageId);
         }
         $checkSlug->find();
         if (!$checkSlug->loaded()) {
            return $slug;
         }

         
			$checkSlug = Graph::object()
				->where('slug', 'REGEXP',  '^'.$slug.'[0-9]*$')
				->order_by("slug");
      	
			if($forPageId != NULL){
				$checkSlug->where('id', '!=', $forPageId);
			}
			$checkSlug = $checkSlug->find_all();
			if(count($checkSlug)){
				$idents = array();
				foreach($checkSlug as $ident){
					$idents[] = $ident->slug;
				}
				natsort($idents);
				$idents = array_values($idents);
				$maxslug = $idents[count($idents)-1];
				if($maxslug){
					$curindex = substr($maxslug, strlen($slug));
					$newindex = $curindex+1;
					$slug .= $newindex;
				}
			}
			return $slug;
		} else {
			return self::createSlug('slug'.str_replace(' ', '',microtime())); //try something else
		}
	}

	/*
	 * convertNewLines($value)
	 * Replace \n with <br /> for saving into the database
	 * This replacement is wrapped by detection for \n values that should not be converted into br tags, 
	 * those which follow lines that only contain html tags
	 */
	public static function convertNewLines($value){
		$value = preg_replace('/(<.*>)[ ]*\n/', "$1------Lattice_NEWLINE------", $value);
		$value = preg_replace('/[ ]*\n/', '<br />', $value);
		$value = preg_replace('/------Lattice_NEWLINE------/', "\n", $value);
		return $value;
	}

	/*
	 *
	 */
	public static function resizeImage($originalfilename, $newfilename, $width, $height, $forceDimension='width', $crop='false'){
		//set up dimenion to key off of
		switch($forceDimension){
		case 'width':
			$keydimension = Image::WIDTH;
			break;
		case 'height':
			$keydimension = Image::HEIGHT;
			break;
		default:
			$keydimension = Image::AUTO;
			break;
		}

		$image = Image::factory(Graph::mediapath().$originalfilename);
		if($crop) {
			//resample with crop
			//set up sizes, and crop
			if( ($image->width / $image->height) > ($image->height / $image->width) ){
				$cropKeyDimension = Image::HEIGHT;
			} else {
				$cropKeyDimension = Image::WIDTH;
			}
			$image->resize($width, $height, $cropKeyDimension)->crop($width, $height);
			$image->save(Graph::mediapath().$newfilename);

		} else {
			//just do the resample
			//set up sizes
			$resizewidth = $width;
			$resizeheight = $height;

			if(isset($resize['aspectfollowsorientation']) && $resize['aspectfollowsorientation']){
				$osize = getimagesize(Graph::mediapath().$imagefilename);
				$horizontal = false;
				if($osize[0] > $osize[1]){
					//horizontal
					$horizontal = true;	
				}
				$newsize = array($resizewidth, $resizeheight);
				sort($newsize);
				if($horizontal){
					$resizewidth = $newsize[1];
					$resizeheight = $newsize[0];
				} else {
					$resizewidth = $newsize[0];
					$resizeheight = $newsize[1];
				}
			}

			//maintain aspect ratio
			//use the forcing when it applied
			//forcing with aspectfolloworientation is gonna give weird results!
			$image->resize($resizewidth, $resizeheight, $keydimension);

			$image->save(Graph::mediapath() .$newfilename);

		}

	}

   
	 protected function loadContentDriver(){
		 Kohana::$log->add(Kohana_Log::INFO, 'Loading content driver');

		 $objectTypeName = $this->objecttype->objecttypename;
		 if ($objectTypeName) {
			 if (Kohana::find_file('classes/model/lattice', strtolower($objectTypeName))) {
				 $modelName = 'Model_Lattice_' . $objectTypeName;
				 $model = new $modelName($objectId);
				 $this->contentDriver = $model;
			 } else {
				 $this->contentDriver = new Model_Lattice_Object();
			 }
			 if ($this->loaded()) {
				 $this->contentDriver->loadContentTable($this);
			 }
		 }
	 }





     /*
    *   Function: __get
    *     Custom getter for this model, links in appropriate content table
    *       when related object 'content' is requested
    *         */

   public function __get($column) {

         
      if (in_array($column, array_keys($this->_table_columns))){
         //this catchs the configured columsn for this table
         return parent::__get($column);
     
      } else if ($column == 'parent') {
				return $getLatticeParent(); 
      
      } else if ($column == 'objecttype'){
         //this condition should actually check against associations
         //OR just call parent::__get($column) with an exception
         //though that seems pretty messy
         $return = parent::__get($column);

       /*  if(!$return->loaded()){
            throw new Kohana_Exception('Objecttype model not loaded '. $this->id .':'.$this->objecttype_id);
         }*/
         return $return;
      } else if (in_array($column, array_keys($this->__get('objecttype')->_table_columns))){
  
        return $this->__get('objecttype')->$column; 
      } 
     
     
     
      
      if ($column == 'title'){
         return $this->contentDriver()->getTitle($this);
         
      } else {
         //check if this is a list container
         $listConfig = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list[@name="%s"]', $this->objecttype->objecttypename, $column));
         if ($listConfig->length) {
           
            //look up the object type
            $family = $column;
       
            $listObjectType = ORM::Factory('objecttype', $family);
            if (!$listObjectType->id) {
               $this->objecttype->configureElement($listConfig->item(0));
               $listObjectType = ORM::Factory('objecttype', $family);
            }

            $listContainerObject = ORM::Factory('listcontainer')
                    ->latticeChildrenFilter($this->id)
                    ->objectTypeFilter($listObjectType->id)
                    ->activeFilter()
                    ->find();
            //The next line is either necessary to correctly initialize the model
            //or listcontainer could be refactored as a storage class of object
            //Lattice_Model_...
            $listContainerObject = ORM::Factory('listcontainer', $listContainerObject->id);
            if (!$listContainerObject->id) {
               $listContainerObjectId = $this->addObject($family);
               $listContainerObject = ORM::Factory('listcontainer', $listContainerObjectId);
            }
            return $listContainerObject;
         }


				

				 return $this->contentDriver()->getContentColumn($this, $column);
 
      }
   }
   
   
   //Providing access to contentDriver as a quick fix for 
   //needing the id of the content table, plus there could
   //be other reasons that justify this.
   public function contentDriver(){
		 if(!$this->contentDriver){

			 $objectTypeName = $this->objecttype->objecttypename;

			 if ($objectTypeName) {
				 if (Kohana::find_file('classes/model/lattice', $objectTypeName)) {
					 $modelName = 'Model_Lattice_' . $objectTypeName;
					 $model = new $modelName($objectId);
					 $this->contentDriver = $model;
				 } else {
					 $this->contentDriver = new Model_Lattice_Object();
				 }
				 if ($this->loaded()) {
					 $this->contentDriver->loadContentTable($this);
				 }
			 }

		 }

		 return $this->contentDriver;
   
   }
   
    /*
     Function: save()
     Custom save function, makes sure the content table has a record when inserting new object
    */

   public function save(Validation $validation = NULL) {
      $inserting = false;
      if ($this->loaded() == FALSE) {
         $inserting = true;
      }

      parent::save();
      
      //Postpone adding record to content table until after lattice point
      //is set.
      if (!$inserting) {
        // throw new Kohana_Exception('what');
         $this->saveContentTable($this);
      }
      return $this;
     
      
   }
   

   private function insertContentRecord() {
   

      //create the content driver table
      $objectTypeName = $this->objecttype->objecttypename;
      if (Kohana::find_file('classes/model/lattice', $objectTypeName)) {
         $modelName = 'Model_Lattice_' . $objectTypeName;
         $model = new $modelName($objectId);
         $this->contentDriver = $model;
      } else {
         $this->contentDriver = new Model_Lattice_Object();
      }
      //$this->contentDriver->loadContentTable($this);
      //$this->contentDriver->setContentColumn($this, 'object_id', $this->id);
      $this->contentDriver->saveContentTable($this, true);
   }

   private function saveContentTable() {

      $this->contentDriver()->saveContentTable($this);
   }
   
	 public function getElementConfig($elementName){

		 if ($this->__get('objecttype')->nodeType == 'container') {
			 //For lists, values will be on the 2nd level 
			 $xPath = sprintf('//list[@name="%s"]', $this->__get('objecttype')->objecttypename);
		 } else {
			 //everything else is a normal lookup
			 $xPath = sprintf('//objectType[@name="%s"]', $this->__get('objecttype')->objecttypename);
		 }
      $fieldConfig = lattice::config('objects', $xPath . sprintf('/elements/*[@name="%s"]', $elementName));
      return $fieldConfig;
   }

   /*
     Function: __set
     Custom setter, saves to appropriate contentDriver
    */

   public function __set($column, $value) {

      if (!$this->_loaded) {
         //Bypass special logic when just loading the object
         return parent::__set($column, $value);
      }

      if (!is_object($value)) {
         $value = Model_Object::convertNewlines($value);
      }


      if ($column == 'slug') {
         parent::__set('slug', Model_Object::createSlug($value, $this->id));
         parent::__set('decoupleSlugTitle', 1);
        // $this->save();
         return;
      } else if ($column == 'title') {
         if (!$this->decoupleSlugTitle) {
            $this->slug = Model_Object::createSlug($value, $this->id);
         }
         //$this->save();
         $this->contentDriver()->setTitle($this, $value);
         //$this->save();
         return;
      } else if (in_array($column, array('dateadded'))) {
         parent::__set($column, $value);
         //$this->save();
      } else if ($this->_table_columns && in_array($column, array_keys($this->_table_columns))) {
         parent::__set($column, $value);
         //$this->save();
      } else if ($column) {
         $o = $this->_object;
         $objecttype_id = $o['objecttype_id'];

         $objectType = ORM::Factory('objecttype', $objecttype_id);

         $xpath = sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $objectType->objecttypename, $column);
         $fieldInfo = lattice::config('objects', $xpath)->item(0);
         if (!$fieldInfo) {
            throw new Kohana_Exception('Invalid field for objectType, using XPath : :xpath', array(':xpath' => $xpath));
         }


         $this->contentDriver()->setContentColumn($this, $column, $value);
      } else {
         throw new Kohana_Exception('Invalid POST Arguments, POST must contain field and value parameters');
      }
      
   }
   
  

	public function cascadeUndelete(){
		$this->activity = new Database_Expression(null);
		$this->slug = Model_Object::createSlug($this->contenttable->title, $this->id);
		$this->contentdriver()->undelete();
		$this->save();

		$children = $object->getLatticeChildren();
		foreach($children as $child){
			$child->cascadeUndelete();
		}


	}

	public function cascadeDelete(){
		$this->activity = 'D';
		$this->slug = DB::expr('null');
		$this->save();
      $this->contentdriver()->delete();


		$children = $this->getLatticeChildren();
		foreach($children as $child){
			$child->cascadeDelete();
		}
	}
   
   /*
    * Functions for returning messages
    * This could be used for error handling possibly, but needs more 
    * work on letting the controller know how to communication with the
    * presentation/client layer.
    */
   protected function addMessage($message){
      $this->messages[] = $message;
   }

   public function getMessages(){
      return $this->messages;
   }
   
   
   public function translate($languageCode){
      $rosettaId = $this->rosetta_id;
			if(!$rosettaId){
				throw new Kohana_Exception('No Rosetta ID found for object during translation with objectId :objectId',
					array(':objectId'=>$rosettaId)
				);
      }
      if(is_numeric($languageCode)){
         $languageId = intval($languageCode);
      } else {
         //this could just ask the graph, to avoid going to database again
         $languageId = ORM::Factory('language', $languageCode)->id;
      }
      if(!$languageId){
         throw new Kohana_Exception('Invalid language code :code', array(':code'=>$languageCode));
      }
         
      $translatedObject = Graph::object()
              ->where('rosetta_id', '=', $rosettaId)
              ->where('language_id', '=', $languageId)
              ->find();
      if(!$translatedObject->loaded()){
         throw new Kohana_Exception('No translated object available for objectId :id with language :language',
                 array(':id'=>$objectId,
                        ':language'=>$languageCode));
         
      }
      return $translatedObject;
      
   }
   
   public function updateWithArray($data) {
      foreach ($data as $field => $value) {
         switch ($field) {
            case 'slug':
            case 'decoupleSlugTitle':
            case 'dateAdded':
            case 'published':
            case 'activity':
               $this->__set($field, $value);
               break;
            default:
               $this->$field = $value;
               break;
         }
      }
      $this->save();
      return $this->id;
   }

   public function getContentAsArray() {

      $fields = ORM::Factory('objectmap')
              ->where('objecttype_id', '=', $this->objecttype->id)
              ->find_all();
      foreach ($fields as $map) {
         $content[$map->column] = $this->__get($map->column);
      }
      return $content;
   }

   public function setDataQueryWhere($key, $value) {
      $this->dataQueryTargets = array();
   }

   public function addTag($tagName) {
      $tag = ORM::Factory('tag')->where('tag', '=', $tagName)->find();
      if (!$tag->loaded()) {
         $tag = ORM::Factory('tag');
         $tag->tag = $tagName;
         $tag->language_id = $this->language_id;
         $tag->save();
      }
      $this->add('tag', $tag);
      return $this;
   }

   public function removeTag($tagName) {
      $tag = ORM::Factory('tag')->where('tag', '=', $tagName)->find();
      if (!$tag->loaded()) {
         throw new Kohana_Exception("Tag :tagName does not exist in the database.", array(':tagName' => $tagName));
      }
      $this->remove('tag', $tag);
      return $this;
   }

	 public function getTagObjects() {
		 $tagObjects = ORM::Factory('objects_tag')
			 ->select('*')
			 ->select('tag')
			 ->where('object_id', '=', $this->id)
			 ->join('tags')->on('tag_id', '=', 'tags.id')
			 ->find_all();
		 return $tagObjects;
	 }

	 public function getTagStrings() {
		 $tagObjects = $this->getTagObjects();
		 $tags = array();
		 foreach ($tagObjects as $tagObject) {
			 $tags[] = $tagObject->tag;
		 }
		 return $tags;

	 }

   public function getPublishedObjectBySlug($slug) {

      return $this->where('slug', '=', $slug)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->find();
   }

   public function getContent() {
      return $this->getPageContent();
   }

   public function getPageContent() {
      $content = array();
      $content['id'] = $this->id;
      $content['title'] = $this->title;
      $content['slug'] = $this->slug;
      $content['dateadded'] = $this->dateadded;
      $content['objectTypeName'] = $this->objecttype->objecttypename;

      $fields = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*', $this->objecttype->objecttypename));

      foreach ($fields as $fieldInfo) {
         $field = $fieldInfo->getAttribute('name');
     //    if (lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $this->objecttype->objecttypename, $field))->length) {
            $content[$field] = $this->__get($field);
      //   }
      }

      //find any lists
      foreach (lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list', $this->objecttype->objecttypename)) as $list) {

         $family = $list->getAttribute('name');
         $content[$family] = $this->getListContentAsArray($family);
      }

      return $content;
   }
   
   public function getFields() {
      $fields = array('id', 'title', 'slug', 'dateadded', 'objecttypename');
      
      $objectFields = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*', $this->objecttype->objecttypename));
      foreach ($objectFields as $fieldInfo) {
         $fields[] = $fieldInfo->getAttribute('name');   
      }

      foreach (lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list', $this->objecttype->objecttypename)) as $list) {
         $family = $list->getAttribute('name');
         $fields[] = $family;
      }
   
      return $fields;
   
   }

   public function getListContentAsArray($family) {
      $iter = $this->getListContent($family);
      $content = array();
      foreach ($iter as $item) {
         $content[] = $item->getPageContent();
      }
      return $content;
   }

   public function getListContent($family) {
      //get container
      $cTemplate = ORM::Factory('objecttype', $family);
      $container = Graph::object()
							->latticeChildrenFilter($this->id)
              ->where('objecttype_id', '=', $cTemplate->id)
              ->where('activity', 'IS', NULL)
              ->find();

      return $container->getPublishedChildren();
   }

   public function getPublishedChildren() {

      $children = Graph::object()
							->latticeChildrenFilter($this->id)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->order_by('objectrelationships.sortorder')
							->join('objecttypes')->on('objects.objecttype_id', '=', 'objecttypes.id')
							->where('nodeType', '!=', 'container')
              ->find_all();
      return $children;
   }

   public function getChildren() {

      return $this->getLatticeChildren();
   }
   
   public function getLatticeChildren($lattice = 'lattice'){
      $children = Graph::object()
							->latticeChildrenFilter($this->id, $lattice)
              ->where('activity', 'IS', NULL)
              ->order_by('objectrelationships.sortorder')
              ->find_all();
      return $children;
   
   }

   public function getNextPublishedPeer() {
      $next = Graph::object()
							->latticeChildrenFilter($this->getLatticeParent()->id)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->order_by('objectrelationships.sortorder', 'ASC')
              ->where('sortorder', '>', $this->sortorder)
              ->limit(1)
              ->find();
      if ($next->loaded()) {
         return $next;
      } else {
         return null;
      }
   }

   public function getPrevPublishedPeer() {
      $next = Graph::object()
							->latticeChildrenFilter($this->getLatticeParent()->id)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->order_by('objectrelationships.sortorder',  'DESC')
              ->where('sortorder', '<', $this->sortorder)
              ->limit(1)
              ->find();
      if ($next->loaded()) {
         return $next;
      } else {
         return null;
      }
   }

   public function getFirstPublishedPeer() {
      $first = Graph::object()
							->latticeChildrenFilter($this->getLatticeParent()->id)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->order_by('objectrelationships.sortorder', 'ASC')
              ->limit(1)
              ->find();
      if ($first->loaded()) {
         return $first;
      } else {
         return null;
      }
   }

   public function getLastPublishedPeer() {
      $last = Graph::object()
							->latticeChildrenFilter($this->getLatticeParent()->id)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->order_by('objectrelationships.sortorder', 'DESC')
              ->limit(1)
              ->find();
      if ($last->loaded()) {
         return $last;
      } else {
         return null;
      }
   }
   
   public function setSortOrder($order, $lattice='lattice') {
      $lattice = Graph::lattice($lattice);

      for ($i = 0; $i < count($order); $i++) {
         if (!is_numeric($order[$i])) {
            throw new Kohana_Exception('bad sortorder string: >' . $order[$i] . '<');
         }

         $objectRelationship = ORM::Factory('objectrelationship')
                 ->where('object_id', '=', $this->id)
                 ->where('lattice_id', '=', $lattice->id)
                 ->where('connectedobject_id', '=', $order[$i])
                 ->find();
         if(!$objectRelationship->loaded()){
            throw new Kohana_Exception('No object relationship found matching sort order object_id :object_id, lattice_id :lattice_id, connectedobject_id :connectedobject_id',
                    array(':object_id' => $this->id,
                        ':lattice_id' => $lattice->id,
                        ':connectedobject_id' => $order[$i]
                    )
            );
         }
         $objectRelationship->sortorder = $i;
         $objectRelationship->save();
      }
   }


   public function saveField($field, $value) {
      $this->__set($field, $value);
      $this->save();
      return $this->$field;
   }

   public function saveUploadedFile($field, $filename, $type, $tmpName) {
      $tmpName = $this->moveUploadedFileToTmpMedia($tmpName);
      return $this->saveFile($field, $filename, $type, $tmpName);
   }

   /*
    *
    * 	Returns: file model of saved file
    * */

   public function saveUploadedImage($field, $filename, $type, $tmpName, $additionalResizes=array()) {
      $tmpName = $this->moveUploadedFileToTmpMedia($tmpName);
      Kohana::$log->add(Log::INFO, 'clling save image' . $filename);
      $file = $this->saveImage($field, $filename, $type, $tmpName, $additionalResizes);

      return $file;
   }

   private function moveUploadedFileToTmpMedia($tmpName) {
      $saveName = Model_Object::makeFileSaveName('tmp') . microtime();

      if (!move_uploaded_file($tmpName, Graph::mediapath() . $saveName)) {
         $result = array(
             'result' => 'failed',
             'error' => 'internal error, contact system administrator',
         );
         return $result;
      }
      Kohana::$log->add(Log::INFO, 'tmp moved file to ' . Graph::mediapath() . $saveName);

      return $saveName;
   }
   
   public static function makeFileSaveName($filename) {
			if(!$filename){
				return null;
			}
      $filename = str_replace('&', '_', $filename);
      $xarray = explode('.', $filename);
      $nr = count($xarray);
      $ext = $xarray[$nr - 1];
      $name = array_slice($xarray, 0, $nr - 1);
      $name = implode('.', $name);
      $i = 1;
      if (!file_exists(Graph::mediapath() . "$name" . '.' . $ext)) {
         $i = '';
      } else {
         for (; file_exists(Graph::mediapath() . "$name" . $i . '.' . $ext); $i++) {     
         }
      }
      //clean up extension
      $ext = strtolower($ext);
      if ($ext == 'jpeg') {
         $ext = 'jpg';
      }
      return $name . $i . '.' . $ext;
   }

   public function saveFile($field, $filename, $type, $tmpName) {
      if (!is_object($file = $this->__get($field))) {
         $file = ORM::Factory('file', $this->__get($field));
      }
      
      $replacingEmptyFile = false;
      if(!$file->filename){
         $replacingEmptyFile = true;
      }

      $file->unlinkOldFile();
      $saveName = Model_Object::makeFileSaveName($filename);

      if (!copy(Graph::mediapath() . $tmpName, Graph::mediapath() . $saveName)) {
         throw new Lattice_Exception('this is a MOP Exception');
      }
      unlink(Graph::mediapath() . $tmpName);

      $file->filename = $saveName;
      $file->mime = $type;
      $file->save(); //inserts or updates depending on if it got loaded above

      $this->$field = $file->id;
      $this->save();
      
      //Handle localized object linked via rosetta
      if($replacingEmptyFile){
         
         $languages = Graph::languages();
         foreach ($languages as $translationLanguage) {
           
            if ($translationLanguage->id == $this->language_id) {
               continue;
            }

            $translatedObject = $this->translate($translationLanguage->id);
            $translatedObject->$field = $file->id;
            $translatedObject->save();

         }   
      }
      
      return $file;
   }

   public function verifyImage($field, $tmpName) {
      $origwidth = $size[0];
      $origheight = $size[1];
      Kohana::$log->add(Log::INFO, var_export($parameters, true));
      if (isset($parameters['minheight']) && $origheight < $parameters['minheight']) {
         $result = array(
             'result' => 'failed',
             'error' => 'Image height less than minimum height',
         );
         return $result;
      }
      if (isset($parameters['minwidth']) && $origwidth < $parameters['minwidth']) {
         $result = array(
             'result' => 'failed',
             'error' => 'Image width less than minimum width',
         );
         return $result;
      }
      Kohana::$log->add(Log::INFO, "passed min tests with {$origwidth} x {$origheight}");
   }

   public function saveImage($field, $filename, $type, $tmpName, $additionalResizes = array() ) {
      //do the saving of the file
      $file = $this->saveFile($field, $filename, $type, $tmpName);
      $imagefilename = $this->processImage($file->filename, $field, $additionalResizes );

      return $file;
   }

   /*
    * Functon: processImage($filename, $parameters)
    * Create all automatice resizes on this image
    */

   public function processImage($filename, $field, $additionalResizes = array()) {

			Kohana::$log->add(Log::INFO, 'inasdf asdf asd f');
      //First check for tiff, and convert if necessary
      $ext = substr(strrchr($filename, '.'), 1);
      switch ($ext) {
         case 'tiff':
         case 'tif':
         case 'TIFF':
         case 'TIF':
            Kohana::$log->add(Log::INFO, 'Converting TIFF image to JPG for resize');

            $imagefilename = $filename . '_converted.jpg';
            $command = sprintf('convert %s %s', addcslashes(Graph::mediapath() . $filename, "'\"\\ "), addcslashes(Graph::mediapath() . $imagefilename, "'\"\\ "));
            Kohana::$log->add(Log::INFO, $command);
            system(sprintf('convert %s %s', addcslashes(Graph::mediapath() . $filename, "'\"\\ "), addcslashes(Graph::mediapath() . $imagefilename, "'\"\\ ")));
            break;
         default:
            $imagefilename = $filename;
            break;
      }

      //do the resizing
      $objecttypename = $this->objecttype->objecttypename;
      $resizes = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]/resize', $objecttypename, $field
                      )
      );
			Kohana::$log->add(Log::INFO, 'printing out resizess');
			Kohana::$log->add(Log::INFO, var_export($additionalResizes, true));
      foreach ($resizes as $resize) {

         if ($prefix = $resize->getAttribute('name')) {
            $prefix = $prefix . '_';
         } else {
            $prefix = '';
         }
         $newfilename = $prefix . $imagefilename;
         $saveName = Graph::mediapath() . $newfilename;

				 //This dependency should be moved out of latticecms
				 //Rootgraph should never require latticecms
         Model_Object::resizeImage($imagefilename, $newfilename, $resize->getAttribute('width'), $resize->getAttribute('height'), $resize->getAttribute('forceDimension'), $resize->getAttribute('crop')
         );

         if (isset($oldfilename) && $newfilename != $prefix . $oldfilename) {
            if (file_exists(Graph::mediapath() . $oldfilename)) {
               unlink(Graph::mediapath() . $oldfilename);
            }
         }
      }

			//And process resizes passed in from caller
      foreach($additionalResizes as $uiresize){
        Model_Object::resizeImage($imagefilename, $uiresize['prefix'] . '_' . $imagefilename, $uiresize['width'], $uiresize['height'], $uiresize['forceDimension'], $uiresize['crop']);
      }


      return $imagefilename;
   }

   //this is gonna change a lot!
   //this only supports a very special case of multiSelect objects
   /*
    * 
    * Likely No longer used and can be removed
    * 
    */
   public function saveObject() {
      /*
      $object = ORM::Factory('object', $this->content table->$field);
      if (!$object->objecttype_id) {
         $object->objecttype_id = 0;
      }

      $element['options'] = array();
      foreach (Kohana::config('cms.objectTypes.' . $object->objecttype->objecttypename) as $field) {
         if ($field['type'] == 'checkbox') {
            $options = $field['field'];
         }
      }
      foreach ($options as $field) {
         $object->$field = 0;
      }

      foreach ($_POST['values'] as $value) {
         $object->$value = 1;
      }
      $object->save();
      return true;*/
      
   }

   /* Query Filters */

   public function objectTypeFilter($objectTypes) {
      if (!$objectTypes) {
         return $this;
      }
      
      if(is_numeric($objectTypes)){
         $this->where('objecttype_id', '=', $objectTypes);
      } else if (strpos(',', $objectTypes)) {
         $tNames = explode(',', $objectTypes);
         $tIds = array();
         foreach ($tNames as $tname) {
            $result = DB::query("Select id from objecttypes where objecttypename = '$objectTypes'")->execute();
            if(!$result->current->id && !Model_ObjectType::getConfig($tname)){
             throw new Kohana_Exception('Invalid object type requested in objectTypeFilter '.$objectTypes);
            }
            $tIds[] = $result->current()->id;
         }
         $this->in('objecttype_id', $tIds);
      } else if ($objectTypes == 'all') {
         //set no filter
      } else {
         $objectType = $objectTypes; // argument is just a singluar string
         $result = DB::query(Database::SELECT, "Select id from objecttypes where objecttypename = '$objectType'")->execute()->current();
          if(!$result['id'] && !Model_ObjectType::getConfig($objectType)){
             throw new Kohana_Exception('Invalid object type requested in objectTypeFilter '.$objectType);
          }
         $this->where('objecttype_id', '=', $result['id']);
      }
      return $this;
   }

	 /*
		* Recode as latticeParentFilter
   public function parentFilter($parentid) {
      $this->where('parentid', '=', $parentid);
	 }
		*/

   public function noContainerObjects() {
      $res = ORM::Factory('objecttype')
              ->where('nodeType', '=', 'container')
              ->find_all();
      $tIds = array();
      foreach ($res as $container) {
         $tIds[] = $container->id;
      }
      if (count($tIds)) {
         $this->where('objecttype_id', 'NOT IN', DB::Expr('(' . implode(',', $tIds) . ')'));
      }
      return $this;
   }

   public function publishedFilter() {
      $this->where('published', '=', 1);
      $this->activeFilter();
      return $this;
   }
   
   public function activeFilter(){
    $this->where('activity', 'IS', NULL);
    return $this;   
   }

   public function taggedFilter() {
      
   }

   public function latticeChildrenFilter($parentId, $lattice="lattice"){
      $lattice = Graph::lattice($lattice);
       
      $this->join('objectrelationships', 'LEFT')->on('objects.id', '=', 'objectrelationships.connectedobject_id');
      $this->where('objectrelationships.lattice_id', '=', $lattice->id);
      $this->where('objectrelationships.object_id', '=', $parentId);
      return $this;

   }
   
   public function latticeChildrenQuery($lattice='lattice'){
      return Graph::instance()->latticeChildrenFilter($this->id, $lattice);
   
   }

	 public function getLatticeParent($lattice='lattice'){

		 $latticeParents =  $this->getLatticeParents($lattice);
		 if(count($latticeParents)){
			 return $latticeParents[0];
		 } else {
			 return NULL;
		 }
	 }

	 public function getLatticeParents($lattice='lattice'){
		 if(!isset($this->latticeParents[$lattice])){
				$this->latticeParents[$lattice] = array();
		 }
		 $latticeO = Graph::lattice($lattice);
		 $relationships = ORM::Factory('objectrelationship')
			 ->where('lattice_id', '=', $latticeO->id)
			 ->where('connectedobject_id', '=', $this->id)
			 ->find_all();
		 foreach($relationships as $relationship){
			 if($relationship->loaded()){
				 $this->latticeParents[$lattice][] = Graph::object($relationship->object_id);
			 }
		 }
		 return $this->latticeParents[$lattice];
	 }
   
   /*
     Function: addLatticeObject($id)
     Private function for adding an object to the cms data
     Parameters:
     id - the id of the parent category
     objecttype_id - the type of object to add
     $data - possible array of keys and values to initialize with
     Returns: the new object id
    */

   /* Consider moving this into Object, and creating a hidden top level object that contains these objects
    * then hidden objects or other kinds of data can be stored, but not within the cms object tree
    * This makes sense for separating the CMS from the graph, and containing all addObject code within the model.
    * */

   
  
   
   //'addTranslatableObject'
   public function addObject($objectTypeName, $data = array(), $lattice = null, $rosettaId = null, $languageId = null) {
      
      $newObjectType = ORM::Factory('objecttype', $objectTypeName);

      $newObject = $this->addLatticeObject($objectTypeName, $data, $lattice, $rosettaId, $languageId);
     
      
      /*
       * Set up any translated peer objects
       */
      if (!$rosettaId) {
         $languages = Graph::languages();
         foreach ($languages as $translationLanguage) {
           
            if ($translationLanguage->id == $newObject->language_id) {
               continue;
            }

            if ($this->loaded()) {
               $translatedParent = $this->getTranslatedObject($translationLanguage->id);
          
               $translatedParent->addLatticeObject($newObject->objecttype->objecttypename, $data, $lattice, $newObject->rosetta_id, $translationLanguage->id);
            } else {
               Graph::object()->addLatticeObject($newObject->objecttype->objecttypename, $data, $lattice,  $newObject->rosetta_id, $translationLanguage->id);
            }

         }
      }

      /*
       * adding of components is delayed until after alternate language objects creates,
       * because data trees need to be built before components go looking for rosetta ids
       */
      $newObject->addComponents();

      return $newObject->id;

   }
   
  
   
   /*
    * Called only at object creation time, this function add automatic components to an object as children and also recurses
    * this functionality down the tree.
    */
   private function addComponents(){


       //chain problem
      $containers = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list', $this->objecttype->objecttypename));
      foreach ($containers as $c) {
         $arguments['title'] = $c->getAttribute('label');
         if(! ORM::Factory('objecttype', $c->getAttribute('name'))->loaded()){
            $this->objecttype->configureElement($c);
         }
         $this->addObject($c->getAttribute('name'), $arguments);
      }
      
      //look up any components and add them as well
      //configured components
      $components = lattice::config('objects', sprintf('//objectType[@name="%s"]/components/component', $this->objecttype->objecttypename));
      foreach ($components as $c) {
         $arguments = array();
         if ($label = $c->getAttribute('label')) {
            $arguments['title'] = $label;
         }
         if ($c->hasChildNodes()) {
            foreach ($c->childNodes as $data) {
               $arguments[$data->tagName] = $data->value;
            }
         }
         //We have a problem here
         //with data.xml populated components
         //the item has already been added by the addObject recursion, but gets added again here
         //what to do about this??/on
         
         $componentAlreadyPresent = false;
         if(isset($arguments['title'])){
            $checkForPreexistingObject = Graph::object()
                 ->latticeChildrenFilter($this->id)
                 ->join('contents', 'LEFT')->on('objects.id',  '=', 'contents.object_id')
                 ->where('title', '=', $arguments['title'])
                 ->find();
            if($checkForPreexistingObject->loaded()){
              $componentAlreadyPresent = true;
            }
         }
                 
         if(!$componentAlreadyPresent){
            $this->addObject($c->getAttribute('objectTypeName'), $arguments);
         }
      }
    

   }
   
   
   public function setObjectType($objectTypeClassOrName) {
      $objectType = null;
      if (!is_object($objectTypeClassOrName)) {
         
         $objectTypeName = $objectTypeClassOrName;
         
         $objectType = ORM::Factory('objecttype', $objectTypeName);

         if (!$objectType->id) {


            //check objects.xml for configuration
            if ($objectTypeConfig = lattice::config('objects', sprintf('//objectType[@name="%s"]', $objectTypeName))->item(0)) {
               //there's a config for this objectType
               //go ahead and configure it
               Graph::configureObjectType($objectTypeName);
               $objectType = ORM::Factory('objecttype', $objectTypeName);
            } else {
               throw new Kohana_Exception('No config for objectType ' . $objectTypeName);
            }
         }
      } else {
         $objectType = $objectTypeClassOrName;
      }
      $this->objecttype_id = $objectType->id;
      $this->__set('objecttype', $objectType);
      
      return $this; //chainable
   }
   
    private function createObject($objectTypeName, $rosettaId, $languageId){
       
      if(!$rosettaId){
         $translationRosettaId = Graph::newRosetta();
      } else {
         $translationRosettaId = $rosettaId;
      }
      
      
      if ($languageId == NULL) {
         if ($this->language_id == NULL) {
            $languageId = Graph::defaultLanguage();
         } else {
            $languageId = $this->language_id;
         }
      }
      
      $newObject = Graph::object();
      $newObject->setObjectType($objectTypeName);
      
      

      //create slug
      if (isset($data['title'])) {
        $newObject->slug = Model_Object::createSlug($data['title'], $newObject->id);
      } else {
         $newObject->slug = Model_Object::createSlug();
      }
     
      $newObject->language_id = $languageId;
      $newObject->rosetta_id = $translationRosettaId;
      

      //check for enabled publish/unpublish. 
      //if not enabled, insert as published
      $tSettings = lattice::config('objects', sprintf('//objectType[@name="%s"]', $newObject->objecttype->objecttypename));
      $tSettings = $tSettings->item(0);
      $newObject->published = 1;
      if ($tSettings) { //entry won't exist for Container objects
         if ($tSettings->getAttribute('allowTogglePublish') == 'true') {
            $newObject->published = 0;
         }
      }

      $newObject->save();
     
      return $newObject;
    }
    
    private function updateContentData($data){
       if(!count($data)){
          return $this;
       }
      
      if (isset($data['published']) && $data['published']) {
         $this->published = 1;
         unset($data['published']);
      }
      
      //Add defaults to content table
      //This needs to happen after the lattice point is set
      //in case content tables are dependent on lattice point


      $lookupTemplates = lattice::config('objects', '//objectType');
      $objectTypes = array();
      foreach ($lookupTemplates as $tConfig) {
         $objectTypes[] = $tConfig->getAttribute('name');
      }
      //add submitted data to content table
      foreach ($data as $field => $value) {
    
         //need to switch here on type of field
         switch ($field) {
            case 'slug':
            case 'decoupleSlugTitle':
               $this->$field = $data[$field];
               continue(2);
            case 'title':
               $this->$field = $data[$field];
               continue(2);
         }

         $fieldInfoXPath = sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $this->objecttype->objecttypename, $field);
         $fieldInfo = lattice::config('objects', $fieldInfoXPath)->item(0);
         if (!$fieldInfo) {
            throw new Kohana_Exception("No field info found in objects.xml while adding new object, using Xpath :xpath", array(':xpath' => $fieldInfoXPath));
         }

         if (in_array($fieldInfo->tagName, $objectTypes) && is_array($value)) {
            $clusterTemplateName = $fieldInfo->tagName;
            $clusterObjectId = Graph::object()->addObject($clusterTemplateName, $value); //adding object to null parent
            $this->$field = $clusterObjectId;
            continue;
         }


         switch ($fieldInfo->tagName) {
            case 'file':
            case 'image':
               //need to get the file out of the FILES array

               Kohana::$log->add(Log::ERROR, var_export($_POST, true));
               Kohana::$log->add(Log::ERROR, var_export($_FILES, true));

               if (isset($_FILES[$field])) {
                  Kohana::$log->add(Log::ERROR, 'Adding via post file');
                  $file = Model_Object::saveHttpPostFile($this->id, $field, $_FILES[$field]);
               } else {
                  $file = ORM::Factory('file');
                  $file->filename = $value;
                  $file->save();
                  $this->$field = $file->id;
               }
               break;
            default:
               $this->$field = $data[$field];
               break;
         }
      }
      $this->save();
      return $this;
   
   }
   
  
   
   /*
    * function addElementObject
    * An element object is an object that is part of another object's content. Examples
    * include links, files or images (in the coming full implementation) or other
    * user defined complex objects.
    * 
    */
   
   public function addElementObject($objectTypeName, $elementName, $data=array(), $rosettaId = null, $languageId = null){
      $newObjectType = ORM::Factory('objecttype', $objectTypeName);
      
      $newObject = $this->createObject($objectTypeName, $rosettaId, $languageId);

      
      //and set up the element relationship
      $elementRelationship = ORM::Factory('objectelementrelationship');
      $elementRelationship->object_id = $this->id;
      $elementRelationship->elementobject_id = $newObject->id;
      $elementRelationship->name = $elementName;
      $elementRelationship->save();
      
      //Postpone dealing with content record until after lattice point is set
      //in case content table logic depends on lattice point.
      $newObject->insertContentRecord();
      $newObject->updateContentData($data);
      
      /*
       * Set up any translated peer objects
       */
      if (!$rosettaId) {
         $languages = Graph::languages();
         foreach ($languages as $translationLanguage) {
           
            if ($translationLanguage->id == $newObject->language_id) {
               continue;
            }

            if ($this->loaded()) {
               $translatedParent = $this->getTranslatedObject($translationLanguage->id);
          
               $translatedParent->addElementObject($newObject->objecttype->objecttypename, $elementName, $data, $newObject->rosetta_id, $translationLanguage->id);
            } else {
               Graph::object()->addElementObject($newObject->objecttype->objecttypename, $elementName, $data, $newObject->rosetta_id, $translationLanguage->id);
            }

         }
      }

      /*
       * adding of components is delayed until after alternate language objects creates,
       * because data trees need to be built before components go looking for rosetta ids
       * elementObjects will almost never have components, but we support it anyway
       */
      $newObject->addComponents();

      return $newObject;
  
   }
    
   private function addLatticeObject($objectTypeName, $data = array(), $lattice = null, $rosettaId = null, $languageId = null){
      
      $newObject = $this->createObject($objectTypeName, $rosettaId, $languageId);

      //The objet has been built, now set it's lattice point
      $lattice = Graph::lattice();
      $objectRelationship = ORM::Factory('objectrelationship');
      $objectRelationship->lattice_id = $lattice->id;
      $objectRelationship->object_id = $this->id;
      $objectRelationship->connectedobject_id = $newObject->id;
      $objectRelationship->save();
      $newObject->insertContentRecord();
  
      //die($newObject->id);
      $newObject->updateContentData($data);

      
      //calculate sort order
      $sort = DB::select('sortorder')->from('objectrelationships')
                        ->where('lattice_id', '=', $lattice->id)
                        ->where('object_id', '=', $this->id)
                      ->order_by('sortorder','DESC')->limit(1)
                      ->execute()->current();
      $objectRelationship->sortorder = $sort['sortorder'] + 1;
    
      $objectRelationship->save();
      return $newObject;
   
   }
   
   public function getTranslatedObject($languageId){
       $parentRosettaId = $this->rosetta_id;
       $translatedObject = Graph::object()
               ->where('rosetta_id', '=', $this->rosetta_id)
               ->where('language_id', '=', $languageId)
               ->find();
       if(!$translatedObject->loaded()){
          throw new Kohana_Exception('No matching translated object for rosetta :rosetta and language :language',
                  array(':rosetta'=>$this->rosetta_id,
                        ':language'=>$languageId)
                  );
       }
       return $translatedObject;
   }

}
?>
