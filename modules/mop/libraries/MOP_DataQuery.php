<?
/*
 * Class: MOP_DataQuery_Core
 * Experimental class dealing with generic dataquery concepts vis-a-vis metaweb
 */
class MOP_DataQuery_Core {

	private $dataQueryObject = null;
	private $dataQueryTargets = array();
	private $data = array();

	public function __construct($queryObject){
		$this->dataQueryObject = $queryObject;
		return $this;
	}

	public function doQuery(){
		$data = array();

		//we don't have these comgined yet..
			$page = ORM::Factory('page');

			if(isset($this->dataQueryObject['limit'])){
				$page->limit($this->dataQueryObject['limit'], 0);
				unset($this->dataQueryObject['limit']);
			}

			foreach($this->dataQueryObject as $key => $value){

				if(in_array($key, $page->getTableColumns() )){
					$page->where($key, $value);
				} else { 

					switch($key){
					case 'template':
						$template = ORM::Factory('template', $value);
						$page->where('template_id', $template->id);
						break;

					default:
						//this must be something that needs to be filled out
						$this->dataQueryTargets[] = $key;
						break;
					}	

				}

			}

			$page->where('activity IS NULL');
			$page->where('published', 1);
			$page->orderBy('sortorder', 'ASC');
			$pages = $page->find_all();
			foreach($pages as $page){
				$itemData = $page->getPageContent();
				foreach($this->dataQueryTargets as $target){
					$this->dataQueryObject[$target]['parentid'] = $page->id;
					$query = new MOP_DataQuery_Core($this->dataQueryObject[$target]);
					$itemData[$target] = $query->doQuery();
				}

				$data[] = $itemData;
			}
			return $data;
			/*
		} else {

			//shit actually this doesn't get used
			//we are dealing with a list
			$list = ORM::Factory('list');

			if(isset($this->dataQueryObject['limit'])){
				$list->limit($this->dataQueryObject['limit'], 0);
				unset($this->dataQueryObject['limit']);
			}

			$list->where('instance', $this->dataQueryObject['listIdentifier']);
			$list->where('activity IS NULL');
			$list->where('published', 1);
			
			if(isset($this->dataQueryObject['page_id'])){
				$list->where('page_id', $this->dataQueryObject['page_id']);
			}
			$data[] = $list->as_array();
		}
			 */

	}
}
