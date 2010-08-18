<?
/*
*
* Class: Model for Page
*
*/
class Page_Model extends ORM {
	protected $belongs_to = array('template');
	public $content = null;

	private $object_fields = array('loaded', 'template', 'primary_key', 'primary_val');

	public function __construct($id){
		parent::__construct($id);
		$this->object_fields = array_merge($this->object_fields, array_keys($this->table_columns) );
	}
	  /**
		 *    * Allows a model to be loaded by username or email address.
		 *       */
	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'slug';
		}

		return parent::unique_key($id);
	}


	/*
	 *   Function: __get
	 *     Custom getter for this model, links in appropriate content table
	 *       when related object 'content' is requested
	 *         */
	public function __get($column){

    if($column=='contenttable' && !isset($this->related[$column])){
      if(!Kohana::config('mop.legacy')){
        $content = ORM::factory( inflector::singular('contents') );
      } else {
        $content = ORM::factory( inflector::singular($this->template->contenttable) );
      }
      $content->setTemplateName($this->template->templatename); //set the templatename for dbmapping
      $this->related[$column]=$content->where('page_id',$this->id)->find();
      if(!$this->related[$column]->loaded){
        throw new Kohana_User_Exception('BAD_MOP_DB', 'no content record for page '.$this->id);
      }
      return $this->related[$column];
		} else if($column=='parent'){
			return ORM::Factory('page', $this->parentid); 
		}	else {
			return parent::__get($column);
		}
	}


	/*
	Function: __set
	Custom setter, saves to appropriate contenttable
	Interestingly enough, it doesn't pass throug here
	*/
	public function __set($column, $value){
		if($column=='contenttable'){
			$this->changed[$column] = $column;

			// Object is no longer saved
			$this->saved = FALSE;

			$this->object[$column] = $this->load_type($column, $value);

		} else {
			return parent::__set($column, $value);
		}
	}

	/*
	Function: save()
	Custom save function, makes sure the content table has a record when inserting new page
	*/
	public function save(){
		$inserting = false;
		if($this->loaded == FALSE){
			$inserting = true;
		}

		if($inserting){
			//and we need to update the sort, this should be the last
			if(Kohana::config('cms.newObjectPlacement')=='top'){
				$spage = ORM::Factory('page');
				$spage->select('min(sortorder) as minsort ')->where('parentid', $this->parentid)->find();
				$this->sortorder = $spage->minsort - 1;
			} else {
				$spage = ORM::Factory('page');
				$spage->select('max(sortorder) as maxsort ')->where('parentid', $this->parentid)->find();
				$this->sortorder = $spage->maxsort + 1;
			}
			$this->dateadded = new Database_Expr('now()');
		}

		parent::save();
		//if inserting, we add a record to the content table if one does not already exists
		if($inserting){
      if(!Kohana::config('mop.legacy')){
        $content = ORM::Factory('content');
      } else {
        $content = ORM::Factory($this->template->contenttable);
      }
			if(!$content->where('page_id',$this->id)->find()->loaded){
        if(!Kohana::config('mop.legacy')){
          $this->db->insert('contents', array('page_id'=>$this->id));
        } else {
          $this->db->insert(inflector::plural($this->template->contenttable), array('page_id'=>$this->id));
        }

        if(!Kohana::config('mop.legacy')){
          $content = ORM::factory( 'content' );
        } else {
          $content = ORM::factory( inflector::singular($this->__get('template')->contenttable) );
        }
				$content->setTemplateName($this->template->templatename); //set the templatename for dbmapping
				$this->related['contenttable']=$content->where('page_id', $this->id)->find();
			}
		}
	}

	public function getContentAsArray(){

		if($fields = Kohana::config('cms_dbmap.'.$this->template->templatename)){
			foreach($fields as $key=>$value){
				$content[$key] = $this->contenttable->$key;
			}
		} else {
			$content = $this->contenttable->as_array();
		}
		return $content;
	}


	public function setDataQueryWhere($key, $value){
		$this->dataQueryTargets = array();
	}




	public function getPageContent(){
		$content=array();
		$content['id'] = $this->id;
		$content['title'] = $this->__get('contenttable')->title;
		$content['slug'] = $this->slug;
		$content['dateadded'] = $this->dateadded;

		if($fields = Kohana::config('cms_dbmap.'.$this->template->templatename)){ 
			foreach($fields as $key=>$value){
				$content[$key] = $this->__get('contenttable')->$key;
			}
		} else {
			$content = $this->__get('contenttable')->as_array();
		}

		//get data from lists
		$blocks = Kohana::config('cms.modules.'.$this->__get('template')->templatename);
		if($blocks) {
			$modules = array();
			foreach($blocks as $block){
				if($block['type'] == 'module'){
					switch($block['controllertype']){
					case 'listmodule':
						$content[$block['modulename']] = $this->getListData($block['modulename']);
						break;
					default:
						break;
					}
				}
			}
		}

		return $content;
	}


	//EXPERIMENTAL
	// ok this doubles up code in site controller
	// in the future there shouldn't be a distinction between templates and lists
	// and that will resolve this doubling, which is dumb
	public function getListData($instance){
			if(! $sortdirection = Kohana::config($instance.'.sortdirection')){
				$sortdirection = Kohana::config('listmodule.sortdirection');
			}

			//for pagination, we generate the module
			//and then just go ahead and call the paginatedList stuff


			$dbmap = Kohana::config($instance.'.dbmap');
			$listitems = ORM::Factory('list')
			->where('instance', $instance)
			->where('activity IS NULL')
			->orderby('sortorder', $sortdirection);
			if($this->id){
				$listitems->where('page_id', $this->id);
			}
			$listitems = $listitems->find_all();
			$list = array();
			//this is a template for slurping out lists
			foreach($listitems as $item){
				$data = array();
				foreach($dbmap as $var => $dbfield){
					$data[$var] = $item->$var; //EXPERIMENTAL	
				}

				$files = Kohana::config($instance.'.files');
				if(is_array($files)){
					foreach($files as $key => $settings){
						$data[$key] = $item->$key;
					}
				}
				$singleimages = Kohana::config($instance.'.singleimages');
				if(is_array($singleimages)){
					foreach($singleimages as $key => $settings){
						$data[$key] = $item->$key;
					}
				}
				$list[] = $data;
			}
			return $list;
	}

	public function getPublishedChildren(){

		$children = ORM::Factory('page')
			->where('parentid', $this->id)
			->where('published', 1)
			->where('activity IS NULL')
			->orderby('sortorder')
			->find_all();
		return $children;
	}

	public function getNextPublishedPeer(){
		$next = ORM::Factory('page')
			->where('parentid', $this->parentid)
			->where('published', 1)
			->where('activity IS NULL')
			->orderby('sortorder', 'ASC')
			->where('sortorder > '.$this->sortorder)
			->limit(1)
			->find();
		if($next->loaded){
			return $next;
		} else{
			return null;
		}
	}

	public function getPrevPublishedPeer(){
		$next = ORM::Factory('page')
			->where('parentid', $this->parentid)
			->where('published', 1)
			->where('activity IS NULL')
			->orderby('sortorder', 'DESC')
			->where('sortorder < '.$this->sortorder)
			->limit(1)
			->find();
		if($next->loaded){
			return $next;
		} else{
			return null;
		}
	}

	public function getFirstPublishedPeer(){
		$first = ORM::Factory('page')
			->where('parentid', $this->parentid)
			->where('published', 1)
			->where('activity IS NULL')
			->orderby('sortorder', 'ASC')
			->limit(1)
			->find();
		if($first->loaded){
			return $first;
		} else{
			return null;
		}
	}

	public function getLastPublishedPeer(){
		$last = ORM::Factory('page')
			->where('parentid', $this->parentid)
			->where('published', 1)
			->where('activity IS NULL')
			->orderby('sortorder', 'DESC')
			->limit(1)
			->find();
		if($last->loaded){
			return $last;
		} else{
			return null;
		}
	}

	public function getParent(){
		$parent = ORM::Factory('page', $this->parentid);
		return $parent;
	}
}
?>
