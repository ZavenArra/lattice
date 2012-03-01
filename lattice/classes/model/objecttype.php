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
			$result = DB::select('id')->from('objecttypes')->where('objecttypename', '=', $id)->execute()->current();
			$id = $result['id'];
		}

		parent::__construct($id);

	}
   
   public static function getConfig($objectTypeName){
     $config = lattice::config('objects', sprintf('//objectType[@name="%s"]', $objectTypeName));
     if($config->length){
        return $config->item(0);
     }

     $config = lattice::config('objects', sprintf('//list[@name="%s"]', $objectTypeName));
     if($config->length){
        return $config->item(0);
     } else {
        return false;
     }
   }

  public static function getElements($objectTypeName){
    $config = Model_ObjectType::getConfig($objectTypeName);
    $elements = lattice::config('objects', 'elements/*', $config);
    return $elements;
  }

  public static function getElementConfig($objectTypeName, $elementName){
    throw new Kohana_Expection("Not Implemented");
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
				$xQuery =  sprintf('//list[@name="%s"]', parent::__get('objecttypename'));
			} else {
				//everything else is a normal lookup
				$xQuery =  sprintf('//objectType[@name="%s"]', parent::__get('objecttypename'));
			}

			$valueFromConfig=NULL;
			if($column == 'addableObjects'){
				$xQuery .= '/addableObject';
				$nodes = lattice::config('objects', $xQuery);
				$valueFromConfig = array();
				foreach($nodes as $node){
					$entry = array();
					$entry['objectTypeId'] = $node->getAttribute('objectTypeName');
					$entry['objectTypeAddText'] = $node->getAttribute('addText');
					$tConfig = lattice::config('objects', sprintf('//objectType[@name="%s"]', $entry['objectTypeId'] ))->item(0);
          if(!count($tConfig)){
            throw new Kohana_Exception('No object type definition by name: '.$entry['objectTypeId']);
          }
					$entry['nodeType'] = $tConfig->getAttribute('nodeType');
					$entry['contentType'] = $tConfig->getAttribute('contentType');
					$valueFromConfig[] = $entry;
				}
			} else {
				$node = lattice::config('objects', $xQuery)->item(0);
				if($node)
					$valueFromConfig = $node->getAttribute($column);

        switch($column){
        case 'initialAccessRoles':
          if($valueFromConfig){
            $valueFromConfig = explode(',',$valueFromConfig);
          } else {
            $valueFromConfig = array();
          }
          break;
        }
      }

      return $valueFromConfig;	
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
     * Function: defaults()
     * Get default values for insert
     */
    public function defaults(){
      $elements = Model_ObjectType::getElements($this->objecttypename);
      $defaults = array();
      foreach($elements as $element){
        $default = $element->getAttribute('default');
        switch($default){
        case 'now':
          $defaults[$element->getAttribute('name')] = date('Y/m/d H:i:s ');
          break;
        case 'none':
          break;

        default:
          if($default){
            $defaults[$element->getAttribute('name')] = $default; 
          }

        }

      }
      return $defaults;
    }

	/*
	 * Function: getPublishedMembers($limit)
	 * This function queries all objects that use the current initialized objectType model object as thier objectType.
	 * Parameters:
	 * $limit - number of records to return
	 * Returns: ORM Iterator of matching records
	 */
	public function getPublishedMembers($limit=null){

		$o = Graph::object()
			->publishedFilter()
			->objectTypeFilter($this->objectTypeName);
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

      if(!$this->loaded()){
         return array();
      }
      
		$o = Graph::object()
              ->activeFilter()
              ->objectTypeFilter($this->objecttypename);
		if($limit){
			$o->limit($limit);
		}
		$o = $o->find_all();
     
		return $o;

	}
   
   
    
	public function configureElement($item){

		switch($item->tagName){

		case 'list':
			$ltRecord = ORM::Factory('objectType');
			$ltRecord->objecttypename = $item->getAttribute('name');
			$ltRecord->nodeType = 'container';
			$ltRecord->save();
			break;

		default:

			Model_Objectmap::configureNewField($this->id, $item->getAttribute('name'), $item->tagName );
			break;

		}

	}


}
