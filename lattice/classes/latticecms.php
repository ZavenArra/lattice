<?

/* Class: CMS helper
 * Contains utility function for CMS
 */
/* @package Lattice */

class latticecms {

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

								//check if this element type is in fact a objectType
								$tConfig = lattice::config('objects', sprintf('//objectType[@name="%s"]', $element['type']))->item(0);

								if ($tConfig) {
                           
										$field = $element['name'];
										$clusterObject = $object->$field;
										//this should really happen within the models
										
										$clusterHtmlChunks = latticecms::buildUIHtmlChunksForObject($clusterObject);

										$customview = 'objectTypes/' . $clusterObject->objecttype->objecttypename; //check for custom view for this objectType
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
										$htmlChunks[$element['type'] . '_' . $element['name']] = $html;
										continue;
								}
            
            /*
             * Set up UI arguments to support uniquely generated field names when
             * multiple items being displayed have the same field names
             */
            $uiArguments = $element;
            if(isset($element['fieldId'])){
               $uiArguments['name'] = $element['fieldId'];
            }

				switch ($element['type']) {
               case 'element': //this should not be called 'element' as element has a different meaning
                  if (isset($element['arguments'])) {
                     $html = lattice::buildModule($element, $element['elementname'], $element['arguments']);
                  } else {
                     $html = lattice::buildModule($element, $element['elementname']);
                  }
                  $htmlChunks[$element['modulename']] = $html;
                  break;
               case 'list':
                  if (isset($element['display']) && $element['display'] != 'inline') {
                     break; //element is being displayed via navi, skip
                  }
                  $element['elementname'] = $element['name'];
                  $element['controllertype'] = 'list';


                  $requestURI = 'list/getList/' . $object->id . '/' . $element['name'];
                  $htmlChunks[$element['name']] = Request::factory($requestURI)->execute()->body();
                  break;

               case 'associator':
                  $associator = new Associator($object->id, $element['lattice'],$element['filters']);
                  $key = $element['type'] . '_' . $uiArguments['name'];
                  $htmlChunks[$key] = $associator->render();
                  
                  break;

               case 'tags':
                  $tags = $object->getTagStrings();
                  $elementHtml = latticeui::tags($tags);
                  $key = $element['type'] . '_tags';
                  $htmlChunks[$key] = $elementHtml;

                  break;

               case 'password':
                  $key = $element['type'] . '_' . $uiArguments['name'];
                  $html = self::buildUIElement($element, $uiArguments, NULL);
                  $htmlChunks[$key] = $html;
                  break;
               
               default:
                  //deal with html objectType elements
                  $key = $element['type'] . '_' . $uiArguments['name'];
                  $html = self::buildUIElement($element, $uiArguments, $object->{$element['name']});
                  $htmlChunks[$key] = $html;
                  break;
            }
         }
      }
      //print_r($htmlChunks);
      return $htmlChunks;
   }
   
   private static function buildUIElement($element, $uiArguments, $value){
     
      $html = null;
      if (!isset($element['name'])) {
         $element['name'] = CMS_Controller::$unique++;
         $html = latticeui::buildUIElement($element, null);
      } else if (!$html = latticeui::buildUIElement($uiArguments, $value)) {
         throw new Kohana_Exception('bad config in cms: bad ui element');
      }
      return $html;
   }

   public static function getElementConfig($object, $elementName){
     $element = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/[@name="%s"]',
       $object->objecttype->objecttypename,
       $elementName
     ));
     return self::convertXMLElementToArray($object, $element->item(0));
   }

   public static function buildUIHtmlChunksForObject($object, $translatedLanguageCode = null) {
      $elements = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*', $object->objecttype->objecttypename));
      // should be Model_object->getElements();
      // this way a different driver could be created for non-xml config if desired
      $elementsConfig = array();
      foreach ($elements as $element) {

        $entry = self::convertXmlElementToArray($object, $element);

        $elementsConfig[$entry['name']] = $entry;
      }
			return latticecms::buildUIHtmlChunks($elementsConfig, $object);
	 }

   private static function convertXMLElementToArray($object, $element){
     $entry = array();
     //$entry should become an object, that contains configuration logic for each  view
     //or better yet, each mopui view should have it's own view object
     //which translates the configuration into the view display

     $entry['type'] = $element->tagName;
     for ($i = 0; $i < $element->attributes->length; $i++) {
       $entry[$element->attributes->item($i)->name] = $element->attributes->item($i)->value;
     }
     //load defaults
     $entry['tag'] = $element->getAttribute('tag');
     $entry['isMultiline'] = ( $element->getAttribute('isMultiline') == 'true' )? true : false;

     //any special xml reading that is necessary
     switch ($entry['type']) {
     case 'file':
       case 'image':
         $ext = array();
         $children = lattice::config('objects', 'ext', $element);
         foreach ($children as $child) {
           if ($child->tagName == 'ext') {
             $ext[] = $child->nodeValue;
           }
         }
         $entry['extensions'] = implode(',', $ext);
         break;
       case 'radioGroup':
         $children = lattice::config('objects', 'radio', $element);
         $radios = array();
         foreach ($children as $child) {
           $label = $child->getAttribute('label');
           $value = $child->getAttribute('value');
           $radios[$label] = $value;
               }
               $entry['radios'] = $radios;
               break;

             // Begin pulldown change
             case 'pulldown':
               $children = lattice::config('objects', 'option', $element); //$element['type']);
               $options  = array();
               foreach ($children as $child) {
                  $label = $child->getAttribute('label');
                  $value = $child->getAttribute('value');
                  $options[$value] = $label;
               }
               $entry['options'] = $options;  
               break;


            case 'associator':
               //need to load filters here
               $filters = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]/filter', 
								 $object->objecttype->objecttypename,
								 $element->getAttribute('name') ));
							 $filterSettings = array();
							 foreach($filters as $filter){
								 $setting = array();
								 $setting['from'] = $filter->getAttribute('from');
								 $setting['objectTypeName'] = $filter->getAttribute('objectTypeName');
								 $setting['tagged'] = $filter->getAttribute('tagged');
								 $filterSettings[] = $setting;
							 }
							 $entry['filters'] = $filterSettings;
							 break;
						case 'tags':
							$entry['name'] = 'tags'; //this is a cludge
							break;

						default:
							break;
				 }
     return $entry;

   }

	public static function regenerateImages(){
		//find all images
		foreach(lattice::config('objects', '//objectType') as $objectType){
			foreach(lattice::config('objects', 'elements/*', $objectType) as $element){
				if($element->tagName == 'image'){
					$objects = ORM::Factory('objectType', $objectType->getAttribute('name'))->getActiveMembers();
					$fieldname = $element->getAttribute('name');
					foreach($objects as $object){
           	if(is_object($object->$fieldname) && $object->$fieldname->filename && file_exists(Graph::mediapath() . $object->$fieldname->filename)){
							$uiresizes = Kohana::config('lattice_cms.uiresizes');
							$object->processImage($object->$fieldname->filename, $fieldname, $uiresizes);
						}
					}
				}
			}
		}
	}

	public static function generateNewImages($objectIds){
		foreach($objectIds as $id){
			$object = Graph::object($id);
      foreach(lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*', $object->objecttype->objecttypename)) as $element){
				if($element->tagName == 'image'){
					$fieldname = $element->getAttribute('name');
					if(is_object($object->$fieldname) && $object->$fieldname->filename && file_exists(Graph::mediapath() . $object->$fieldname->filename)){
						$uiresizes = Kohana::config('lattice_cms.uiresizes');
						$object->processImage($object->$fieldname->filename, $fieldname, $uiresizes);
					}
				}
			}	
		}
	}



   public static function saveHttpPostFile($objectid, $field, $postFileVars) {
      Kohana::$log->add(Log::ERROR, 'save uploaded');
      $object = Graph::object($objectid);
      //check the file extension
      $filename = $postFileVars['name'];
      $ext = substr(strrchr($filename, '.'), 1);
      switch ($ext) {
         case 'jpeg':
         case 'jpg':
         case 'gif':
         case 'png':
         case 'JPEG':
         case 'JPG':
         case 'GIF':
         case 'PNG':
         case 'tif':
         case 'tiff':
         case 'TIF':
         case 'TIFF':
            Kohana::$log->add(Log::ERROR, 'save uploaded');
						$uiresizes = Kohana::config('lattice_cms.uiresizes');
            return $object->saveUploadedImage($field, $postFileVars['name'], $postFileVars['type'], $postFileVars['tmp_name'], $uiresizes);
            break;

         default:
            return $object->saveUploadedFile($field, $postFileVars['name'], $postFileVars['type'], $postFileVars['tmp_name']);
      }
   }

}


