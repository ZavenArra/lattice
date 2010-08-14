<?

/*
 * Class: Template_Model
 */
class Template_Model extends ORM {

	protected $has_many = array('pages');


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
			$valuefromconfig = Kohana::config('cms_templates.'.parent::__get('templatename').'.'.$column);
			if($valuefromconfig !== NULL){
				return $valuefromconfig;	
			}
			//No Value in config file, go looking in database
			//but first apply temporary skip on addable_leaves and addable_categories
			//need to add these, but don't want to make global database changes at this time.
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
