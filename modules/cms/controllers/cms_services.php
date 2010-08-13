<?
/**
 * Class: CMS_Services_Controller
 * The main CMS class, handling add, delete, and retrieval of pages
 * @author Matthew Shultz
 * @version 1.0
 * @package Kororor
 */

class CMS_Services_Controller extends Controller{

	/*
	Variable: loaded container model
	*/
	private $model;


	private $stagingmediapath = 'staging/application/media/';
	private $basemediapath = 'application/media/';
	private $mediapath = '';

	/*
	Variable: savelocalfile
	This should be private, and probably should be handled in a different way. Basically
	moving of files needs to switch if you use the command line (can't use move_uploaded_file)
	*/
	public $savelocalfile = null;

	/*
	Function: constructor
	Parameters:
	$model - the name of the model this item is stored in
	*/
	public function __construct($model = null){
		if($model){
			if(!$model->loaded){
				throw new Kohana_User_Exception('model is not loaded', 'model is not loaded: invalid reference to item');
			}
			$this->model = $model;
		}

		if(Kohana::config('mop.staging')){
			$this->mediapath = $this->stagingmediapath;
		} else {
			$this->mediapath = $this->basemediapath;
		}
	}

	public static function convertNewlines($value){
		$value = preg_replace('/(<.*>)[ ]*\n/', "$1------MOP_NEWLINE------", $value);
		$value = preg_replace('/[ ]*\n/', '<br />', $value);
		$value = preg_replace('/------MOP_NEWLINE------/', "\n", $value);
		return $value;
	}

	public function saveIPE(){
		$this->model->$_POST['field'] = CMS_Services_Controller::convertNewlines($_POST['value']);
		$this->model->save();
		return array('value'=>$this->model->$_POST['field']);
	}

	public function saveField($field, $value){
		switch(Kohana::config('cms.modules.'.$this->model->template->templatename.'.'.$field.'.type')){
		case 'multiSelect':
			$this->saveObject();
			break;	
		default:
			$this->model->$field = CMS_Services_Controller::convertNewlines($value);
			break;
		}

		$this->model->save();
		return array('value'=>$this->model->$field);
	}

	//fields is fields=>values array
	public function saveFields($fields){
		foreach($fields as $field){
			if(isset($_POST[$field])){
				$this->model->$field = CMS_Services_Controller::convertNewlines($_POST[$field]);
			}
		}
		$this->model->save();
		return $model;
	}

	public function saveFieldMapping($field, $value){
		$this->model->trans_start();
		$map = false;
		if($this->model->field_associations){
			$map = unserialize($this->model->field_associations);
		}
		if(!$map){
			$map = array();
		}
		$map[$field] = $value;
		$this->model->field_associations = serialize($map);
		$this->model->save();
		$this->model->trans_complete();
		return true;
	}

	//this is gonna change a lot!
	//this only supports a very special case of multiSelect objects
	public function saveObject(){
		$object = ORM::Factory('page', $this->model->$_POST['field']);
		if(!$object->template_id){
			$object->template_id = 0;
		}

		$element['options'] = array();
		echo $object->template->templatename;
		foreach(Kohana::config('cms.modules.'.$object->template->templatename) as $field){
			if($field['type'] == 'checkbox'){
				$options = $field['field'];
			}
		}
		foreach($options as $field){
			$object->contenttable->$field  = 0;
		}

		foreach($_POST['values'] as $value){
			$object->contenttable->$value = 1;
		}
		$object->save();
		return true;
	}

	public function saveFile(){
		//check for valid file upload
		if(!isset($_POST['field'])){
			Kohana::log('error', 'No field in Post');
			throw new Kohana_User_Exception('no field in POST', 'no field in POST');
		}
		Kohana::log('info', 'proceeding with saveFile');

		$file = ORM::Factory('file', $this->model->$_POST['field']);
		
		$xarray = explode('.', $_FILES[$_POST['field']]['name']);
		$nr = count($xarray);
		$ext = $xarray[$nr-1];
		$name = array_slice($xarray, 0, $nr-1);
		$name = implode('.', $name);
		$i=1;
		if(!file_exists($this->mediapath."$name".'.'.$ext)){
			$i='';
		} else {
			for(; file_exists($this->mediapath."$name".$i.'.'.$ext); $i++){}
		}

		//clean up extension
		$ext = strtolower($ext);
		if($ext=='jpeg'){ $ext = 'jpg'; }

		$savename = $name.$i.'.'.$ext;

		if($this->savelocalfile){ //allow bypass of move_uploaded_file
			copy($this->savelocalfile, $this->mediapath.$savename);
		} else if(!move_uploaded_file($_FILES[$_POST['field']]['tmp_name'], $this->mediapath.$savename)){
			//	echo $this->mediapath.$savename;
			//throw new Kohana_User_Exception('Upload Failed', 'Unabled to move uploaded file');
			$result = array(
					'result'=>'failed',
					'error'=>'internal error, contact system administrator',
				);
			return $result;
		}
		Kohana::log('info', 'moved file to '.$this->mediapath.$savename);

		if(!is_object($file = $this->model->$_POST['field'])){
			$file = ORM::Factory('file', $this->model->$_POST['field']);
		}	

		if($file->loaded){
			$oldFilename = $file->filename;
		}

		$file->filename = $savename;	
		$file->mime = $_FILES[$_POST['field']]['type'];
		$file->save(); //inserts or updates depending on if it got loaded above

		$this->model->$_POST['field'] = $file->id;
		$this->model->save();

		if(isset($oldFilename) && ($savename != $oldFilename) ){
			Kohana::log('info', 'trying to unlink file');
			//then we have to get rid of the old file
			if(file_exists($this->mediapath.$oldFilename)){
				Kohana::log('info', 'unlinking '.$this->mediapath.$oldFilename);
				unlink($this->mediapath.$oldFilename);
			}
		}
		


		$parse = explode('.', $savename);
		$ext = $parse[count($parse)-1];
		$result = array(
			'id'=>$file->id,
			'src'=>$this->basemediapath.$savename,
			'filename'=>$savename,
			'ext'=>$ext,
			'result'=>'success',
		);
		Kohana::log('info', 'finished with saveFile '.var_export($result, true));
		return $result;

	}

