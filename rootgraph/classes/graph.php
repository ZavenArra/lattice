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
				$object = ORM::Factory('object')->where('slug', '=', $objectId)->find();
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
		if(Kohana::config('mop.staging')){
			self::$mediapath = Kohana::config('mop_cms.stagingmediapath');
		} else {
			self::$mediapath = Kohana::config('mop_cms.basemediapath');
		}
		return self::$mediapath;
	}


	/*
	 * This needs to be moved to rootgraph
	 */
	public static function configureTemplate($objectTypeName){
		//validation
		foreach(mop::config('objects', '//objectType[@name="'.$objectTypeName.'"]/elements/*') as $item){
			if($item->getAttribute('field')=='title'){
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

		foreach( mop::config('objects', '//objectType[@name="'.$objectTypeName.'"]/elements/*') as $item){
			$tRecord->configureField($item);
		}
      Model_Content::reinitDbmap($tRecord->id); // Rethink this.
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
   
 
}

