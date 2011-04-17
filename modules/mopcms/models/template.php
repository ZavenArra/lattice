<?

/*
 * Class: Template_Model
 */
class Model_Template extends ORM {

	protected $has_many = array('pages');

  /*
   * Variable: nonmappedfield
   * Array of fields to not pass through to the content field mapping logic
   */
  private $nonmappedfields = array('id', 'page_id', 'activity', 'loaded', 'templatename', 'nodeType');

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

			if(parent::__get('nodeType')=='container'){
				//For lists, values will be on the 2nd level 
				$xQuery =  sprintf('//list[@family="%s"]', parent::__get('templatename'));
			} else {
				//everything else is a normal lookup
				$xQuery =  sprintf('//template[@name="%s"]', parent::__get('templatename'));
			}

			$valuefromconfig=NULL;
			if($column == 'addableObjects'){
				$xQuery .= '/addableObject';
				$nodes = mop::config('objects', $xQuery);
				$valuefromconfig = array();
				foreach($nodes as $node){
					$entry = array();
					$entry['templateId'] = $node->getAttribute('templateName');
					$entry['templateAddText'] = $node->getAttribute('addText');
					$tConfig = mop::config('objects', sprintf('//template[@name="%s"]', $entry['templateId'] ))->item(0);
					$entry['nodeType'] = $tConfig->getAttribute('nodeType');
					$entry['contentType'] = $tConfig->getAttribute('contentType');
					$valuefromconfig[] = $entry;
				}
			} else {
				$node = mop::config('objects', $xQuery)->item(0);
				if($node)
					$valuefromconfig = $node->getAttribute($column);
			}

      return $valuefromconfig;	
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

	/*
	 * Function: getActiveMembers($limit)
	 * This function queries all objects that use the current initialized template model object as thier template.
	 * Parameters:
	 * $limit - number of records to return
	 * Returns: ORM Iterator of matching records
	 */
	public function getActiveMembers($limit=null){

		$o = ORM::Factory('page')
			->where('template_id', $this->id)
			->where('activity IS NULL')
			->orderby('sortorder');
		if($limit){
			$o->limit($limit);
		}
		$o = $o->find_all();
		return $o;

	}


}
