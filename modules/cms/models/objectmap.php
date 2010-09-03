<?
/*
* Class: Model for Content_Small
*/
class ObjectMap_Model extends ORM {
	/*
	Function: __get
	Custom getter for this model
	*/
	public function __get($column){
		switch($column){
			case 'dbField':
				return $this->type.$this->index;
				break;
			default:
				return parent::__get($column);
			}
	}
}
?>
