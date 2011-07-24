<?

/*
 * Class: Model_ObjectType
 */
class Model_ObjectType extends ORM {

	protected $_has_many = array('object'=>array());
	protected $_belongs_to = array('object'=>array());

	/*
	 * Variable: nonmappedfield
	 * Array of fields to not pass through to the content field mapping logic
	 */
	private $nonmappedfields = array('id', 'object_id', 'activity', 'loaded', 'objecttypename', 'nodeType');

	public function __construct($id=null){

		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id)) {
			//it's the tmeplate identified, look up the integer primary key
			$result = DB::select('id')->from('objectTypes')->where('objecttypename', '=', $id)->execute()->current();
			$id = $result['id'];
		}

		parent::__construct($id);

	}

	/*
	 * Function: __get($column)
	 * Custom getter, allows overriding database values with local file config values
	 * Parameters: 
	 * $column  - the column to get
	 * Returns: The value
	 */
	public function __get($column) {

		//check if this value is set in config files

		if(in_array($column, $this->nonmappedfields)){
			return parent::__get($column);
		}

		if(parent::__get('nodeType')=='container'){
			//For lists, values will be on the 2nd level 
				$xQuery =  sprintf('//list[@family="%s"]', parent::__get('objecttypename'));
			} else {
				//everything else is a normal lookup
				$xQuery =  sprintf('//objectType[@name="%s"]', parent::__get('objecttypename'));
			}

			$valuefromconfig=NULL;
			if($column == 'addableObjects'){
				$xQuery .= '/addableObject';
				$nodes = mop::config('objects', $xQuery);
				$valuefromconfig = array();
				foreach($nodes as $node){
					$entry = array();
					$entry['objectTypeId'] = $node->getAttribute('objectTypeName');
					$entry['objectTypeAddText'] = $node->getAttribute('addText');
					$tConfig = mop::config('objects', sprintf('//objectType[@name="%s"]', $entry['objectTypeId'] ))->item(0);
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
	 * Allows both integer id and objecttypename text to be unique key,
	 * overrides function in base class
	 * Parameters:
	 * $id - a primary key
	 * Returns: type of key being used
	 */
	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'objecttypename';
		}

		return parent::unique_key($id);
	}

	/*
	 * Function: getPublishedMembers($limit)
	 * This function queries all objects that use the current initialized objectType model object as thier objectType.
	 * Parameters:
	 * $limit - number of records to return
	 * Returns: ORM Iterator of matching records
	 */
	public function getPublishedMembers($limit=null){

		$o = ORM::Factory('object')
			->where('objecttype_id', '=', $this->id)
			->where('published', '=', 1)
			->where('activity', 'IS', NULL)
			->order_by('sortorder');
		if($limit){
			$o->limit($limit);
		}
		$o = $o->find_all();
		return $o;

	}

	/*
	 * Function: getActiveMembers($limit)
	 * This function queries all objects that use the current initialized objectType model object as thier objectType.
	 * Parameters:
	 * $limit - number of records to return
	 * Returns: ORM Iterator of matching records
	 */
	public function getActiveMembers($limit=null){

		$o = ORM::Factory('object')
			->where('objecttype_id', '=', $this->id)
			->where('activity', 'IS', NULL)
			->order_by('sortorder');
		if($limit){
			$o->limit($limit);
		}
		$o = $o->find_all();
		return $o;

	}
   
   
    
	public function configureField($item){

		switch($item->tagName){

		case 'list':
			$ltRecord = ORM::Factory('objectType');
			$ltRecord->objecttypename = $item->getAttribute('family');
			$ltRecord->nodeType = 'container';
			$ltRecord->save();
			break;

		default:

			Model_Objectmap::configureNewField($this->id, $item->getAttribute('field'), $item->tagName );
			break;

		}

	}


}