	public function saveMappedPDF(){
		$result = $this->saveFile();
		if($result['result'] == 'success'){
			//rebuild the associations

			$associations = unserialize($this->model->field_associations);
			if(!is_array($associations)){
				$associations = array();
			}
			//get fields from pdf
			$p = PDF_new();
			$indoc = PDF_open_pdi_document($p, $result['src'], "");
			if ($indoc == 0) {
				die("Error: " . PDF_get_errmsg($p));
			}
			$blockcount = PDF_pcos_get_number($p, $indoc, "length:pages[0]/blocks");
			/* Loop over all blocks on the $page */
			$blocks = array();
			for ($i = 0; $i <  $blockcount; $i++) {
				$blocks[PDF_pcos_get_string($p, $indoc, "pages[0]/blocks[" . $i . "]/Name")] = true;
			}
			//take out blocks that have been removed
			$remove = array();
			foreach($associations as $key=>$value){
				if(!isset($blocks[$key])){
					$remove[] = $key;
				}
			}
			foreach($remove as $removal){
				unset($associations[$removal]);
			}
			//add in any new blocks
			$keys = array_keys($associations);
			foreach($blocks as $key=>$value){
				if(!in_array($key, $keys)){
					$associations[$key] = '';
				}
			}
			//and save serialized value
			$this->model->field_associations = serialize($associations);
			$this->model->save();
			//$result['fieldAssociations'] = $associations;

			//and build the html
			$fieldmapView = new View('ui_fieldmap');
			$fieldmapView->options = $this->model->getFieldmapOptions();
			$fieldmapView->values = $this->model->field_associations;
			$result['html'] = str_replace("\n", '',$fieldmapView->render() ) ;
			$result['html'] = str_replace("\t", '', $result['html']);
			$result['html'] = str_replace('"', 'mop_token_2009', $result['html']);
			//$result['html'] = 'date_completed select id="date_completed" name="date_completed" class="pulldown field-date_completed"';
		
		}
		return $result;
	}

	

	public function saveImage($parameters){
		Kohana::log('info', 'Saving Image '.var_export($parameters, true) );
		if(!isset($_POST['field'])){
			Kohana::log('error', 'No field in Post');
			throw new Kohana_User_Exception('no field in POST', 'no field in POST');
		}

		if($this->savelocalfile){
			$size = @getimagesize($this->savelocalfile);
		} else if(!$size = @getimagesize($_FILES[$_POST['field']]['tmp_name'])){
			Kohana::log('error', 'Bad upload tmp image');
			throw new Kohana_User_Exception('bad upload tmp image', 'bad upload tmp image');
		}

		$origwidth = $size[0];
		$origheight = $size[1];
		Kohana::log('info', var_export($parameters, true));
		if(isset($parameters['minheight']) &&  $origheight < $parameters['minheight']){
			$result = array(
				'result'=>'failed',
				'error'=>'Image height less than minimum height',
			);
			return $result;
		}
		if(isset($parameters['minwidth']) && $origwidth < $parameters['minwidth']){
			$result = array(
				'result'=>'failed',
				'error'=>'Image width less than minimum width',
			);
			return $result;
		}
		Kohana::log('info', "passed min tests with {$origwidth} x {$origheight}");

		//get original file names so we can delete them
		$file = ORM::Factory('file', $this->model->$_POST['field']);
		if($file->loaded){
			$oldFilename = $file->filename;
		}

		//do the saving of the file
		$result = $this->saveFile();
		Kohana::log('info', 'Returning to saveImage');


		$imageFilename = $this->processImage($result['filename'], $parameters);
		

		if(file_exists($this->mediapath.'uithumb_'.$imageFilename)){
			$resultpath = $this->mediapath.'uithumb_'.$imageFilename;
			$thumbSrc = $this->basemediapath.'uithumb_'.$imageFilename;
		} else {
			$resultpath = $this->mediapath.$imageFilename;
			$thumbSrc = $this->basemediapath.$imageFilename;
		}
		$size = getimagesize($resultpath);
		$result['width'] = $size[0];
		$result['height'] = $size[1];
		$result['thumbSrc']= $thumbSrc;

		//get rid of the old ones
		//but how to find them ???



		return $result;
	}


