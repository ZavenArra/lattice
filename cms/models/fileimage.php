<?
/*
 * Class: FileImage_Model
 * Class to keep track of image properties for specific resizes.  This model does not wrap a database table, 
 * instead functioning as a cache for manually reading file size and other info.
 */

class FileImage_Model {


	/*
	 * Variable: filename 
	 * The name of the file
	 */
	private $filename;

	/*
	 * Variable: prefix
	 * The resize prefix.
	 */
	private $prefix='';

	/*
	 * Variable: width 
	 * The width of the image
	 */
	private $width;

	/*
	 * Variable: height
	 * The height of the image
	 */
	private $height;

	/*
	 * Variable: fullpath
	 * The full path to the file
	 */
	private $fullpath;

	/*
	 * Variable: urlfilename 
	 * The url of the file
	 */
	private $urlfilename;

	/*
	 * Function: __construct($filename, $prefix)
	 * Constructor, reads data parameters from the file.
	 * Parameters:
	 * $filename - the base filename to load
	 * $prefix - the prefixed filename that this object holds data for
	 * Returns: nothing
	 */
	public function __construct($filename, $prefix){
		if($prefix != 'original'){
			$this->prefix = $prefix.'_';
		}
		if($filename){
			$this->filename = $this->prefix.$filename;
			$this->urlfilename = rawurlencode($this->filename);
			$dirprefix = '';
			if(Kohana::config('mop.staging')){
				$dirprefix = 'staging/';
			}
			if(file_exists($dirprefix.'application/media/'.$this->filename)){
				$size = getimagesize($dirprefix.'application/media/'.$this->filename);
				$this->width = $size[0];
				$this->height = $size[1];
				$this->fullpath = 'application/media/'.$this->filename;
			}
		}
	}

	/*
	 * Function: __get($column)
	 * Custom getter for this model, simply returns class variables
	 * Parameters:
	 * $column - class variable to return
	 * Returns: value
	 */
	public function __get($column){
		return $this->$column;
	}


}
