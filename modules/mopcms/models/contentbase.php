<?
/*
* Class: Model for Content_Small
*/
class ContentBase_Model extends ORM {
	//protected $has_one = array('page');
	//

	protected $dbmap = false;

	/*
	 * Variable: nonmappedfield
	 * Array of fields to not pass through to the content field mapping logic
	 */
	private $nonmappedfields = array('id', 'page_id', 'title', 'activity', 'loaded');

	/*
	 * Variable: templatename
	 * Private variable storing the name of the temple the current object is using.
	 */
	private $templatename = null;


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
	public function __get($column){
		if(in_array($column, $this->nonmappedfields)){
			return parent::__get($column);
		}
		//echo '<br>getting'.$column.'<br>';

		//check for dbmap
		$object =  ORM::Factory('page', parent::__get('page_id'));
		//echo 'FROM '.$object->id.'<br>';
		$column = mop::dbmap( $object->template_id, $column);
		//echo 'which maps to'.$column;
		if(!$column){
			return null;
		}

		if(strstr($column, 'object')){
			//echo 'iTS AN OBJECT<br>';
			$sub = ORM::Factory('page', parent::__get($column));
			if(!$sub->loaded){
				return null;
			}
			return $sub;

		}

		if(strstr($column, 'file') && !is_object(parent::__get($column)) ){
			$file = ORM::Factory('file', parent::__get($column));
			//file needs to know what module it's from if its going to check against valid resizes
			Kohana::log('info', var_export($file->as_array(), true));
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
		//echo "SETTING $column <br>";
		if(in_array($column, $this->nonmappedfields)){
			return parent::__set($column, $value);
		}

		$object = ORM::Factory('page', parent::__get('page_id'));

		//check for dbmap
		if($mappedcolumn = mop::dbmap( $object->template_id, $column) ){
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
			cms::configureField($object->template->id, $fieldConfig->item(0));	

			//now go aheand and save on the mapped column

			mop::reinitDbmap($object->template_id);
			$mappedcolumn = mop::dbmap( $object->template_id, $column);
			return parent::__set($mappedcolumn, $value);
		}

		//othewise default behavior
		return parent::__set($column, $value);
	}

}
?>
