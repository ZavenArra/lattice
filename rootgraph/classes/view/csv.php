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
      $elementsLine = array_pad(array('Elements'), -1 - ($this->_indent + 1), '');
      $csv .= latticeutil::arrayToCsv($elementsLine, ',');
      $csv .= "\n";
      
      foreach ($this->_object->getFields() as $columnName) {
         if(in_array($columnName, $this->skipFields)){
            continue;
         }         
         
         if($this->_object->loaded()){
            $dataItem = $this->_object->$columnName;
         } else {
            $dataItem = null;  //this allow for objects to be used as empty templates 
                               //without being tied to database
                               //potential refactor here, separating ideas of objecttype and object
                               //a bit more
         }
   

         if (is_object($dataItem)) {
            
                  
       
         

            //        if (is_subclass_of($dataItem, 'Model_File')) {
            // This is a special case, once Files are compound objects only
            // they will be subclass of Model_Object, and filename will be only
            // a text field, with file linked to object via  objectelementsrelationships.
            if (get_class($dataItem) == 'Model_File') {
               $dataItem = $dataItem->filename;
               $dataItemLine = array_pad(array($columnName, $dataItem), - 2 - $this->_indent - 1, '' );
               $csv .= latticeutil::arrayToCsv($dataItemLine, ',');
               $csv .= "\n";
               
            } else {
 
               //skip if it's a container
               if ($dataItem->objecttype->nodeType == 'container') {
                  continue;
               }
               
               $csvView = new View_Csv($this->_indent+1, $dataItem);
               $csv .= $csvView->render();
               $csv .= "\n";
            }

         } else { 
            
            if(is_array($dataItem)){
             $dataItem = implode($dataItem, ',');  
            }

            
            $dataItemLine = array_pad(array($columnName, $dataItem), - 2 - $this->_indent - 1, '' );
            $csv .= latticeutil::arrayToCsv($dataItemLine, ',');
            $csv .= "\n";
         }
            
      
      }

      return $csv;
   }
   
}

?>
