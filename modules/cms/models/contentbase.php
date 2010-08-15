<?
/*
* Class: Model for Content_Small
*/
class ContentBase_Model extends ORM {
	//protected $has_one = array('page');

	/*
	 * Variable: nonmappedfield
	 * Array of fields to not pass through to the content field mapping logic
	 */
	private $nonmappedfields = array('id', 'page_id', 'title', 'activity', 'loaded');

	/*
	 * Variable: fileFields 
	 * Array of possible fields to use for saving files
	 */
	protected $fileFields = array('file', 'file1', 'file2', 'file3', 'file4');


	/*
	 * Variable: objectFields 
	 * Array of possible fields to use for saving objects
	 */
	protected $objectFields = array('object1', 'object2', 'object3', 'object4');

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

		//check for dbmap
		if($map = Kohana::config('cms_dbmap.'.$this->templatename)){
			$column = $map[$column];
		}

		if(in_array($column, $this->objectFields)){
			$sub = ORM::Factory('page', parent::__get($column));
			if(!$sub->loaded){
				return array();
			}
			$values = array();
			foreach(Kohana::config('cms_dbmap.'.$sub->template->templatename) as $fieldname=>$mapColumn){
				$values[$fieldname] = $sub->contenttable->$fieldname;
			}
			return $values;
		}

		if(in_array($column, $this->fileFields) && !is_object(parent::__get($column)) ){
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
		if(in_array($column, $this->nonmappedfields)){
			return parent::__set($column, $value);
		}

		//check for dbmap
		if($map = Kohana::config('cms_dbmap.'.$this->templatename)){
			return parent::__set($map[$column], $value);
		} else {
			return parent::__set($column, $value);
		}
	}

}
?>
