<?php

/*
 * To change this objectType, choose Tools | Templates
 * and open the objectType in the editor.
 */

/**
 * Description of graph
 *
 * @author deepwinter1
 */
class Graph {

	public static $mediapath;	
   
   //cache vars
   private static $_languages;

	public static function instance(){
      return ORM::Factory('object');
	}

	public static function object($objectId =null) {
		//this will be implemented to support different drivers
		if ($objectId == null) {
			return ORM::Factory('object');
		} else {
			if(is_numeric($objectId)){
				return ORM::Factory('object', $objectId);
			} else {
            
            $objectTypeName = $object->objecttype->objecttypename;
            if(Kohana::find_file('classes/model', $objectTypeName)){
               $object = //the wrapper
            } else {
               $object = 
            
            }
            
            $object = RootGraphLinkedTable::Factory()
            
				$object = ORM::Factory('object', $objectId);
				$graphObjectModelName = 'graph'.ucfirst($object->objecttype->objecttypename);
				if(Kohana::find_file('classes/model', $graphObjectModelName)){
					$object = ORM::Factory($graphObjectModelName)->initializeLatticeObject($objectId);
				}

				return $object;
			}
		}
	}
   
   
   
   public static function lattice($latticeId = 'lattice'){
      if(is_numeric($latticeId)){
         return ORM::Factory('lattice', $latticeId);
      } else {
         $lattice = ORM::Factory('lattice')->where('name', '=', $latticeId)->find();
         return $lattice;
      }
   
   }

	public static function file($fileId = null){

		if ($fileId == null) {
			return ORM::Factory('file');
		} else {
			return ORM::Factory('file', $fileId);
		}

	}
   
   public static function getActiveTags(){
      $tags = ORM::Factory('tag')
              ->select('tag')
              ->distinct(TRUE)
              ->join('objects_tags')->on('objects_tags.tag_id', '=', 'tags.id')
              ->join('objects')->on('objects_tags.object_id', '=', 'objects.id')
              ->where('objects.published', '=', 1)
              ->where('objects.activity', 'IS', NULL)
              ->find_all();
      $tagsText = array();
      foreach($tags as $tag){
        $tagsText[]= $tag->tag;
      }
      return $tagsText;
   }

	public static function isFileModel($model){
		if(get_class($model) == 'Model_File'){
			return true;
		}	else {
			return false;
		}
	}
   
   public static function languages(){
      if(!self::$_languages){
       self::$_languages =  ORM::Factory('language')->where('activity', 'is', NULL)->find_all();
      }
      return self::$_languages;
   }
   
   public static function language($id){
      $languages = self::languages();
      foreach($languages as $language){
      
         if($language->id == $id){
           return $language;
         }
      }
      throw new Kohana_Exception('Language not found :language', array(':language'=>$id));
   }
    
   
   public static function newRosetta(){
      $rosetta = ORM::Factory('rosetta');
      $rosetta->save();
      return $rosetta->id;
   
   }
   
   public static function defaultLanguage(){
      return 1;
   }

	public static function mediapath(){
		if(self::$mediapath){
			return self::$mediapath;
		}
		if(Kohana::config('lattice.staging')){
			self::$mediapath = Kohana::config('lattice_cms.stagingmediapath');
		} else {
			self::$mediapath = Kohana::config('lattice_cms.basemediapath');
		}
		return self::$mediapath;
	}


	public static function configureObjectType($objectTypeName){
		//validation
		foreach(lattice::config('objects', '//objectType[@name="'.$objectTypeName.'"]/elements/*') as $item){
			if($item->getAttribute('name')=='title'){
				throw new Kohana_Exception('Title is a reserved field name');
			}
		}

		//find or create objectType record
		$tRecord = ORM::Factory('objecttype', $objectTypeName );
		if(!$tRecord->loaded()){
			$tRecord = ORM::Factory('objecttype');
			$tRecord->objecttypename = $objectTypeName;
			$tRecord->nodeType = 'object';
			$tRecord->save();
		}

		foreach( lattice::config('objects', '//objectType[@name="'.$objectTypeName.'"]/elements/*') as $item){
			$tRecord->configureElement($item);
		}
      Model_Object::reinitDbmap($tRecord->id); // Rethink this.
	}
   
   public static function addRootNode($rootNodeObjectType){
      //$this->driver->getObjectTypeObject($rooNodeObjectType)
      Graph::object()->addObject($rootNodeObjectType);
   }

   public static function getRootNode($rootNodeObjectType){
      //$this->driver->getObjectTypeObject($rooNodeObjectType)
		$objectType = ORM::Factory('objectType')->where('objecttypename', '=', $rootNodeObjectType)->find();
      $object =  Graph::object()->objectTypeFilter($objectType->objecttypename)->find();
      return $object;
   }
   
   public static function getLatticeRoot($latticeId = 'lattice', $languageCode = 'en'){
      $language = ORM::Factory('language')
              ->where('code', '=', $languageCode)
              ->find();
      
      $objectRelationship = ORM::Factory('objectrelationship')
              ->where('lattice_id', '=', Graph::lattice($latticeId))
              ->where('object_id', '=', 0)
              ->join('objects')->on('objects.id', '=', 'objectrelationships.connectedobject_id' )
              ->where('language_id', '=', $language->id)
              ->find();
      $root = ORM::Factory('object', $objectRelationship->id);
      if(!$root->loaded()){
         throw new Kohana_Exception('Root object not found');
      }
      return $root;
  
   }
   
 
}

