<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of graph
 *
 * @author deepwinter1
 */
class Graph {
   
   public static function instance(){
     
   }

	 public static function object($objectId =null) {
		 //this will be implemented to support different drivers
		 if ($objectId == null) {
			 return ORM::Factory('object');
		 } else {
			 return ORM::Factory('object', $objectId);
		 }
	 }

	 /*
		* This needs to be moved to rootgraph
    */
	public static function configureTemplate($objectTypeName){
		//validation
      foreach(mop::config('objects', '//template[@name="'.$objectTypeName.'"]/elements/*') as $item){
			if($item->getAttribute('field')=='title'){
          //  throw new Kohana_Exception('Title is a reserved field name');
			}
		}
      
		//find or create template record
		$tRecord = ORM::Factory('objecttype', $objectTypeName );
		if(!$tRecord->loaded()){
			$tRecord = ORM::Factory('objecttype');
			$tRecord->templatename = $objectTypeName;
			$tRecord->nodeType = 'object';
			$tRecord->save();
		}

		//create title field
		$checkMap = ORM::Factory('objectmap')->where('template_id', '=', $tRecord->id)->where('column', '=', 'title')->find();
		if(!$checkMap->loaded()){
			$index = 'field';
			$count = ORM::Factory('objectmap')
				->select('index')
				->where('type', '=', $index)
				->where('template_id', '=', $tRecord->id)
				->order_by('index')
				->limit(1, 0)
				->find();
			$nextIndex = $count->index+1;

			$newmap = ORM::Factory('objectmap');
			$newmap->template_id = $tRecord->id;
			$newmap->type = $index;
			$newmap->index = $nextIndex;
			$newmap->column = 'title';
			$newmap->save();
		}


		foreach( mop::config('objects', '//template[@name="'.$objectTypeName.'"]/elements/*') as $item){
			$tRecord->configureField($item);
		}
	}
   
   public static function addRootNode($rootNodeObjectType){
      //$this->driver->getObjectTypeObject($rooNodeObjectType)
      ORM::Factory('object')->addObject($rootNodeObjectType);
   }

   public static function getRootNode($rootNodeObjectType){
      //$this->driver->getObjectTypeObject($rooNodeObjectType)
		$objectType = ORM::Factory('template')->where('templatename', '=', $rootNodeObjectType)->find();
      $object =  ORM::Factory('object')->where('template_id', '=', $objectType->id)->find();
      return $object;
   }
}

