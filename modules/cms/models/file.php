<?
/*
 * Class: File_Model
 * ORM Class implementing files table
 */
class File_Model extends ORM {

	/*
	 * Variable: $imageinfo
	 * Private array containing info pertaining to generated images
	 */
	private $imageinfo = array();

	/*
	 * Variable: object_fields
	 * Private array containing fields that should be passed through to parent object on __get and __set
	 */
	private $object_fields = array('loaded');

	/*
	 * Function: __construct($id) 
	 * Constructor, fills this->object fields with configured fields and current table columns
	 * Parameters:
	 * id  - the id of file
	 * Returns: 
	 */
	public function __construct($id){
		parent::__construct($id);
		$this->object_fields = array_merge($this->object_fields, array_keys($this->table_columns) );
	}


	/*
	 * Function: __get($column) 
	 * Custom getter for this model. This model supports a notion of 'resize prefixes' for image files,
	 * so that width, height, filename, fullpath, and urlfilename can be accessed via $model->prefix->parameter
	 * Parameters:
	 * $column - the column to get
	 * Returns: the value of the column
	 */
	public function __get($column) {
		//if it's a column in the table just return it
		
		if(in_array($column, $this->object_fields )){
			return parent::__get($column);
		}

		if($column == 'urlfilename'){
			return rawurlencode(parent::__get('filename'));
		}

		//otherwise check if it's a valid resize prefix


		$prefix = $column; //for code clarity

		//create image info object
		if(!isset($this->imageinfo[$prefix])){
			$this->imageinfo[$prefix] = new FileImage_Model(parent::__get('filename'), $prefix);
		}

		//return image info so that it's __get can be called
		return $this->imageinfo[$prefix];

	}

}
