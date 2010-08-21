<?

/*
 * Class: Template_Model
 */
class Template_Model extends ORM {

	protected $has_many = array('pages');

  /*
   * Variable: nonmappedfield
   * Array of fields to not pass through to the content field mapping logic
   */
  private $nonmappedfields = array('id', 'page_id', 'title', 'activity', 'loaded');

	/*
	 * Function: __get($column)
	 * Custom getter, allows overriding database values with local file config values
	 * Parameters: 
	 * $column  - the column to get
	 * Returns: The value
	 */
	public function __get($column) {

			//check if this value is set in config files
			Kohana::log('info', parent::__get('templatename'));

			if(in_array($column, $this->nonmappedfields)){
				return parent::__get($column);
			}

			if(parent::__get('nodetype')=='CONTAINER'){
				//For lists, values will be on the 2nd level 
				$nodes = mop::config('backend', sprintf('//module[@class="%s"]', parent::__get('templatename')));
				$valuefromconfig = $nodes->item(0)->getAttribute($column);
			} else {
				//everything else is a normal lookup
				$nodes = mop::config('backend', sprintf('//template[@templatename="%s"]', parent::__get('templatename')));
				$valuefromconfig = $nodes->item(0)->getAttribute($column);
			}
			if($valuefromconfig !== NULL){
				return $valuefromconfig;	
			}

			//No Value in config file, go looking in database
			if($column == 'addable_objects'){
				return null;
			}
			return parent::__get($column);
	}

	/*
	 * Function: unique_key($id)
	 * Allows both integer id and templatename text to be unique key,
	 * overrides function in base class
	 * Parameters:
	 * $id - a primary key
	 * Returns: type of key being used
	 */
	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'templatename';
		}

		return parent::unique_key($id);
	}

	/*
	 * Function: getPublishedMembers($limit)
	 * This function queries all objects that use the current initialized template model object as thier template.
	 * Parameters:
	 * $limit - number of records to return
	 * Returns: ORM Iterator of matching records
	 */
	public function getPublishedMembers($limit=null){

		$o = ORM::Factory('page')
			->where('template_id', $this->id)
			->where('published', 1)
			->where('activity IS NULL')
			->orderby('sortorder');
		if($limit){
			$o->limit($limit);
		}
		$o = $o->find_all();
		return $o;

	}


}
