<?
require_once('../includes/resample.php');

class GMS_Controller extends Controller{

	var $gallerytable = 'galleries';
	var $imagetable = 'gallery_images';

	var $gms_resize = array(
		'tag' => 'thumb',
 		'width'=> 160,
 		'height'=>117,
		'prefix'=>'thumb_',
 		'forceheight'=> true,
 	);

	function GMS($featurettename, $arguments=null){
		parent::Featurette($featurettename);
		$this->galleryid = $_REQUEST['galleryid'];
		$this->assigns['galleryid'] = $_REQUEST['galleryid'];

		if($arguments){
			$this->instance = $arguments['instance'];
		} else {
			$this->instance = $_REQUEST['instance'];
		}
		if($this->instance == 'undefined'){
			$this->instance = NULL;
		}

		if($this->instance){
			require('../modules/gms/settings/'.$this->instance.'.settings.php');
		$this->setup = $settings;
		}
		$this->setup[] = $this->gms_resize;
	}

	function buildFeaturette(){
		parent::buildFeaturette();
		if($this->galleryid){
			$gallery = DB_DataObject::factory($this->gallerytable);
			$gallery->galleryid = $this->galleryid;
			if(!$gallery->find(true)){
				$gallery = DB_DataObject::factory($this->gallerytable);
				$gallery->galleryid = $this->galleryid;
				$gallery->insert();
			}
			$data = $gallery->toArray();
			foreach($data as $name => $value){
				$this->assigns[$name] = $value;
			}
		}
		$galleries = DB_DataObject::factory($this->gallerytable);
		$galleries->find();
		$this->assigns['galleries'] = array();
		while($galleries->fetch()){
			$this->assigns['galleries'][] = $galleries->toArray();	
		}
	}

	function doActions(){
		switch($_REQUEST['action']){
			case 'add':
				$gallery = DB_DataObject::factory($this->gallerytable);
				$gallery->title = 'New Gallery';
				$this->galleryid = $gallery->insert();
				break;
		}
	}

	function getImageData($imageobj){
		$data = $imageobj->toArray();

		$imageid = $imageobj->imageid;
		foreach($this->setup as $setup){
			$data[$setup['tag'].'src'] = 'galleryimage_'.$setup['prefix'].$imageid.'.jpg';
			if(file_exists(FULLPATH.'/../media/'.'galleryimage_'.$setup['prefix'].$imageid.'.jpg')){
				$size = getImageSize(FULLPATH.'/../media/'.'galleryimage_'.$setup['prefix'].$imageid.'.jpg');
				$data[$setup['tag'].'width'] = $size[0];
				$data[$setup['tag'].'height'] = $size[1];
			}
		}
		return $data;
	}

