<?

/* Class: CMS helper
 * Contains utility function for CMS
 */

class MoPCMS {

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
			$slug = preg_replace('/[^a-z0-9\- ]/', '', strtolower($title));
			$slug = str_replace(' ', '-', $slug);
			$slug = trim($slug);

			$checkSlug = ORM::Factory('object')
				->where('slug', 'REGEXP',  '^'.$slug.'[0-9]*$')
				->order_by("slug");
      	
			if($forPageId != NULL){
				$checkSlug->where('id', '!=', $forPageId);
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
			self::$mediapath = Kohana::config('mop_cms.stagingmediapath');
		} else {
			self::$mediapath = Kohana::config('mop_cms.basemediapath');
		}
		return self::$mediapath;
	}

	/*
	 *
	 */
	public static function resizeImage($originalFilename, $newFilename, $width, $height, $forceDimension='width', $crop='false'){
		//set up dimenion to key off of
		switch($forceDimension){
		case 'width':
			$keydimension = Image::WIDTH;
			break;
		case 'height':
			$keydimension = Image::HEIGHT;
			break;
		default:
			$keydimension = Image::AUTO;
			break;
		}

		$image = Image::factory(mopcms::mediapath().$originalFilename);
		if($crop) {
			//resample with crop
			//set up sizes, and crop
			if( ($image->width / $image->height) > ($image->height / $image->width) ){
				$cropKeyDimension = Image::HEIGHT;
			} else {
				$cropKeyDimension = Image::WIDTH;
			}
			$image->resize($width, $height, $cropKeyDimension)->crop($width, $height);
      $quality = Kohana::config('cms.imagequality');
			$image->save(mopcms::mediapath().$newFilename, $quality);

		} else {
			//just do the resample
			//set up sizes
			$resizewidth = $width;
			$resizeheight = $height;

			if(isset($resize['aspectfollowsorientation']) && $resize['aspectfollowsorientation']){
				$osize = getimagesize(mopcms::mediapath().$imageFilename);
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

      $quality = Kohana::config('cms.imagequality');
			$image->save(mopcms::mediapath() .$newFilename, $quality);

		}

	}

	/*
	 * Function: buildUIHtmlChunks
	 * This function builds the html for the UI elements specified in an object type's paramters
	 * Parameters:
	 * $parameters - the parameters array from an object type configuration
	 * Returns: Associative array of html, one entry for each ui element
	 */

		public static function buildUIHtmlChunks($elements, $object = null) {
				$view = new View();
				$htmlChunks = array();
				if (is_array($elements)) {
						foreach ($elements as $element) {

								//check if this element type is in fact a template
								$tConfig = mop::config('objects', sprintf('//template[@name="%s"]', $element['type']))->item(0);

								if ($tConfig) {
                           
										$field = $element['field'];
										$clusterObject = $object->contenttable->$field;
										//this should really happen within the models
										if (!$clusterObject) {
												$id = mopcms::addObject(null, $element['type']);
												$object->contenttable->$field = $id;
												$object->contenttable->save();
												$clusterObject = $object->contenttable->$field;
										}
										$clusterHtmlChunks = mopcms::buildUIHtmlChunksForObject($clusterObject);

										$customview = 'templates/' . $clusterObject->template->templatename; //check for custom view for this template
										$usecustomview = false;
										if (Kohana::find_file('views', $customview)) {
												$usecustomview = true;
										}
										if (!$usecustomview) {
												$html = implode($clusterHtmlChunks);
												$view = new View('clusters_wrapper');
												$view->label = $element['label'];
												$view->html = $html;
												$view->objectId = $clusterObject->id;
												$html = $view->render();
										} else {
												$view = new View($customview);
												$view->loadResources();
												foreach ($clusterHtmlChunks as $key => $value) {
														$view->$key = $value;
												}
												$html = $view->render();
										}
										$htmlChunks[$element['type'] . '_' . $element['field']] = $html;
										continue;
								}

				switch ($element['type']) {
               case 'element': //this should not be called 'element' as element has a different meaning
                  if (isset($element['arguments'])) {
                     $html = mop::buildModule($element, $element['elementname'], $element['arguments']);
                  } else {
                     $html = mop::buildModule($element, $element['elementname']);
                  }
                  $htmlChunks[$element['modulename']] = $html;
                  break;
               case 'list':
                  if (isset($element['display']) && $element['display'] != 'inline') {
                     break; //element is being displayed via navi, skip
                  }
                  $element['elementname'] = $element['family'];
                  $element['controllertype'] = 'list';


                  $requestURI = 'list/getList/' . $object->id . '/' . $element['family'];
                  $htmlChunks[$element['family']] = Request::factory($requestURI)->execute()->body();


                  //$htmlChunks[$element['family']] = mop::buildModule($element, $arguments);
                  break;
               case 'associator':
                  $controller = new Associator_Controller($element['filters'], $object->id, $element['field']);
                  $controller->createIndexView();
                  $controller->view->loadResources();
                  $key = $element['type'] . '_' . $element['field'];
                  $htmlChunks[$key] = $controller->view->render();
                  
                  break;

               case 'tags':
                  $tags = implode(',', $object->getTags());
                  $elementHtml = mopui::tags($tags);
                  $key = $element['type'] . '_tags';
                  $htmlChunks[$key] = $elementHtml;

                  break;
               default:
                  //deal with html template elements
                  $key = $element['type'] . '_' . $element['field'];
                  $html = null;
                  if (!isset($element['field'])) {
                     $element['field'] = CMS_Controller::$unique++;
                     $html = mopui::buildUIElement($element, null);
                  } else if (!$html = mopui::buildUIElement($element, $object->contenttable->$element['field'])) {
                     throw new Kohana_Exception('bad config in cms: bad ui element');
                  }
                  $htmlChunks[$key] = $html;
                  break;
            }
         }
      }
      //print_r($htmlChunks);
      return $htmlChunks;
   }

   public static function buildUIHtmlChunksForObject($object) {
      $elements = mop::config('objects', sprintf('//template[@name="%s"]/elements/*', $object->template->templatename));
      // should be Model_object->getElements();
      // this way a different driver could be created for non-xml config if desired
      $elementsConfig = array();
      //echo 'BUILDING'.$object->template->templatename.'<br>'; 
      foreach ($elements as $element) {
         //echo 'FOUND AN ELEMENT '.$element->tagName.'<br>';
         $entry = array();
         $entry['type'] = $element->tagName;
         for ($i = 0; $i < $element->attributes->length; $i++) {
            $entry[$element->attributes->item($i)->name] = $element->attributes->item($i)->value;
         }
         //make sure defaults load
         $entry['tag'] = $element->getAttribute('tag');
         $entry['rows'] = $element->getAttribute('rows');
         //any special xml reading that is necessary
         switch ($entry['type']) {
            case 'file':
            case 'image':
               $ext = array();
               //echo sprintf('/template[@name="%s"]/elements/image[@field="%s]"/ext', $object->template->templatename, $element->getAttribute('field'));
               $children = mop::config('objects', 'ext', $element);
               foreach ($children as $child) {
                  if ($child->tagName == 'ext') {
                     $ext[] = $child->nodeValue;
                  }
               }
               $entry['extensions'] = implode(',', $ext);
               break;
            case 'radioGroup':
               $children = mop::config('objects', 'radio', $element);
               $radios = array();
               foreach ($children as $child) {
                  $label = $child->getAttribute('label');
                  $value = $child->getAttribute('value');
                  $radios[$label] = $value;
               }
               $entry['radios'] = $radios;
               break;

            case 'associator':
               //need to load filters here
               $filters = mop::config('objects', sprintf('//template[@name="%s"]/elements/*[@field="%s"]/filter', 
							$object->template->templatename,
							$element->getAttribute('field') ));
				$filterSettings = array();
				foreach($filters as $filter){
					$setting = array();
					$setting['from'] = $filter->getAttribute('from');
					$setting['templateName'] = $filter->getAttribute('templateName');
					$setting['tagged'] = $filter->getAttribute('tagged');
					$filterSettings[] = $setting;
				}
				$entry['filters'] = $filterSettings;

      default:
        break;
      }
			$elementsConfig[] = $entry;
		}
    return mopcms::buildUIHtmlChunks($elementsConfig, $object);
  }

	public static function regenerateImages(){
		//find all images

		foreach(mop::config('objects', '//template') as $template){
			foreach(mop::config('objects', 'elements/*', $template) as $element){
				if($element->tagName == 'image'){
					$objects = ORM::Factory('template', $template->getAttribute('name'))->getActiveMembers();
					$fieldname = $element->getAttribute('field');
					foreach($objects as $object){
						if(is_object($object->contenttable->$fieldname) && $object->contenttable->$fieldname->filename && file_exists(mopcms::mediapath() . $object->contenttable->$fieldname->filename)){
							$object->processImage($object->contenttable->$fieldname->filename, $fieldname);
						}
					}
				}
			}
		}
	}

	public static function generateNewImages($objectIds){
		foreach($objectIds as $id){
			$object = ORM::Factory('object', $id);
			foreach(mop::config('objects', sprintf('//template[@name="%s"]/elements/*', $object->template->templatename)) as $element){
				if($element->tagName == 'image'){
					$fieldname = $element->getAttribute('field');
					if(is_object($object->contenttable->$fieldname) && $object->contenttable->$fieldname->filename && file_exists(mopcms::mediapath() . $object->contenttable->$fieldname->filename)){
						$object->processImage($object->contenttable->$fieldname->filename, $fieldname);
					}
				}
			}	
		}
	}


	

	

}


