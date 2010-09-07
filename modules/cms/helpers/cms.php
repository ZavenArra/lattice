<?

/* Class: CMS helper
 * Contains utility function for CMS
 */

class CMS {

	private static $mediapath;

	/*
	 * Variable: createSlug($title, $forPageId)
	 * Creates a unique slug to identify a page
	 * Parameters:
	 * $title - optional title for the slug
	 * $forPageId - optionally indicate the id of the page this slug is for to avoid false positive slug collisions
	 * Returns: The new, unique slug
	 */
	public static function createSlug($title=NULL, $forPageId=NULL){
		//create slug
		if($title!=NULL){
			$removeChars = array(
				"'",
				'"',
				'&',
				'?',
				'/',
				'\\',
				')',
				'(',
			);
			Kohana::log('info', $title);
			$slug = str_replace($removeChars, '', strtolower($title));
			$slug = str_replace(' ', '-', strtolower($slug));
			Kohana::log('info', $slug);
			$checkSlug = ORM::Factory('page')
				->regex('slug', '^'.$slug.'[0-9]*$')
				->orderby("slug");
			if($forPageId != NULL){
				$checkSlug->where('pages.id != '.$forPageId);
			}
			$checkSlug = $checkSlug->find_all();
			if(count($checkSlug)){
				$idents = array();
				foreach($checkSlug as $ident){
					$idents[] = $ident->slug;
				}
				natsort($idents);
				$idents = array_values($idents);
				$maxslug = $idents[count($idents)-1];
				if($maxslug){
					$curindex = substr($maxslug, strlen($slug));
					$newindex = $curindex+1;
					$slug .= $newindex;
				}
			}
			return $slug;
		} else {
			return 'No_Title_'.microtime(); //try something else
		}
	}

	public static function convertNewlines($value){
		$value = preg_replace('/(<.*>)[ ]*\n/', "$1------MOP_NEWLINE------", $value);
		$value = preg_replace('/[ ]*\n/', '<br />', $value);
		$value = preg_replace('/------MOP_NEWLINE------/', "\n", $value);
		return $value;
	}

	public static function mediapath(){
		if(self::$mediapath){
			return self::$mediapath;
		}
		if(Kohana::config('mop.staging')){
			self::$mediapath = Kohana::config('cms.stagingmediapath');
		} else {
			self::$mediapath = Kohana::config('cms.basemediapath');
		}
		return self::$mediapath;
	}

