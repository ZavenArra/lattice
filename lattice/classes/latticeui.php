<?

/*
 * Class: latticeui
 * Helper class which generates all the latticeui form elements
 * Functions in this class need to be stardardized and have their parameters cleaned up
 */
/* @package Lattice */

Class latticeui{

	private static $unique = 1;

	/*
	 * Function: buildUIElement
	 * Builds a UI element from the latticeui views directory
	 * $element -  array of key value pairs passed to the objectType, including 'type' key which indicates the objectType to use
	 * $fieldvalue - the value to display
	 * Example: buildTextElement(array('type'=>'text', 'name'=>'fieldname', 'class'=>'className'), {Value})
	 */
	public static function buildUIElement($element, $fieldvalue=null){
		$view = 'ui_'.$element['type'];

		//allow files to be passed either by id or as already quireid objects
		if( in_array($element['type'], array('file', 'image'))){

			if(!is_object($fieldvalue) ){
				$fieldvalue = ORM::Factory('file', $fieldvalue);
			}

			if($fieldvalue->_loaded){
				$fieldvalue = $fieldvalue->as_array();
			} else {
				$fieldvalue = null;
			}
		}

		//provide a unique id always
		$microtime = str_replace(array(' ', '.'), '', microtime());
		if(isset($element['name'])){
			//	$objectType->id =$element['name'].str_replace(array(' ', '.'), '', microtime());
			$id =$element['name'].latticeui::$unique++.$microtime;
		} else {
			$id ='name'.latticeui::$unique++.$microtime;
		}
		$element['id'] = $id;

		switch($element['type']){

			case 'image':
				$ext = substr(strrchr($fieldvalue['filename'], '.'), 1);
				switch($ext){
					case 'tif':
					case 'tiff':
					case 'TIF':
					case 'TIFF':
						$thumbSrc = 'uithumb_'.$fieldvalue['filename'].'_converted.jpg';
					break;
					default:
						$thumbSrc = 'uithumb_'.$fieldvalue['filename'];
					break;
				}

				$sitePath = '';
				
				if(Kohana::config('lattice.staging')){
					$sitePath = 'staging/';
				}
				if(file_exists($sitePath.'application/media/'.$thumbSrc)){
					$size = getimagesize($sitePath.'application/media/'.$thumbSrc);	
					$fieldvalue['width'] = $size[0];
					$fieldvalue['height'] = $size[1];
				} else {
					$fieldvalue['width'] = 0;
					$fieldvalue['height'] = 0;
				}
				$fieldvalue['thumbSrc']=$thumbSrc;
			
			case 'file':
				if(!isset($element['maxlength']) || !$element['maxlength']){
					$element['maxlength'] = 1523712; //12 MegaBytes 
				}
			break;

			case 'dateRange':
				if(!isset($element['empty'])){
					if(!isset($element['startDate']) || strlen($element['startDate'])==0){
						$element['startDate'] = date('Y/m/d');
					}
					if(!isset($element['endDate']) || strlen($element['endDate'])==0){
						$element['endDate'] = date('Y/m/d');
					}
				} else {
					$element['startDate'] = '';
					$element['endDate'] = '';
				}
			break;

      case 'date':
        $fieldvalue = explode(' ',$fieldvalue);
        $fieldvalue = $fieldvalue[0];
        $fieldvalue = date('m/d/Y', strtotime($fieldvalue));
        break;

			case 'radioGroup':
				$element['radioname'] = $id; 
			break;

			case 'multiSelect':
				if(isset($element['object'])){
					$object = Kohana::config('cms.objectTypes.'.$element['object']);
					$element['options'] = array();
					foreach($object as $field){
						if($field['type'] == 'checkbox'){
							$element['options'][$field['name']] = $field['label'];
						}
					}
				}	
				if($fieldvalue){
					$prepFieldValue = array();
					foreach($fieldvalue as $name => $selected){
						if($selected){
							$prepFieldValue[] = $name;
						}
					}
					$fieldvalue = $prepFieldValue;
				}
			break;
		}

		if(!isset($element['class'])){ $element['class'] = null; }

		if($paths = Kohana::find_file('views', $view)){
			$objectType = new View($view);
			$objectType->id = $id;
			$objectType->class = null;
			foreach($element as $key=>$value){
				$objectType->$key = $value;
			}
			$objectType->value = $fieldvalue;
			return $objectType->render();
		} else {
			throw new Kohana_Exception('bad ui element request'. ' view: '.$view.' not found');
			return false;
		}
	}

	public static function Input( $field, $class, $tag, $fieldValue, $label=null, $size=32 ){
		$elementArray = array( 'type'=>'input', 'name'=>$field, 'label'=>$label, 'class'=>$class, 'tag'=>$tag, "size"=>$size );
		return latticeui::buildUIElement( $elementArray, $fieldValue);
	}

	public static function text( $field, $class, $tag, $fieldValue, $label=null, $labelClass=null ){
		$elementArray = array( 'type'=>'text', 'name'=>$field, 'label'=>$label, 'class'=>$class, 'tag'=>$tag, "labelClass"=>$labelClass );
		return latticeui::buildUIElement( $elementArray, $fieldValue);
	}

	public static function password( $field, $class, $tag, $fieldValue, $label=null, $labelClass=null ){
		$elementArray = array( 'type'=>'password', 'name'=>$field, 'label'=>$label, 'class'=>$class, 'tag'=>$tag, "labelClass"=>$labelClass );
		return latticeui::buildUIElement( $elementArray, $fieldValue);		
	}

	public static function radioGroup( $field, $class, $radios, $fieldValue, $label=null, $labelClass=null ){
		$microtime = str_replace(array(' ', '.'), '', microtime());
		$name =$field.latticeui::$unique++.$microtime;
		$elementArray = array( 'type'=>'radioGroup', 'radioname'=>$name, 'class'=>$class, 'grouplabel'=>$label, 'name'=>$field, 'radios'=> $radios, "labelClass"=>$labelClass );
		return latticeui::buildUIElement( $elementArray, $fieldValue );
	}

	public static function checkbox( $field, $checkboxvalue, $value, $label){
		return latticeui::buildUIElement( array('type'=>'checkbox', 'name'=>$field, 'checkboxvalue'=>$checkboxvalue, 'label'=>$label, 'class'=>'checkbox'), $value);
	}

	public static function file($field, $extensions, $maxlength, $currentFile=null ){
		return latticeui::buildUIElement( array('type'=>'file', 'name'=>$field, 'extensions'=>$extensions, 'maxlength'=>$maxlength,  ), $currentFile );
	}

	public static function fieldmap($values, $options){
		return latticeui::buildUIElement(array('type'=>'fieldmap', 'values'=>$values, 'options'=>$options) );
	}

   // 0ak - revisit this function.  Needed?
	public static function pulldown ( $field, $class, $options, $fieldValue, $label=null, $labelClass=null ){
	  $elementArray = array( 'type'=>'pulldown',  'class'=>$class, 'label'=>$label, 'name'=>$field, 'options'=> $options, "labelClass"=>$labelClass );
	  return latticeui::buildUIElement( $elementArray, $fieldValue );
	}

   
   public static function tags($currentTags){
      $view = new View('ui_tags');
      $view->tags = $currentTags;
      return $view->render();

   
   }
}