	function doAjax(){
		switch($_REQUEST['action']){
			case 'load':
				$this->buildFeaturette();
				return $this->toHTML();
				break;
			case 'initgms':
				$gimages = DB_DataObject::factory($this->imagetable);
				$gimages->galleryid = $this->galleryid;
				$gimages->orderby('sortorder');
				$gimages->find();

				$html='';
				$data=array();

				while($gimages->fetch()){
					$this->assigns['image'] = $gimages->toArray();	
					$this->loadTemplate('gms_image');
					$html .= $this->toHTML();
					$data[] = $this->getImageData($gimages);
				}
				$output = array('data'=>$data, 'html'=>$html);

	//			header('Content-type: text/x-json');
				$json = new Services_JSON();
				$output = $json->encode($output);
				return $output;

				break;
			case 'addimage':

				$filename = FULLPATH.'/../uploads/'.$_REQUEST['newimage'];
				$gimage = DB_DataObject::factory($this->imagetable);
				$gimage->galleryid = $_REQUEST['galleryid'];
//				$exif = read_exif_data( $filename );
//				$gimage->photographer = $exif['IFD0']['Copyright'];
//				$date = explode(' ', $exif['DateTime']);
//				$date = $date[0];
//				$gimage->copyright_date = $date;


				$imagename = explode('/', $_REQUEST['newimage']);
				$gimage->title = $imagename[count($imagename)-1];
				$imageid = $gimage->insert();

				if(file_exists($filename) ) {
					$dimensions = getimagesize( $filename );
					$img_width = $dimensions[0];
					$img_height = $dimensions[1];
				}
				

				foreach($this->setup as $resize){

					//if the original image is smaller than the resize, don't resize it at all
					if($img_width <= $resize['width'] && $img_height <= $resize['height'] ) {
						copy( $filename, FULLPATH.'/../media/'.'galleryimage_'.$resize['prefix'].$imageid.'.jpg');
						continue;
					}

					
					
					if($img_width < $resize['width'] && $resize['forcewidth'] && $resize['height']){
						$resize['forcewidth'] = false;
						$resize['forceheight'] = true;
					} else if($img_height < $resize['height'] && $resize['forceheight'] && $resize['width']){
						$resize['forcewidth'] = true;
						$resize['forceheight'] = false;
					}

					//set up sizes
					if($resize['forcewidth']&&$resize['forceheight']){
						$height = $resize['height'];
						$width = $resize['width'];
					} else {
						//maintain aspect ratio
						if( (!$resize['forcewidth'] && ($img_width > $img_height) )   // might just be able to say, are we streching, and if so, skip and then just copy at the end..

						|| $resize['forceheight'] ){

							//if image will strech vertically but there's no width set, don't resize 
							if($img_height < $resize['height'] && !$resize['width']){
								copy( $filename, FULLPATH.'/../media/'.'galleryimage_'.$resize['prefix'].$imageid.'.jpg');
								continue;
							}	 

							//go ahead and resize
							$height = $resize['height'];
							$width = $resize['height']/$img_height * $img_width;
						} else {

							//if the image will stretch horizontally but there is not height set, don't resize
							if($img_width < $resize['width'] && !$resize['height']){
								copy( $filename, FULLPATH.'/../media/'.'galleryimage_'.$resize['prefix'].$imageid.'.jpg');
								continue;
							}

							//go ahead and resize it
							$height = $resize['width']/$img_width * $img_height;
							$width = $resize['width'];
						}
					}
//					error_log("$width $height ");


					resampimagejpg( $width, $height, $filename, FULLPATH.'/../media/'.'galleryimage_'.$resize['prefix'].$imageid.'.jpg', '0');
					chmod(FULLPATH.'/../media/'.'galleryimage_'.$resize['prefix'].$imageid.'.jpg', 0777);
				}


				$gimage = DB_DataObject::factory($this->imagetable);
				$gimage->get($imageid);
				

				// convert a complex value to JSON notation

				$this->loadTemplate('gms_image');
				$imageinfo = $gimage->toArray();
				$this->assigns['image'] = $imageinfo;
				$this->assigns['width'] = $resize['width'];		// value no exist! $thumbwidth;
				$this->assigns['height'] = $resize['height'];	// value no exist! $thumbheight;
				$html = $this->toHTML();

				$data = $this->getImageData($gimage);
				
				$output = array();
				$output['html'] = "$html";
				$output['data'] = $data;

				$json = new Services_JSON();
				$output = $json->encode($output);
				
				header('Content-type: text/x-json');
				return $output;
				break;
			case 'saveSortOrder':
				$order = explode(',', $_REQUEST['sortorder']);

				for($i=0; $i<count($order); $i++){
					$image = DB_DataObject::factory($this->imagetable);
					$image->imageid = $order[$i];
					$image->find(true);
					$orig = clone($image);
					$image->sortorder = $i+1;
					$image->update();
				}
				break;

			case 'delete':
				$image = DB_DataObject::factory($this->imagetable);
				$image->get($_REQUEST['imageid']);
				$image->imageid = $_REQUEST['imageid'];
				$images->galleryid = $_REQUEST['galleryid'];
				$image->delete();
				foreach($this->setup as $setup){
					unlink('galleryimage_'.$setup['prefix'].$_REQUEST['imageid'].'.jpg');
				}
			break;

		case 'deleteGallery':
			$gallery = DB_DataObject::factory($this->gallerytable);
			$gallery->galleryid = $_REQUEST['galleryid'];
			$gallery->delete();
			$images = DB_DataObject::factory($this->imagetable);
			$images->galleryid = $_REQUEST['galleryid'];
			$images->find();
			while($images->fetch()){
				foreach($this->setup as $setup){
					unlink('galleryimage_'.$setup['prefix'].$images->imageid.'.jpg');
					$dimage = DB_DataObject::factory($this->imagetable);
					$dimage->imageid = $images->imageid;
					$dimage->delete();
				}
			}
			break;

		case 'savefield':
			$gallery = DB_DataObject::factory($this->gallerytable);
			$gallery->get($_REQUEST['galleryid']);
			$orig = clone($gallery);
			
			//request string to see what fields are present
			if($_REQUEST['field']){
				$gallery->$_REQUEST['field'] = $_REQUEST['value'];
			} else {
				foreach($orig->toArray as $field=>$value){
					$gallery->$field = $_REQUEST[$field];
				}
			}
			$gallery->update($orig);
			$gallery = DB_DataObject::factory($this->gallerytable);
			$gallery->get($_REQUEST['galleryid']);
			return $gallery->$_REQUEST['field'];
			break;

		case 'saveimagefield':
			$image = DB_DataObject::factory($this->imagetable);
			$image->get($_REQUEST['imageid']);
			$orig = clone($image);
			
			//request string to see what fields are present
			if($_REQUEST['field']){
				$image->$_REQUEST['field'] = $_REQUEST['value'];
			} else {
				foreach($orig->toArray as $field=>$value){
					$image->$field = $_REQUEST[$field];
				}
			}
			$image->update($orig);
			$image = DB_DataObject::factory($this->imagetable);
			$image->get($_REQUEST['imageid']);
			return $image->$_REQUEST['field'];
			break;
		}
	}

}

?>
