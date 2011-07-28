<?
/*
* Class: Model for Content_Small
*/
class Model_Content extends ORM {
	//protected $has_one = array('object');
	//

	private static $dbmaps;

	/*
	 * Variable: nonmappedfield
	 * Array of fields to not pass through to the content field mapping logic
	 */
	private $nonmappedfields = array('id', 'object_id', 'title', 'activity', '_loaded');

	/*
	 * Variable: objecttypename
	 * Private variable storing the name of the temple the current object is using.
	 */
	private $objecttypename = null;


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




	/*
	Function: setTemplateName
	Set the objectType name for matching against the optional dbmapping. This is
	called exclusively from the object model.
	Parameters: 
	$objecttypename - the text name of the objectType being used by the current object.
	*/
	public function setTemplateName($objecttypename){
		$this->objecttypename = $objecttypename;
	}

	/*
	Function: __get
	Custom getter for this model, links in appropriate content table
	when related object 'content' is requested
	*/
	public function __get($columnName){
		if(in_array($columnName, $this->nonmappedfields)){
			return parent::__get($columnName);
		}
	
		//check for dbmap
		$object =  ORM::Factory('object', parent::__get('object_id'));
      //contenttable should not back reference object.
      
		$column = self::dbmap( $object->objecttype_id, $columnName);

		if(!$column){
			//this column isn't mapped, check to see if it's in the xml
			if($object->objecttype->nodeType=='container'){
				//For lists, values will be on the 2nd level 
				$xPath =  sprintf('//list[@family="%s"]', $object->objecttype->objecttypename);
			} else {
				//everything else is a normal lookup
				$xPath =  sprintf('//objectType[@name="%s"]', $object->objecttype->objecttypename);
			}
			$fieldConfig = mop::config('objects', $xPath.sprintf('/elements/*[@field="%s"]', $columnName));
			if($fieldConfig->item(0)){
				//field is configured but not initialized in database
				$object->objecttype->configureField($fieldConfig->item(0));

				self::reinitDbmap($object->objecttype_id);

				//now go aheand and get the mapped column
				$column = self::dbmap( $object->objecttype_id, $columnName);
				//$column = $object->objecttype->mappedColumn($column);
				return parent::__get($column);
			}
		}


		if(!$column){
			throw new Kohana_Exception('Column :column not found in content model', array(':column'=> $columnName));
		}

		if(strstr($column, 'object')){
			//echo 'iTS AN OBJECT<br>';
			$relatedObject = ORM::Factory('object', parent::__get($column));
			if(!$relatedObject->loaded()){
            return null;
            
            //build the object
            
            /*
            $id = Graph::object()->addObject($element['type']);
            parent::__set($column, $id);
            $relatedObject == Graph::object($id);
			 */
         }
			return $relatedObject;

		}

		if(strstr($column, 'file') && !is_object(parent::__get($column)) ){
			$file = ORM::Factory('file', parent::__get($column));
			//file needs to know what module it's from if its going to check against valid resizes
			parent::__set($column,$file);
		}
		$returnval = parent::__get($column);
		//Kohana::log('info', var_export( $returnval , true));
		return $returnval;

	}
        

	/*
	Function: __set
	Custom setter, saves to appropriate contenttable
	Interestingly enough, it doesn't pass throug here
	*/
	public function __set($column, $value){
		if(in_array($column, $this->nonmappedfields)){
			return parent::__set($column, $value);
		}

		$object = ORM::Factory('object', parent::__get('object_id'));

		//check for dbmap
		if($mappedcolumn = self::dbmap( $object->objecttype_id, $column) ){
			return parent::__set($mappedcolumn, $value);
		} 

		//this column isn't mapped, check to see if it's in the xml
		if($object->objecttype->nodeType=='container'){
			//For lists, values will be on the 2nd level 
			$xPath =  sprintf('//list[@family="%s"]', $object->objecttype->objecttypename);
		} else {
			//everything else is a normal lookup
			$xPath =  sprintf('//objectType[@name="%s"]', $object->objecttype->objecttypename);
		}
		$fieldConfig = mop::config('objects', $xPath.sprintf('/elements/*[@field="%s"]', $column));
		if($fieldConfig->item(0)){
			//field is configured but not initialized in database
			$object->objecttype->configureField($fieldConfig->item(0));	
			self::reinitDbmap($object->objecttype_id);

			//now go aheand and save on the mapped column

			$mappedcolumn = self::dbmap( $object->objecttype_id, $column);
			return parent::__set($mappedcolumn, $value);
		}

		//othewise default behavior
		return parent::__set($column, $value);
	}

}
?>
