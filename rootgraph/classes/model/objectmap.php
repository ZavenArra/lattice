<?

/*
 *
 * Class: Model for Objectmap
 *
 */

class Model_Objectmap extends ORM {

   public static function configureNewField($templateId, $fieldName, $uiType) {
      $mapEntry = ORM::Factory('objectmap');
      $mapEntry->template_id = $templateId;
      $mapEntry->type = self::fieldTypeForUI($uiType);
      $mapEntry->column = $fieldName;
      $mapEntry->index = self::nextIndex($templateId, $mapEntry->type);
      $mapEntry->save();
   }

   private static function nextIndex($templateId, $fieldType) {
      
		$result = DB::select(array('index', 'maxIndex'))
              ->from('objectmaps')
              ->where('template_id', '=', $templateId)
              ->where('column', '=', $fieldType)
              ->order_by('index')
              ->limit(1, 0)
              ->execute()
              ->current();
      return $result['maxIndex'] + 1;
   }

   public static function fieldTypeForUI($uiType) {
      $index = null;
      switch ($uiType) {
         case 'text':
         case 'radioGroup':
         case 'pulldown':
         case 'time':
         case 'date':
         case 'multiSelect':
            $index = 'field';
            break;
         case 'image':
         case 'file':
            $index = 'file';
            break;
         case 'checkbox':
            $index = 'flag';
            break;
         default:
            $tConfigs = mop::config('objects', '//template');
            $templates = array();
            foreach ($tConfigs as $template) {
               $templates[] = $template->getAttribute('name');
            }
            //print_r($templates);
            if (in_array($uiType, $templates)) {
               $index = 'object';
            } else {
               return null;
            }
            break;
      }
      return $index;
   }

}

?>
