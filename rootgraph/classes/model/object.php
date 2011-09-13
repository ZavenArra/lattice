<?php

/*
 * To change this objectType, choose Tools | Templates
 * and open the objectType in the editor.
 */

/**
 * Model for Object
 *
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

	
	 private $latticeParents = array();

   private $object_fields = array('loaded', 'objecttype', 'primary_key', 'primary_val');


   public function __construct($id=NULL) {
      
      
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id)) {
         
         //check for translation reference
         if(strpos('_', $id)){
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
   }


   /*
    *   Function: __get
    *     Custom getter for this model, links in appropriate content table
    *       when related object 'content' is requested
    *         */

   public function __get($column) {

      if ($column == 'contenttable' && !isset($this->_related[$column])) {
         $content = ORM::factory(inflector::singular('contents'));
         $content->setTemplateName($this->objecttype->objecttypename); //set the objecttypename for dbmapping
         $this->_related[$column] = $content->where('object_id', '=', $this->id)->find();
         if (!$this->_related[$column]->_loaded) {
            //we are going to allow no content object
            //in order to support having empty objects
            //throw new Kohana_Exception('BAD_Lattice_DB' . 'no content record for object ' . $this->id);
         }
         return $this->_related[$column];
      } else if (in_array($column, array_keys($this->_table_columns))){
         //this catchs the configured columsn for this table
         Kohana::$log->add(Log::INFO, $column);
         return parent::__get($column);
     
      } else if ($column == 'parent') {
				return $getLatticeParent(); 
      } else if ($column == 'contenttable'){
         return parent::__get($column);
      } else if ($column == 'title'){
         return $this->contenttable->title;
      } else if ($column == 'objecttype'){
        
         //this condition should actually check against associations
         //OR just call parent::__get($column) with an exception
         //though that seems pretty messy
         return parent::__get($column);
      } else if (in_array($column, array_keys($this->__get('objecttype')->_table_columns))){
  
        return $this->__get('objecttype')->$column; 
      } else {
				//check if this is a list container
				$listConfig = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/list[@name="%s"]',
					$this->objecttype->objecttypename,
					$column));
				if($listConfig->length){
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
               
               if(!$listContainerObject->id){
                  $listContainerObjectId = $this->addObject($family);
                  $listContainerObject = ORM::Factory('listcontainer', $listContainerObjectId);
               }
               return $listContainerObject;
				}
				return $this->contenttable->$column;
 
      }
   }

   /*
     Function: __set
     Custom setter, saves to appropriate contenttable
    */

   public function __set($column, $value) {
      
      if(!$this->_loaded){
         //Bypass special logic when just loading the object
         return parent::__set($column, $value);
      }
      
      
      
      if ($column == 'contenttable') {
         $this->_changed[$column] = $column;

         // Object is no longer saved
         $this->_saved = FALSE;

         $this->object[$column] = $this->load_type($column, $value);
      } else {
         if (!is_object($value)) {
            $value = latticecms::convertNewlines($value);
         }

         
         if ($column == 'slug') {
            parent::__set('slug', latticecms::createSlug($value, $this->id));
            parent::__set('decoupleSlugTitle', 1);
            $this->save();
            return;
         } else if ($column == 'title') {
            if (!$this->decoupleSlugTitle) {
               $this->slug = latticecms::createSlug($value, $this->id);
            }
            $this->save();
            $this->contenttable->title = $value;
            $this->contenttable->save();
            return;
         } else if (in_array($column, array('dateadded'))) {
            parent::__set($column, $value);
            $this->save();
         } else if($this->_table_columns && in_array($column, array_keys($this->_table_columns))){
            parent::__set($column, $value);
            $this->save();
            
         } else if ($column) {
            $o = $this->_object;
            $objecttype_id = $o['objecttype_id'];
            
            $objectType = ORM::Factory('objecttype',$objecttype_id);
            
            $xpath = sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $objectType->objecttypename, $column);
            $fieldInfo = lattice::config('objects', $xpath)->item(0);
            if (!$fieldInfo) {
               throw new Kohana_Exception('Invalid field for objectType, using XPath : :xpath', array(':xpath' => $xpath));
            }

            $this->contenttable->$column = $value;
            $this->contenttable->save();

         } else {
            throw new Kohana_Exception('Invalid POST Arguments, POST must contain field and value parameters');
         }
      }
   }

   /*
     Function: save()
     Custom save function, makes sure the content table has a record when inserting new object
    */

   public function save(Validation $validation = NULL) {

      $inserting = false;
      if ($this->_loaded == FALSE) {
         $inserting = true;
      }

      parent::save();
      //if inserting, we add a record to the content table if one does not already exists
      if ($inserting) {
				$content = ORM::Factory('content');
         if (!$content->where('object_id', '=', $this->id)->find()->loaded()) {
            $content = ORM::Factory('content');
            $content->object_id = $this->id;
            $content->save();

            $content->setTemplateName($this->objecttype->objecttypename); //set the objecttypename for dbmapping
            $this->_related['contenttable'] = $content;
         }
      }
   }

   
   
   public function translate($languageCode){
      $rosettaId = $this->rosetta_id;
      if(!$rosettaId){
         throw new Kohana_Exception('No Rosetta ID found for object during translation with objectId :objectId',
                                    array(':objectId'=>$objectId)
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
         
      $translatedObject = ORM::Factory('object')
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
               $this->contenttable->$field = $value;
               break;
         }
      }
      $this->contenttable->save();
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
      $content['title'] = $this->__get('contenttable')->title;
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
      $container = ORM::Factory('object')
							->latticeChildrenFilter($this->id)
              ->where('objecttype_id', '=', $cTemplate->id)
              ->where('activity', 'IS', NULL)
              ->find();

      return $container->getPublishedChildren();
   }

   public function getPublishedChildren() {

      $children = ORM::Factory('object')
							->latticeChildrenFilter($this->id)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->order_by('sortorder')
							->join('objecttypes')->on('objects.objecttype_id', '=', 'objecttypes.id')
							->where('nodeType', '!=', 'container')
              ->find_all();
      return $children;
   }

   public function getChildren() {

      return $this->getLatticeChildren();
   }
   
   public function getLatticeChildren($lattice = 'lattice'){
      $children = ORM::Factory('object')
							->latticeChildrenFilter($this->id, $lattice)
              ->where('activity', 'IS', NULL)
              ->order_by('sortorder')
              ->find_all();
      return $children;
   
   }

   public function getNextPublishedPeer() {
      $next = ORM::Factory('object')
							->latticeChildrenFilter($getLatticeParent()->id)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->order_by('sortorder', 'ASC')
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
      $next = ORM::Factory('object')
							->latticeChildrenFilter($getLatticeParent()->id)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->order_by('sortorder', 'DESC')
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
      $first = ORM::Factory('object')
							->latticeChildrenFilter($getLatticeParent()->id)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->order_by('sortorder', 'ASC')
              ->limit(1)
              ->find();
      if ($first->loaded()) {
         return $first;
      } else {
         return null;
      }
   }

   public function getLastPublishedPeer() {
      $last = ORM::Factory('object')
							->latticeChildrenFilter($getLatticeParent()->id)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->order_by('sortorder', 'DESC')
              ->limit(1)
              ->find();
      if ($last->loaded()) {
         return $last;
      } else {
         return null;
      }
   }


   public function saveField($field, $value) {
      $this->contenttable->$field = $value;
      $this->contenttable->save();
      return $this->contenttable->$field;
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
      $saveName = latticecms::makeFileSaveName('tmp') . microtime();

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

   public function saveFile($field, $filename, $type, $tmpName) {
      if (!is_object($file = $this->__get($field))) {
         $file = ORM::Factory('file', $this->__get($field));
      }
      
      $replacingEmptyFile = false;
      if(!$file->filename){
         $replacingEmptyFile = true;
      }

      $file->unlinkOldFile();
      $saveName = latticecms::makeFileSaveName($filename);

      if (!copy(Graph::mediapath() . $tmpName, Graph::mediapath() . $saveName)) {
         throw new Lattice_Exception('this is a MOP Exception');
      }
      unlink(Graph::mediapath() . $tmpName);

      $file->filename = $saveName;
      $file->mime = $type;
      $file->save(); //inserts or updates depending on if it got loaded above

      $this->contenttable->$field = $file->id;
      $this->contenttable->save();
      
      //Handle localized object linked via rosetta
      if($replacingEmptyFile){
         
         $languages = Graph::languages();
         foreach ($languages as $translationLanguage) {
           
            if ($translationLanguage->id == $this->language_id) {
               continue;
            }

            $translatedObject = $this->translate($translationLanguage->id);
            $translatedObject->contenttable->$field = $file->id;
            $translatedObject->contenttable->save();

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
         latticecms::resizeImage($imagefilename, $newfilename, $resize->getAttribute('width'), $resize->getAttribute('height'), $resize->getAttribute('forceDimension'), $resize->getAttribute('crop')
         );

         if (isset($oldfilename) && $newfilename != $prefix . $oldfilename) {
            if (file_exists(Graph::mediapath() . $oldfilename)) {
               unlink(Graph::mediapath() . $oldfilename);
            }
         }
      }

			//And process resizes passed in from caller
      foreach($additionalResizes as $uiresize){
        latticecms::resizeImage($imagefilename, $uiresize['prefix'] . '_' . $imagefilename, $uiresize['width'], $uiresize['height'], $uiresize['forceDimension'], $uiresize['crop']);
      }


      return $imagefilename;
   }

   //this is gonna change a lot!
   //this only supports a very special case of multiSelect objects
   public function saveObject() {
      $object = ORM::Factory('object', $this->contenttable->$field);
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
         $object->contenttable->$field = 0;
      }

      foreach ($_POST['values'] as $value) {
         $object->contenttable->$value = 1;
      }
      $object->save();
      return true;
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
            $tIds[] = $result->current()->id;
         }
         $this->in('objecttype_id', $tIds);
      } else if ($objectTypes == 'all') {
         //set no filter
      } else {
         $result = DB::query(Database::SELECT, "Select id from objecttypes where objecttypename = '$objectTypes'")->execute()->current();
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
      return Graph::object()->latticeChildrenFilter($this->id, $lattice);
   
   }

	 public function getLatticeParent($lattice='lattice'){
		 if(!isset($getLatticeParents[$lattice])){
			 $lattice = Graph::lattice($lattice);
			 $relationship = ORM::Factory('objectrelationship')
											->where('lattice_id', '=', $lattice->id)
											->where('connectedobject_id', '=', $this->id)
											->find();
			 if($relationship->loaded()){
				 $this->latticeParents[$lattice] = Graph::object($relationship->object_id);
			 } else {
				 $this->latticeParents[$lattice] = null;
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
         $this->objecttype->configureElement($c);
         //$childObject = $this->addObject($c->getAttribute('family'), $arguments);
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
   
   
    private function createObject($objectTypeName, $data, $rosettaId, $languageId){
       
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
      
      $newObjectType = ORM::Factory('objecttype', $objectTypeName);

      if (!$newObjectType->id) {


         //check objects.xml for configuration
         if ($objectTypeConfig = lattice::config('objects', sprintf('//objectType[@name="%s"]', $objectTypeName))->item(0)) {
            //there's a config for this objectType
            //go ahead and configure it
            Graph::configureObjectType($objectTypeName);
            $newObjectType = ORM::Factory('objecttype', $objectTypeName);
         } else {
            throw new Kohana_Exception('No config for objectType ' . $objectTypeName);
         }
      }


      $newObject = Graph::object();
      $newObject->objecttype_id = $newObjectType->id;

      //create slug
      if (isset($data['title'])) {
         $newObject->slug = latticecms::createSlug($data['title'], $newObject->id);
      } else {
				//$newObject->title = 'No Title';
				//Don't want to do this yet because then all objects will have same title
				//which is a problem for import, which assumes same title same tier objects
				//are the same object
				$newObject->slug = latticecms::createSlug();
      }
     
      $newObject->language_id = $languageId;
      $newObject->rosetta_id = $translationRosettaId;
      
      $newObject->save();


      //check for enabled publish/unpublish. 
      //if not enabled, insert as published
      $tSettings = lattice::config('objects', sprintf('//objectType[@name="%s"]', $newObjectType->objecttypename));
      $tSettings = $tSettings->item(0);
      $newObject->published = 1;
      if ($tSettings) { //entry won't exist for Container objects
         if ($tSettings->getAttribute('allowTogglePublish') == 'true') {
            $newObject->published = 0;
         }
      }
      if (isset($data['published']) && $data['published']) {
         $newObject->published = 1;
         unset($data['published']);
      }

      $newObject->save();

      //Add defaults to content table


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
               $newObject->$field = $data[$field];
               continue(2);
            case 'title':
               $newObject->$field = $data[$field];
               continue(2);
         }

         $fieldInfoXPath = sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $newObjectType->objecttypename, $field);
         $fieldInfo = lattice::config('objects', $fieldInfoXPath)->item(0);
         if (!$fieldInfo) {
            throw new Kohana_Exception("No field info found in objects.xml while adding new object, using Xpath :xpath", array(':xpath' => $fieldInfoXPath));
         }

         if (in_array($fieldInfo->tagName, $objectTypes) && is_array($value)) {
            $clusterTemplateName = $fieldInfo->tagName;
            $clusterObjectId = ORM::Factory('object')->addObject($clusterTemplateName, $value); //adding object to null parent
            $newObject->$field = $clusterObjectId;
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
                  $file = latticecms::saveHttpPostFile($newObject->id, $field, $_FILES[$field]);
               } else {
                  $file = ORM::Factory('file');
                  $file->filename = $value;
                  $file->save();
                  $newObject->$field = $file->id;
               }
               break;
            default:
               $newObject->$field = $data[$field];
               break;
         }
      }
      $newObject->contenttable->save();
      $newObject->save();
      return $newObject;
   
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
      
      $newObject = $this->createObject($objectTypeName, $data, $rosettaId, $languageId);
     
      //and set up the element relationship
      $elementRelationship = ORM::Factory('objectelementrelationship');
      $elementRelationship->object_id = $this->id;
      $elementRelationship->elementobject_id = $newObject->id;
      $elementRelationship->name = $elementName;
      $elementRelationship->save();
      
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

      return $newObject->id;
  
   }
    
   private function addLatticeObject($objectTypeName, $data = array(), $lattice = null, $rosettaId = null, $languageId = null){
      
      $newObject = $this->createObject($objectTypeName, $data, $rosettaId, $languageId);
     

      //The objet has been built, now set it's lattice point
      $lattice = Graph::lattice();
      $objectRelationship = ORM::Factory('objectrelationship');
      $objectRelationship->lattice_id = $lattice->id;
      $objectRelationship->object_id = $this->id;
      $objectRelationship->connectedobject_id = $newObject->id;
      
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