	/*
	 * Functon: processImage($filename, $parameters)
	 * Create all automatice resizes on this image
	 */
	public static function processImage($filename, $parameters){
		$ext = substr(strrchr($filename, '.'), 1);
		switch($ext){
		case 'tiff':
		case 'tif':
		case 'TIFF':
		case 'TIF':
			Kohana::log('info', 'Converting TIFF image to JPG for resize');

			$imageFilename =  $filename.'_converted.jpg';
			$command = sprintf('convert %s %s',addcslashes(cms::mediapath().$filename, "'\"\\ "), addcslashes(cms::mediapath().$imageFilename, "'\"\\ "));
			Kohana::log('info', $command);
			system(sprintf('convert %s %s',addcslashes(cms::mediapath().$filename, "'\"\\ "),addcslashes(cms::mediapath().$imageFilename, "'\"\\ ")));
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
			$image = new Image(cms::mediapath().$imageFilename);
			Kohana::log('info', 'poor man');
			foreach($parameters['imagesizes'] as $resize){

				if(isset($resize['prefix']) && $resize['prefix']){
					$prefix = $resize['prefix'].'_';
				} else {
					$prefix = '';
				}
				$newFilename = $prefix.$imageFilename;
				$savename = cms::mediapath().$newFilename;

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
						$osize = getimagesize(cms::mediapath().$imageFilename);
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
						if(file_exists(cms::mediapath().$oldFilename)){
							unlink(cms::mediapath().$oldFilename);
						}
					}


				}
			}
		}

		return $imageFilename;
	}

	/*
	 * Function: buildUIHtmlChunks
	 * This function builds the html for the UI elements specified in an object type's paramters
	 * Parameters:
	 * $parameters - the parameters array from an object type configuration
	 * Returns: Associative array of html, one entry for each ui element
	 */
	public static function buildUIHtmlChunks($parameters, $object = null){
		$view = new View();
		$htmlChunks = array();
		if(is_array($parameters)){
			foreach($parameters as $module){
				switch($module['type']){
				case 'module':
					if(isset($module['arguments'])){
						$html = mop::buildModule($module, $module['modulename'], $module['arguments']);
					} else {
						$html = mop::buildModule($module, $module['modulename']);
					}
					$htmlChunks[$module['modulename']] = $html;
					break;
				case 'list':
					if(isset($module['display']) && $module['display'] != 'inline'){
						break; //module is being displayed via navi, skip
					}
					$module['modulename'] = $module['family'];
					$module['controllertype'] = 'list';
					$lt = ORM::Factory('template', $module['family']);
					$containerObject = ORM::Factory('page')
						->where('parentid', $object->id)
						->where('template_id', $lt->id)
						->where('activity IS NULL')
						->find();
          if(!$containerObject->loaded){
            throw new Kohana_User_Exception('Did not find list container', 'List object is missing container: '.$lt->id);
          }
					$arguments = array(
						'containerObject'=>$containerObject
					);
					$htmlChunks[$module['family']] = mop::buildModule($module, $arguments);
					break;
				default:
					$element = false;
					//deal with html template elements
					if(!isset($module['field'])){
						$element = mopui::buildUIElement($module, null);
						$module['field'] = CMS_Controller::$unique++;
					} else if(!$element = mopui::buildUIElement($module, $object->contenttable->$module['field'])){
						throw new Kohana_User_Exception('bad config in cms', 'bad ui element');
					}
					$htmlChunks[$module['type'].'_'.$module['field']] = $element;
					break;
				}
			}
		}
		return $htmlChunks;
	}

  
	public static function buildUIHtmlChunksForObject($object){
		$elements = mop::config('backend', sprintf('//template[@name="%s"]/elements/*', $object->template->templatename));
    $elementsConfig = array();
		foreach($elements as $element){
			$entry = array();
      $entry['type'] = $element->tagName;
			for($i=0; $i<$element->attributes->length; $i++){
				$entry[$element->attributes->item($i)->name] = $element->attributes->item($i)->value;
			}	
      //any special xml reading that is necessary
      switch($entry['type']){
      case 'singleFile':
      case 'singleImage':
        $ext = array();
        //echo sprintf('/template[@name="%s"]/elements/singleImage[@field="%s]"/ext', $object->template->templatename, $element->getAttribute('field'));
        $children = mop::config('backend', sprintf('//template[@name="%s"]/elements/%s[@field="%s"]/ext', $object->template->templatename, $element->tagName, $element->getAttribute('field')));
        foreach($children as $child){
          if($child->tagName == 'ext'){
            $ext[] = $child->nodeValue; 
          }
        }
        $entry['extensions'] = implode(',', $ext);
        break;

      default:
        break;
      }
			$elementsConfig[] = $entry;
		}

    return cms::buildUIHtmlChunks($elementsConfig, $object);
  }

	public function regenerateImages(){
		//find all images
		//calculate resize array for images
		$uiimagesize = array('uithumb'=>Kohana::config('cms.uiresize'));
		$parameters['imagesizes'] = $uiimagesize;

		foreach(Kohana::config('cms.templates') as $templatename => $templateconfig){
			foreach($templateconfig as $field){
				if($field['type'] == 'singleImage'){
					$objects = ORM::Factory('template', $templatename)->getPublishedMembers();
					$fieldname = $field['field'];
					foreach($objects as $object){
						if( $object->contenttable->$fieldname->filename && file_exists(cms::mediapath() . $object->contenttable->$fieldname->filename)){
							cms::processImage($object->contenttable->$fieldname->filename, $parameters);
						}
					}
				}
			}
		}
	}

	/*
	 * Function: checkForValidPageId($id) 
	 * Validates the current page id 
	 * Parameters:
	 * $id  - the id to check 
	 * Returns: throws exception on invalid page id
	 */
	public function checkForValidPageId($id){
		if(!ORM::Factory('page')->where('id', $id)->find()->loaded){
			throw new Kohana_User_Exception('Bad Page Id', 'The id '.$id.' is not a key in for an object in the pages table');
		}
	}

	/*
	Function: addObject($id)
	Private function for adding an object to the cms data
	Parameters:
	id - the id of the parent category
	template_id - the type of object to add
	$data - possible array of keys and values to initialize with
	Returns: the new page id
	*/
	public function addObject($id, $template_id, $data = array() ){
		if($id!=='0' && $id!==0){
			echo 'the id'.$id;
			cms::checkForValidPageId($id);
		}
		$newpage = ORM::Factory('page');
		$newpage->template_id = $template_id;

		//create slug
		if(isset($data['title'])){
			$newpage->slug = cms::createSlug($data['title'], $newpage->id);
		} else {
			$newpage->slug = cms::createSlug();
		}
		$newpage->parentid = $id;
		$newpage->save();
	

		//check for enabled publish/unpublish. 
		//if not enabled, insert as published
		$template = ORM::Factory('template', $template_id);
		$tSettings = mop::config('backend', sprintf('//template[@name="%s"]', $template->templatename) ); 
		echo  sprintf('/template[@name="%s"]', $template->templatename);
		echo $tSettings->length;
		$tSettings = $tSettings->item(0);
		if($tSettings->getAttribute('allowTogglePublish')){
			$newpage->published = 1;
		}
		if(isset($data['published']) && $data['published'] ){
			$newpage->published = 1;
			unset($data['published']);
		}

		$newpage->save();

		//Add defaults to content table
		$newtemplate = ORM::Factory('template', $newpage->template_id);
		/*
		 * this little tidbit is no longer supported
		 * the idea was to be able to configure content defaults on adding
		 * not really used too often
		 */
		/*
		$contentDefaults = Kohana::config('cms.templates.'.$newpage->template->templatename.'.defaults');
		if(is_array($contentDefaults) && count($contentDefaults)){
			foreach($contentDefaults as $field=>$value){
				$newpage->contenttable->$field = $value;
			}
			$newpage->contenttable->save();
		}
		 */

		//add submitted data to content table
		foreach($data as $field=>$value){
			$newpage->contenttable->$field = $data[$field];
		}
		$newpage->contenttable->save();

		//look up any components and add them as well

		//configured components
		$components = mop::config('backend', sprintf('//template[@name="%s"]/component',$newtemplate->templatename));
		foreach($components as $c){
			$template = ORM::Factory('template', $c->getAttribute('templateId'));
			if($c->hasChildNodes()){
				foreach($c->childNodes as $data){
					$arguments[$data->name] = $data->value;
				}
			}
			cms::addObject($newpage->id, $newtemplate->id, $arguments);
		}

		//containers (list)
		$containers = mop::config('backend', sprintf('//template[@name="%s"]/elements/list',$newtemplate->templatename));
		foreach($containers as $c){
			$template = ORM::Factory('template', $c->getAttribute('family'));
			$arguments['title'] = $c->getAttribute('label');
			cms::addObject($newpage->id, $template->id, $arguments);
		}

		return $newpage->id;
	}



}


