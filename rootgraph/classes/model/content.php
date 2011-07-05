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
	private $nonmappedfields = array('id', 'page_id', 'title', 'activity', '_loaded');

	/*
	 * Variable: templatename
	 * Private variable storing the name of the temple the current object is using.
	 */
	private $templatename = null;


	public static function dbmap($template_id, $column=null){
		if(!isset(self::$dbmaps[$template_id])){
			$dbmaps = ORM::Factory('objectmap')->where('template_id', '=', $template_id)->find_all();
			self::$dbmaps[$template_id] = array();
			foreach($dbmaps as $map){
				self::$dbmaps[$template_id][$map->column] = $map->type.$map->index;
			}
		}
		if(!isset($column)){
			return self::$dbmaps[$template_id];
		} else {
			if(isset(self::$dbmaps[$template_id][$column])){
				return self::$dbmaps[$template_id][$column];
			} else {
				return null;
			}
		}
	}

	public static function reinitDbmap($template_id){
		unset(self::$dbmaps[$template_id]);
	}




	/*
	Function: setTemplateName
	Set the template name for matching against the optional dbmapping. This is
	called exclusively from the page model.
	Parameters: 
	$templatename - the text name of the template being used by the current object.
	*/
	public function setTemplateName($templatename){
		$this->templatename = $templatename;
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
		$object =  ORM::Factory('object', parent::__get('page_id'));
		//echo 'FROM '.$object->id.'<br>';
               
		$column = self::dbmap( $object->template_id, $columnName);

		if(!$column){
			//this column isn't mapped, check to see if it's in the xml
			if($object->template->nodeType=='container'){
				//For lists, values will be on the 2nd level 
				$xPath =  sprintf('//list[@family="%s"]', $object->template->templatename);
			} else {
				//everything else is a normal lookup
				$xPath =  sprintf('//template[@name="%s"]', $object->template->templatename);
			}
			$fieldConfig = mop::config('objects', $xPath.sprintf('/elements/*[@field="%s"]', $columnName));
			if($fieldConfig->item(0)){
				//field is configured but not initialized in database
				$object->template->configureField($fieldConfig->item(0));	
				self::reinitDbmap($object->template_id);

				//now go aheand and get the mapped column
				$column = self::dbmap( $object->template_id, $columnName);
				//$column = $object->template->mappedColumn($column);
				return parent::__get($column);
			}
		}


		if(!$column){
			throw new Kohana_Exception('Column :column not found in content model', array(':column'=> $columnName));
		}

		if(strstr($column, 'object')){
			//echo 'iTS AN OBJECT<br>';
			$sub = ORM::Factory('object', parent::__get($column));
			if(!$sub->_loaded){
				return null;
			}
			return $sub;

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

		$object = ORM::Factory('object', parent::__get('page_id'));

		//check for dbmap
		if($mappedcolumn = self::dbmap( $object->template_id, $column) ){
			return parent::__set($mappedcolumn, $value);
		} 

		//this column isn't mapped, check to see if it's in the xml
		if($object->template->nodeType=='container'){
			//For lists, values will be on the 2nd level 
			$xPath =  sprintf('//list[@family="%s"]', $object->template->templatename);
		} else {
			//everything else is a normal lookup
			$xPath =  sprintf('//template[@name="%s"]', $object->template->templatename);
		}
		$fieldConfig = mop::config('objects', $xPath.sprintf('/elements/*[@field="%s"]', $column));
		if($fieldConfig->item(0)){
			//field is configured but not initialized in database
			$object->template->configureField($fieldConfig->item(0));	
			self::reinitDbmap($object->template_id);

			//now go aheand and save on the mapped column

			$mappedcolumn = self::dbmap( $object->template_id, $column);
			return parent::__set($mappedcolumn, $value);
		}

		//othewise default behavior
		return parent::__set($column, $value);
	}

}
?>
