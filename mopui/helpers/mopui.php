<?

/*
 * Class: mopui
 * Helper class which generates all the mopui form elements
 * Functions in this class need to be stardardized and have their parameters cleaned up
 */

Class mopui{

	private static $unique = 1;

	/*
	 * Function: buildUIElement
	 * Builds a UI element from the mopui views directory
	 * $element -  array of key value pairs passed to the template, including 'type' key which indicates the template to use
	 * $fieldvalue - the value to display
	 * Example: buildUIElement(array('type'=>'ipe', 'field'=>'fieldname', 'class'=>'className'), {Value})
	 */
	public static function buildUIElement($element, $fieldvalue=null){
		$view = 'ui_'.$element['type'];

		//allow files to be passed either by id or as already quireid objects
		if( in_array($element['type'], array('singlefile', 'singleImage'))){

			if(!is_object($fieldvalue) ){
				$fieldvalue = ORM::Factory('file')->where('id', $fieldvalue)->find(); //why is where necessary???
			}

			if($fieldvalue->loaded){
				$fieldvalue = $fieldvalue->as_array();
			} else {
				$fieldvalue = null;
			}
		}

		//provide a unique id always
		$microtime = str_replace(array(' ', '.'), '', microtime());
		if(isset($element['field'])){
			//	$template->id =$element['field'].str_replace(array(' ', '.'), '', microtime());
			$id =$element['field'].mopui::$unique++.$microtime;
		} else {
			$id ='field'.mopui::$unique++.$microtime;
		}


		switch($element['type']){

		case 'singleImage':
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
			if(Kohana::config('mop.staging')){
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
		case 'singlefile':
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
	 
		case 'radioGroup':
			$element['radioname'] = $id; 
			break;

		case 'multiSelect':
			if(isset($element['object'])){
				$object = Kohana::config('cms.modules.'.$element['object']);
				$element['options'] = array();
				foreach($object as $field){
					if($field['type'] == 'checkbox'){
						$element['options'][$field['field']] = $field['label'];
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

		if(!isset($element['class'])){
			$element['class'] = null;
		}

		if(Kohana::find_file('views', $view)){
			$template = new View($view);

			$template->id = $id;
		
			$template->class = null;

			foreach($element as $key=>$value){
				$template->$key = $value;
			}
			$template->value = $fieldvalue;
			return $template->render();
		} else {
			throw new Kohana_User_Exception('bad ui element request', 'view: '.$view.' not found');
			return false;
		}
	}

	public static function Input( $field, $class, $tag, $fieldValue, $label=null, $size=32 ){
		$elementArray = array( 'type'=>'input', 'field'=>$field, 'label'=>$label, 'class'=>$class, 'tag'=>$tag, "size"=>$size );
		return mopui::buildUIElement( $elementArray, $fieldValue);
	}

	public static function IPE( $field, $class, $tag, $fieldValue, $label=null, $labelClass=null ){
		$elementArray = array( 'type'=>'ipe', 'field'=>$field, 'label'=>$label, 'class'=>$class, 'tag'=>$tag, "labelClass"=>$labelClass );
		return mopui::buildUIElement( $elementArray, $fieldValue);
	}

	public static function radioGroup( $field, $class, $radios, $fieldValue, $groupLabel=null, $labelClass=null ){
	//	$name = $field.mopui::$unique; //why didn't this work ?
	//	mopui::$unique++;
		$microtime = str_replace(array(' ', '.'), '', microtime());
		$name =$field.mopui::$unique++.$microtime;
		$elementArray = array( 'type'=>'radioGroup', 'radioname'=>$name, 'class'=>$class, 'grouplabel'=>$groupLabel, 'field'=>$field, 'radios'=> $radios, "labelClass"=>$labelClass );
		return mopui::buildUIElement( $elementArray, $fieldValue );
	}

	public static function checkbox( $field, $checkboxvalue, $value, $label){
		return mopui::buildUIElement( array('type'=>'checkbox', 'field'=>$field, 'checkboxvalue'=>$checkboxvalue, 'label'=>$label, 'class'=>'checkbox'), $value);
	}

	public static function singleFile($field, $extensions, $maxlength, $currentFile=null ){
		return mopui::buildUIElement( array('type'=>'singlefile', 'field'=>$field, 'extensions'=>$extensions, 'maxlength'=>$maxlength,  ), $currentFile );
	}

	public static function fieldmap($values, $options){
		return mopui::buildUIElement(array('type'=>'fieldmap', 'values'=>$values, 'options'=>$options) );
	}
}

