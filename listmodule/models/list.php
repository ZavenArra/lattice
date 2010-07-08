<?

Class List_Model extends ORM {

	private $fileFields = array('file', 'file2');

	private $dbmap = null;

	public function __constructor($id = null){
		parent::__constructor($id);
	}

	public function find_by_page_id($page_id, $instance){
		$this->where('page_id', $page_id)
		->where('instance', $instance)
		->where('activity', 'NULL')
		->orderBy('sortorder')
		->find_all();
	}

	/* for any GET we should know the instance beforehand
	 * and then can use this to dbmap
	 *
	 * for SET it's a little trickier, because the instance
	 * might not have been SET yet
	 */

	public function __get($column){
		if(in_array($column, $this->fileFields) && !is_object(parent::__get($column)) ){
			$file = ORM::Factory('file', parent::__get($column));
			if($file->loaded){
				parent::__set($column,ORM::Factory('file', parent::__get($column)));
			} else {
				parent::__set($column, ORM::Factory('file') );
			}
		} else if($this->loaded) {
			//attempt to dbmap
			if(!$this->dbmap){
				$instance = parent::__get('instance');
				$this->dbmap = Kohana::config($instance.'.dbmap');
			}
			if(isset($this->dbmap[$column])){
				$column = $this->dbmap[$column];
			}

		}
		return parent::__get($column);
		
	}

}
