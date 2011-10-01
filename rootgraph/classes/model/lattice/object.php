<?php

/*
 * To change this objectType, choose Tools | Templates
 * and open the objectType in the editor.
 */

/**
 * Model for Objecth
 * 
 *
 * @author deepwinter1
 */
class Model_Lattice_Object extends Model_Lattice_ContentDriver {

	private static $dbmaps;
/*
	 * Variable: nonmappedfield
	 * Array of fields to not pass through to the content field mapping logic
	 */
	private $passthroughFields = array('id', 'object_id', 'title', 'activity');

   

	public static function dbmap($objecttype_id, $column=null){
		if(!isset(self::$dbmaps[$objecttype_id])){
			$dbmaps = ORM::Factory('objectmap')->where('objecttype_id', '=', $objecttype_id)->find_all();
			self::$dbmaps[$objecttype_id] = array();
			foreach($dbmaps as $map){
				self::$dbmaps[$objecttype_id][$map->column] = $map->type.$map->index;
			}
		}
		if(!isset($column)){
			return self::$dbmaps[$objecttype_id];
		} else {
			if(isset(self::$dbmaps[$objecttype_id][$column])){
				return self::$dbmaps[$objecttype_id][$column];
			} else {
				return null;
			}
		}
	}

	public static function reinitDbmap($objecttype_id){
		unset(self::$dbmaps[$objecttype_id]);
	}

   
   public function loadContentTable($object){

      $content = ORM::factory(inflector::singular('contents'));
      $this->contenttable = $content->where('object_id', '=', $object->id)->find();
      if (!$this->contenttable->loaded()) {
         //we are going to allow no content object
         //in order to support having empty objects
         //throw new Kohana_Exception('BAD_Lattice_DB' . 'no content record for object ' . $this->id);
      }
      return $this->contenttable;
   }

   public function getTitle($object){
         return $this->contenttable->title; 
   }
   public function setTitle($object, $title){
         return $this->contenttable->title = $title; 
   }
   
   public function getContentColumn($object, $column){
      //This is a mapped field in the contents table
         $contentColumn = self::dbmap($object->objecttype_id, $column);       

         //No column mapping set up, attempt to run setup if it's configured.
         if (!$contentColumn) {
                        
            //this column isn't mapped, check to see if it's in the xml
            if ($object->objecttype->nodeType == 'container') {
               //For lists, values will be on the 2nd level 
               $xPath = sprintf('//list[@name="%s"]', $object->objecttype->objecttypename);
            } else {
               //everything else is a normal lookup
               $xPath = sprintf('//objectType[@name="%s"]', $object->objecttype->objecttypename);
            }
            $fieldConfig = lattice::config('objects', $xPath . sprintf('/elements/*[@name="%s"]', $column));


            if ($fieldConfig->item(0)) {

               //This is a temporary stopgap until we have a cleaner handle on what to do when tags is
               //requested via the object.
               if ($fieldConfig->item(0)->tagName == 'tags') {
                  return $this->getTagStrings();
               }

               //field is configured but not initialized in database
               $object->objecttype->configureElement($fieldConfig->item(0));

               self::reinitDbmap($object->objecttype_id);

               //now go aheand and get the mapped column
               $contentColumn = self::dbmap($object->objecttype_id, $column);
            }
         }


         if (!$contentColumn) {
            throw new Kohana_Exception('Column :column not found in content model', array(':column' => $column));
         }

         //If the column is an object, then this is a relationship with another object
         if (strstr($contentColumn, 'object')) {
            //echo 'iTS AN OBJECT<br>';
            $objectElementRelationship = ORM::Factory('objectelementrelationship')
                    ->where('object_id', '=', $this->id)
                    ->where('name', '=', $column)
                    ->find();
            $objectElement = Graph::object($objectElementRelationship->elementobject_id);

            if (!$objectElement->loaded()) {
               //
               // it may make sense for the objecttype model to return the config info for itself
               // or something similar
               //
            if ($object->objecttype->nodeType == 'container') {
                  //For lists, values will be on the 2nd level 
                  $xPath = sprintf('//list[@name="%s"]', $object->objecttype->objecttypename);
               } else {
                  //everything else is a normal lookup
                  $xPath = sprintf('//objectType[@name="%s"]', $object->objecttype->objecttypename);
               }

               $elementConfig = lattice::config('objects', $xPath . sprintf('/elements/*[@name="%s"]', $column));

               //build the object
               $objectElement = $object->addElementObject($elementConfig->item(0)->tagName, $column);
            }
            return $objectElement;
         }

         //Also need to check for file, but in 3.1 file will be an object itself and this will
         //not be necessary.
         if (strstr($contentColumn, 'file') && !is_object($this->contenttable->$contentColumn)) {
            $file = ORM::Factory('file', $this->contenttable->$contentColumn);
            //file needs to know what module it's from if its going to check against valid resizes
            $this->contenttable->__set($contentColumn, $file);
         }
  
         return $this->contenttable->$contentColumn;
   }
   

   public function setContentColumn($object, $column, $value){
       
            if (in_array($column, $this->passthroughFields)) {
               return $this->contenttable->__set($column, $value);
            }


            //check for dbmap
            if ($mappedcolumn = self::dbmap($object->objecttype_id, $column)) {
               return $this->contenttable->__set($mappedcolumn, $value);
            }
            
           
            //this column isn't mapped, check to see if it's in the xml
            if ($object->objecttype->nodeType == 'container') {
               //For lists, values will be on the 2nd level 
               $xPath = sprintf('//list[@name="%s"]', $object->objecttype->objecttypename);
            } else {
               //everything else is a normal lookup
               $xPath = sprintf('//objectType[@name="%s"]', $object->objecttype->objecttypename);
            }
            
            
            $fieldConfig = lattice::config('objects', $xPath . sprintf('/elements/*[@name="%s"]', $column));
            if ($fieldConfig->item(0)) {
               //field is configured but not initialized in database
               $object->objecttype->configureElement($fieldConfig->item(0));
               self::reinitDbmap($object->objecttype_id);

               //now go aheand and save on the mapped column

               $mappedcolumn = self::dbmap($object->objecttype_id, $column);
               return $this->contenttable->__set($mappedcolumn, $value);
            }

            $this->contenttable->$mappedcolumn = $value;
            $this->contenttable->save();
   }

   //this could potentially go into the base class 100%
   public function saveContentTable($object, $inserting){
      //if inserting, we add a record to the content table if one does not already exists
      if ($inserting) {
				$content = ORM::Factory('content');
         if (!$content->where('object_id', '=', $object->id)->find()->loaded()) {
            $content = ORM::Factory('content');
            $content->object_id = $this->id;
            $content->save();

            $this->contenttable = $content;
         }
      }
      $this->contenttable->save();
   
   }

   
}

?>