	/*
	 * Funciton: processImage($filename, $parameters)
	 * Create all automatice resizes on this image
	 */
	public function processImage($filename, $parameters){
		$ext = substr(strrchr($filename, '.'), 1);
		switch($ext){
		case 'tiff':
		case 'tif':
		case 'TIFF':
		case 'TIF':
			Kohana::log('info', 'Converting TIFF image to JPG for resize');

			$imageFilename =  $filename.'_converted.jpg';
			$command = sprintf('convert %s %s',addcslashes($this->mediapath.$filename, "'\"\\ "), addcslashes($this->mediapath.$imageFilename, "'\"\\ "));
			Kohana::log('info', $command);
			system(sprintf('convert %s %s',addcslashes($this->mediapath.$filename, "'\"\\ "),addcslashes($this->mediapath.$imageFilename, "'\"\\ ")));
			break;
		default:
			$imageFilename = $filename;
			break;
		}
		Kohana::log('info', $imageFilename);


		$quality = Kohana::config('cms_services.imagequality');

		//do the resizing
		if(is_array($parameters)){
			Kohana::log('info', 'poor man');
			$image = new Image($this->mediapath.$imageFilename);
			Kohana::log('info', 'poor man');
			foreach($parameters['imagesizes'] as $resize){

				if(isset($resize['prefix']) && $resize['prefix']){
					$prefix = $resize['prefix'].'_';
				} else {
					$prefix = '';
				}
				$newFilename = $prefix.$imageFilename;
				$savename = $this->mediapath.$newFilename;

				if(isset($resize['noresample']) && $resize['noresample']==true){
					$image->save($savename);
					continue;
				}


				//set up dimenion to key off of
				if( isset($resize['forcewidth']) && $resize['forcewidth']){
					$keydimension = Image::WIDTH;
				} else if ( isset($resize['forceheight']) && $resize['forceheight']){
					$keydimension = Image::HEIGHT;
				} else {
					$keydimension = Image::AUTO;
				}


				if(isset($resize['crop'])) {
					//resample with crop
					//set up sizes, and crop
					if( ($image->width / $image->height) > ($image->height / $image->width) ){
						$cropKeyDimension = Image::HEIGHT;
					} else {
						$cropKeyDimension = Image::WIDTH;
					}
					$image->resize($resize['width'], $resize['height'], $cropKeyDimension)->crop($resize['width'], $resize['height']);
					$image->quality($quality);
					$image->save($savename);


				} else {
					//just do the resample
					//set up sizes
					$resizewidth = $resize['width'];
					$resizeheight = $resize['height'];

					if(isset($resize['aspectfollowsorientation']) && $resize['aspectfollowsorientation']){
						$osize = getimagesize($this->mediapath.$imageFilename);
						$horizontal = false;
						if($osize[0] > $osize[1]){
							//horizontal
							$horizontal = true;	
						}
						$newsize = array($resizewidth, $resizeheight);
						sort($newsize);
						if($horizontal){
							$resizewidth = $newsize[1];
							$resizeheight = $newsize[0];
						} else {
							$resizewidth = $newsize[0];
							$resizeheight = $newsize[1];
						}
					}

					//maintain aspect ratio
					//use the forcing when it applied
					//forcing with aspectfolloworientation is gonna give weird results!
					$image->resize($resizewidth, $resizeheight, $keydimension);

					$image->quality($quality);
					$image->save($savename);

					if(isset($oldFilename) && $newFilename != $prefix.$oldFilename){
						if(file_exists($this->mediapath.$oldFilename)){
							unlink($this->mediapath.$oldFilename);
						}
					}


				}
			}
		}

		return $imageFilename;
	}


  public function regenerateImages(){
		//find all images
		//calculate resize array for images
		$uiimagesize = array('uithumb'=>Kohana::config('cms.uiresize'));
		$parameters['imagesizes'] = $uiimagesize;

		foreach(Kohana::config('cms.modules') as $templatename => $templateconfig){
			foreach($templateconfig as $field){
				if($field['type'] == 'singleImage'){
					$objects = ORM::Factory('template', $templatename)->getPublishedMembers();
					$fieldname = $field['field'];
					foreach($objects as $object){
						if( $object->contenttable->$fieldname->filename && file_exists($this->mediapath . $object->contenttable->$fieldname->filename)){
							$this->processImage($object->contenttable->$fieldname->filename, $parameters);
						}
					}
				}
			}
		}
		//loop through and call $this->saveImage on it
		//
	}


	/*
	Function: addFile
	OK so this takes the type of the subclass and uses it to the find the table (model actually)
	or the model hides that, not sure yet
	and then adds an item using the containerid as it's foreign key

	Returns  ???


	actually this function will be called from within the subclass
	*/
	public function addFile($containerid){

	}


}

?>
