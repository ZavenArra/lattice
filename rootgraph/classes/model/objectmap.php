<?

/*
 *
 * Class: Model for Objectmap
 *
 */

class Model_Objectmap extends ORM {

   public static function configureNewField($objectTypeId, $fieldName, $uiType) {
      $mapEntry = ORM::Factory('objectmap');
      $mapEntry->objecttype_id = $objectTypeId;
      $mapEntry->type = self::fieldTypeForUI($uiType);
      $mapEntry->column = $fieldName;
      $mapEntry->index = self::nextIndex($objectTypeId, $mapEntry->type);
      $mapEntry->save();
   }

   private static function nextIndex($objectTypeId, $fieldType) {
      
		$result = DB::select(array('index', 'maxIndex'))
              ->from('objectmaps')
              ->where('objecttype_id', '=', $objectTypeId)
              ->where('type', '=', $fieldType)
              ->order_by('index', 'DESC')
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
            $tConfigs = lattice::config('objects', '//objectType');
            $objectTypes = array();
            foreach ($tConfigs as $objectType) {
               $objectTypes[] = $objectType->getAttribute('name');
            }
            //print_r($objectTypes);
            if (in_array($uiType, $objectTypes)) {
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
