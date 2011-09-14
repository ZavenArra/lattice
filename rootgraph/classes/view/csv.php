<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of csv
 *
 * @author deepwinter1
 */
class View_Csv  {
   
   private $_indent = 0;
   private $_object = 0;
   private $_objectTypeName = '';
   private $skipFields = array('slug', 'id', 'dateadded', 'objecttypename');
   
   public function __construct($indent, $object){
       $this->_indent = $indent;
       $this->_object = $object;
       $this->_objectTypeName = $object->objecttype->objecttypename;
   }
   
   public function render(){
      
      $objectTypeLine = array_pad(array($this->_objectTypeName), -1 - $this->_indent, '');
      $csv = latticeutil::arrayToCsv($objectTypeLine, ',');
      $csv .= "\n";
      
      foreach ($this->_object->getFields() as $columnName) {
         if(in_array($columnName, $this->skipFields)){
            continue;
         }         
        // echo 'c'.$columnName;
         $dataItem = $this->_object->$columnName;

         if (is_object($dataItem)) {

            //        if (is_subclass_of($dataItem, 'Model_File')) {
            // This is a special case, once Files are compound objects only
            // they will be subclass of Model_Object, and filename will be only
            // a text field, with file linked to object via  objectelementsrelationships.
            if (get_class($dataItem) == 'Model_File') {
               $dataItem = $dataItem->filename;
            } else {

               $objectTypeLine = array_pad(array($dataItem->objecttypename), -1 - $this->_indent, '');
               
               $csv .= latticeutil::arrayToCsv($objectTypeLine, ',');
               $csv .= "\n";

               $csvView = new View_Csv($this->_indent+1, $dataItem);
               $csv .= $csvView->render();
               continue;
            }

         } //else {

            $dataItemLine = array_pad(array($columnName, $dataItem), - 2 - $this->_indent - 1, '' );
            $csv .= latticeutil::arrayToCsv($dataItemLine, ',');
            $csv .= "\n";
            
            
            //And now append one example object of each addable object
            foreach($this->_object->objecttype->addableObjects as $addableObjectType){
               $object = Graph::object();
               $object->objecttype = ORM::Factory('objecttype')
                       ->where('objecttypename','=',$addableObjectType['objectTypeId'])
                       ->find();
               if(!$object->objecttype->loaded()){
                  
                  echo $addableObjectType['objectTypeId'];
                  echo 'objecttypes must get forced to self configure if we are going to allow empty objects';
               }
           
               $objectTypeLine = array_pad(array($addableObjectType['objectTypeId'].'HEY!'), -1 - $this->_indent -1, '');
               
               $csv .= latticeutil::arrayToCsv($objectTypeLine, ',');
               $csv .= "\n";
/*
               $csvView = new View_Csv($this->_indent+1, $object);
               $csv .= $csvView->render();
               */
            }
         //}
      }

      return $csv;
   }
   
}

?>
