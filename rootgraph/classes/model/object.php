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
   public $content = null;
   private $object_fields = array('loaded', 'objecttype', 'primary_key', 'primary_val');

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
         $content->setTemplateName($this->objecttype->objecttypename); //set the objecttypename for dbmapping
         $this->_related[$column] = $content->where('object_id', '=', $this->id)->find();
         if (!$this->_related[$column]->_loaded) {
            throw new Kohana_Exception('BAD_MOP_DB' . 'no content record for object ' . $this->id);
         }
         return $this->_related[$column];
      } else if (in_array($column, array_keys($this->_table_columns))){
         //this catchs the configured columsn for this table
         Kohana::$log->add(Log::INFO, $column);
         return parent::__get($column);
      } else if ($column == 'parent') {
         return Graph::object($this->parentid);
      } else if ($column == 'contenttable'){
         return parent::__get($column);
      } else if ($column == 'title'){
         return $this->contenttable->title;
      } else if ($column == 'objecttype'){
         //this condition should actually check against associations
         //OR just call parent::__get($column) with an exception
         //though that seems pretty messy
         return parent::__get($column);

      } else {
     
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
            $value = mopcms::convertNewlines($value);
         }

         
         if ($column == 'slug') {
            parent::__set('slug', mopcms::createSlug($value, $this->id));
            parent::__set('decoupleSlugTitle', 1);
            $this->save();
            return;
         } else if ($column == 'title') {
            if (!$this->decoupleSlugTitle) {
               $this->slug = mopcms::createSlug($value, $this->id);
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
            
            $xpath = sprintf('//objectType[@name="%s"]/elements/*[@field="%s"]', $objectType->objecttypename, $column);
            $fieldInfo = mop::config('objects', $xpath)->item(0);
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

      if ($inserting) {
         //and we need to update the sort, this should be the last
         //
			if ($this->parentid != NULL) {
            if (Kohana::config('cms.newObjectPlacement') == 'top') {

               $sort = DB::query(Database::SELECT, 'select min(sortorder) as minsort from objects where parentid = ' . $this->parentid)->execute()->current();
               $this->sortorder = $sort['minsort'] - 1;
            } else {
               $query = 'select max(sortorder) as maxsort from objects where parentid = ' . $this->parentid;
               $sort = DB::query(Database::SELECT, $query)->execute()->current();
               $this->sortorder = $sort['maxsort'] + 1;
            }
            $this->dateadded = 'now()';
         }
      }

      parent::save();
      //if inserting, we add a record to the content table if one does not already exists
      if ($inserting) {
         if (!Kohana::config('mop.legacy')) {
            $content = ORM::Factory('content');
         } else {
            $content = ORM::Factory($this->objecttype->contenttable);
         }
         if (!$content->where('object_id', '=', $this->id)->find()->loaded()) {
            $content = ORM::Factory('content');
            $content->object_id = $this->id;
            $content->save();

            $content->setTemplateName($this->objecttype->objecttypename); //set the objecttypename for dbmapping
            $this->_related['contenttable'] = $content;
         }
      }
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
         $content[$map->column] = $this->contenttable->{$map->column};
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

   public function getTags() {
      $tagObjects = ORM::Factory('objects_tag')
              ->where('object_id', '=', $this->id)
              ->find_all();
      $tags = array();
      foreach ($tagObjects as $tagObject) {
         $tags[] = $tagObject->as_array();
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

      $fields = mop::config('objects', sprintf('//objectType[@name="%s"]/elements/*', $this->objecttype->objecttypename));

      foreach ($fields as $fieldInfo) {
         $field = $fieldInfo->getAttribute('field');
         if (mop::config('objects', sprintf('//objectType[@name="%s"]/elements/*[@field="%s"]', $this->objecttype->objecttypename, $field))->length) {
            $content[$field] = $this->contenttable->{$field};
         }
      }

      //find any lists
      foreach (mop::config('objects', sprintf('//objectType[@name="%s"]/elements/list', $this->objecttype->objecttypename)) as $list) {

         $family = $list->getAttribute('family');
         $content[$family] = $this->getListContentAsArray($family);
      }

      return $content;
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
              ->where('objecttype_id', '=', $cTemplate->id)
              ->where('parentid', '=', $this->id)
              ->where('activity', 'IS', NULL)
              ->find();

      return $container->getPublishedChildren();
   }

   public function getPublishedChildren() {

      $children = ORM::Factory('object')
              ->where('parentid', '=', $this->id)
              ->where('published', '=', 1)
              ->where('activity', 'IS', NULL)
              ->order_by('sortorder')
							->join('objecttypes')->on('objects.objecttype_id', '=', 'objecttypes.id')
							->where('nodeType', '!=', 'container')
              ->find_all();
      return $children;
   }

   public function getChildren() {

      $children = ORM::Factory('object')
              ->where('parentid', '=', $this->id)
              ->where('activity', 'IS', NULL)
              ->order_by('sortorder')
              ->find_all();
      return $children;
   }

   public function getNextPublishedPeer() {
      $next = ORM::Factory('object')
              ->where('parentid', '=', $this->parentid)
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
              ->where('parentid', '=', $this->parentid)
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
              ->where('parentid', '=', $this->parentid)
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
              ->where('parentid', '=', $this->parentid)
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

   public function getParent() {
      $parent = ORM::Factory('object', $this->parentid);
      return $parent;
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
      $saveName = mopcms::makeFileSaveName('tmp') . microtime();

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
      if (!is_object($file = $this->contenttable->$field)) {
         $file = ORM::Factory('file', $this->contenttable->$field);
      }

      $file->unlinkOldFile();
      $saveName = mopcms::makeFileSaveName($filename);

      if (!copy(Graph::mediapath() . $tmpName, Graph::mediapath() . $saveName)) {
         throw new MOP_Exception('this is a MOP Exception');
      }
      unlink(Graph::mediapath() . $tmpName);

      $file->filename = $saveName;
      $file->mime = $type;
      $file->save(); //inserts or updates depending on if it got loaded above

      $this->contenttable->$field = $file->id;
      $this->contenttable->save();

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
      $resizes = mop::config('objects', sprintf('//objectType[@name="%s"]/elements/*[@field="%s"]/resize', $objecttypename, $field
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

				 //This dependency should be moved out of mopcms
				 //Rootgraph should never require mopcms
         mopcms::resizeImage($imagefilename, $newfilename, $resize->getAttribute('width'), $resize->getAttribute('height'), $resize->getAttribute('forceDimension'), $resize->getAttribute('crop')
         );

         if (isset($oldfilename) && $newfilename != $prefix . $oldfilename) {
            if (file_exists(Graph::mediapath() . $oldfilename)) {
               unlink(Graph::mediapath() . $oldfilename);
            }
         }
      }

			//And process resizes passed in from caller
      foreach($additionalResizes as $uiresize){
        mopcms::resizeImage($imagefilename, $uiresize['prefix'] . '_' . $imagefilename, $uiresize['width'], $uiresize['height'], $uiresize['forceDimension'], $uiresize['crop']);
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

   public function parentFilter($parentid) {
      $this->where('parentid', '=', $parentid);
   }

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

   public function latticeChildrenFilter($parentid, $lattice){
      $this->where('parentid', '=', $parentid);
   }
   
   public function latticeChildrenQuery($lattice){
      return Graph::object()->latticeChildrenFilter($this->id, $lattice);
   
   }
   
   /*
     Function: addObject($id)
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

   public function addObject($objectTypeName, $data = array()) {
      $objecttype_id = ORM::Factory('objecttype', $objectTypeName)->id;
      if (!$objecttype_id) {


         //check objects.xml for configuration
         if ($objectTypeConfig = mop::config('objects', sprintf('//objectType[@name="%s"]', $objectTypeName))->item(0)) {
            //there's a config for this objectType
            //go ahead and configure it
            Graph::configureTemplate($objectTypeName);
            $objecttype_id = ORM::Factory('objecttype', $objectTypeName)->id;
         } else {
            throw new Kohana_Exception('No config for objectType ' . $objectTypeName);
         }
      }


      $newObject = Graph::object();
      $newObject->objecttype_id = $objecttype_id;

      //create slug
      if (isset($data['title'])) {
         $newObject->slug = mopcms::createSlug($data['title'], $newObject->id);
      } else {
				//$newObject->title = 'No Title';
				//Don't want to do this yet because then all objects will have same title
				//which is a problem for import, which assumes same title same tier objects
				//are the same object
				$newObject->slug = mopcms::createSlug();
      }
      $newObject->parentid = $this->id;

      //calculate sort order
      $sort = DB::select(array('sortorder', 'maxsort'))->from('objects')->where('parentid', '=', $this->id)
                      ->order_by('sortorder')->limit(1)
                      ->execute()->current();
      $newObject->sortorder = $sort['maxsort'] + 1;

      $newObject->save();


      //check for enabled publish/unpublish. 
      //if not enabled, insert as published
      $objectType = ORM::Factory('objecttype', $objecttype_id);
      $tSettings = mop::config('objects', sprintf('//objectType[@name="%s"]', $objectType->objecttypename));
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
      $newobjectType = ORM::Factory('objecttype', $newObject->objecttype_id);


      $lookupTemplates = mop::config('objects', '//objectType');
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
               $newObject->contenttable->$field = $data[$field];
               continue(2);
         }

         $fieldInfoXPath = sprintf('//objectType[@name="%s"]/elements/*[@field="%s"]', $newobjectType->objecttypename, $field);
         $fieldInfo = mop::config('objects', $fieldInfoXPath)->item(0);
         if (!$fieldInfo) {
            throw new Kohana_Exception("No field info found in objects.xml while adding new object, using Xpath :xpath", array(':xpath' => $fieldInfoXPath));
         }

         if (in_array($fieldInfo->tagName, $objectTypes) && is_array($value)) {
            $clusterTemplateName = $fieldInfo->tagName;
            $clusterObjectId = ORM::Factory('object')->addObject($clusterTemplateName, $value); //adding object to null parent
            $newObject->contenttable->$field = $clusterObjectId;
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
      $components = mop::config('objects', sprintf('//objectType[@name="%s"]/components/component', $newobjectType->objecttypename));
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
         $newObject->addObject($c->getAttribute('objectTypeName'), $arguments);
      }

      //containers (list)
      $containers = mop::config('objects', sprintf('//objectType[@name="%s"]/elements/list', $newobjectType->objecttypename));
      foreach ($containers as $c) {
         $arguments['title'] = $c->getAttribute('label');
         $newObject->addObject($c->getAttribute('family'), $arguments);
      }

      return $newObject->id;
   }

}

?>
