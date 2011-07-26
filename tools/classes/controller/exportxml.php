<?

class Controller_ExportXML extends Controller {

   public function __construct() {
      if (!is_writable('application/views/xmldumps/')) {
//	die('application/views/xmldumps/ must be writable');
      }
   }

   private function getObjectFields($object) {
      $nodes = array();
      $content = $object->getContent();
      foreach ($content as $key => $value) {
         if ($key == 'objectTypeName') {
            continue;
         }
         $node = $this->doc->createElement($key);
         if (is_array($value)) {
            
         } else if (is_object($value)) {
            switch (get_class($value)) {
               case 'Model_File':
                  //or copy to directory and just use filename
                  if ($value->fullpath) {
                     $node->appendChild($this->doc->createTextNode($value->fullpath));
                  }
                  break;
               case 'Model_Page':
                  foreach ($this->getObjectFields($value) as $subField) {
                     $node->appendChild($subField);
                  }
                  break;
            }
         } else {
            $node->appendChild($this->doc->createTextNode($value));
         }
         $nodes[] = $node;
      }
      return $nodes;
   }

   private function getObjectFieldsMOPFormat($object) {
      $nodes = array();
      $content = $object->getContent();
      foreach ($content as $key => $value) {
         if ($key == 'objectTypeName' || $key == 'dateadded') {
            continue;
         }
         if ($key == "slug" && $value = "") {
            continue;
         }
         $node = $this->doc->createElement('field');
         $nodeAttr = $this->doc->createAttribute('name');
         $nodeValue = $this->doc->createTextNode($key);
         $nodeAttr->appendChild($fieldValue);
         $node->appendChild($fieldAttr);
//print_r($value);
         if (is_array($value)) {
            
         } else if (is_object($value)) {
            switch (get_class($value)) {
               case 'File_Model':
//or copy to directory and just use filename
                  if ($value->fullpath) {
                     $node->appendChild($this->doc->createTextNode($value->fullpath));
                  }
                  break;
               case 'Page_Model':
                  foreach ($this->getObjectFields($value) as $subField) {
//$field->appendChild($subField);
                     echo "sub objects not yet supported for mop export\n";
                  }
                  break;
            }
         } else {
            $node->appendChild($this->doc->createTextNode($value));
         }
         $nodes[] = $node;
      }
      return $nodes;
   }

   private function exportTier($objects) {

      $nodes = array();
      foreach ($objects as $object) {
         $item = $this->doc->createElement($object->objecttype->objecttypename);

         foreach ($this->getObjectFields($object) as $field) {
            $item->appendChild($field);
         }

         //and get the children
         $childObjects = $object->getPublishedChildren();

         foreach ($this->exportTier($childObjects) as $childItem) {
            $item->appendChild($childItem);
         }
         $nodes[] = $item;
      }

      return $nodes;
   }

   private function exportTierMOPFormat($objects) {

      $nodes = array();
      foreach ($objects as $object) {
         $item = $this->doc->createElement('item');
         $objectTypeAttr = $this->doc->createAttribute('objectTypeName');
         $objectTypeValue = $this->doc->createTextNode($object->objecttype->objecttypename);
         $objectTypeAttr->appendChild($objectTypeValue);
         $item->appendChild($objectTypeAttr);

         foreach ($this->getObjectFieldsMOPFormat($object) as $field) {
            $item->appendChild($field);
         }

         //and get the children
         $childObjects = $object->getPublishedChildren();
         foreach ($this->exportTierMOPFormat($childObjects) as $childItem) {
            $item->appendChild($childItem);
         }
         $nodes[] = $item;
      }

      return $nodes;
   }

   //this should call action_export and then convert with xslt
   public function action_exportMOPFormat($xslt='') {

      $this->action_export();
      
      
      //do the export
      //and then call xslt to transform
      //export should build, but not write to file
      //enabling xslt to transform in memory xml, not load again from disk
      
      # LOAD XML FILE
$XML = new DOMDocument();
$XML->load( 'application/media/export.xml' );

# START XSLT
$xslt = new XSLTProcessor();

# IMPORT STYLESHEET 1
$XSL = new DOMDocument();
$XSL->load( 'objectType1.xsl' );
$xslt->importStylesheet( $XSL );

#IMPORT STYLESHEET 2
$XSL = new DOMDocument();
$XSL->load( 'objectType2.xsl' );
$xslt->importStylesheet( $XSL );

#PRINT
print $xslt->transformToXML( $XML ); 

return;      
      $this->doc = new DOMDocument('1.0', 'UTF-8');
      $this->doc->formatOutput = true;
      $data = $this->doc->createElement('data');

      $objects = $object->getPublishedChildren();


      foreach ($this->exportTierMOPFormat($objects) as $item) {
         $data->appendChild($item);
      }
      $this->doc->appendChild($data);


      $this->doc->save('application/media/export.xml');
   }

   public function action_export($xslt='') {

    //  $this->buildExportXml();
      
      $this->doc = new DOMDocument('1.0', 'UTF-8');
      $this->doc->formatOutput = true;
      $data = $this->doc->createElement('data');

      $object = Graph::getRootNode('cmsRootNode');
      $objects = $object->getPublishedChildren();


      foreach ($this->exportTier($objects) as $item) {
         $data->appendChild($item);
      }

      $this->doc->appendChild($data);
      $this->doc->save('application/media/export.xml');
   }

}
