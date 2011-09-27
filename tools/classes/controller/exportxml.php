<?

class Controller_ExportXML extends Controller {

   public $outputDir;

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
         if ($key == 'id') {
            continue;
         }
         $node = $this->doc->createElement($key);
         if (is_array($value)) {
            
         } else if (is_object($value)) {
            switch (get_class($value)) {
               case 'Model_File':
                  //or copy to directory and just use filename
                  if ($value->filename) {
                     $targetPath = $this->outputDir . $value->filename;
                     $node->appendChild($this->doc->createTextNode($targetPath));
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
         if ($key == "slug" && $value == "") {
            continue;
         }
         if ($key == "title" && $value == "") {
            $value = microtime();
         }
         if ($key == "id") {
            continue;
         }
         if (is_array($value)) {
            //skipping container objects.
            continue;
         }


         $node = $this->doc->createElement('field');
         $nodeAttr = $this->doc->createAttribute('name');
         $nodeValue = $this->doc->createTextNode($key);
         $nodeAttr->appendChild($nodeValue);
         $node->appendChild($nodeAttr);


         if (is_object($value)) {

            switch (get_class($value)) {
               case 'Model_File':
//or copy to directory and just use filename
                  if ($value->filename) {
                     $targetPath = $this->outputDir . $value->filename;
                     $node->appendChild($this->doc->createTextNode($targetPath));
                  }
                  break;
               case 'Model_Object':
                  foreach ($this->getObjectFields($value) as $subField) {
//$field->appendChild($subField);
                     echo "sub objects not yet supported for mop export\n";
                     echo $key;
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
         $childObjects = $object->getChildren();

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
         $childObjects = $object->getChildren();
         foreach ($this->exportTierMOPFormat($childObjects) as $childItem) {
            $item->appendChild($childItem);
         }
         $nodes[] = $item;
      }

      return $nodes;
   }

   //this should call action_export and then convert with xslt
   public function action_exportMOPFormat($outputfilename='export', $xslt='') {

      //     $this->action_export();
      //do the export
      //and then call xslt to transform
      //export should build, but not write to file
      //enabling xslt to transform in memory xml, not load again from disk
      # LOAD XML FILE
      $XML = new DOMDocument();
//$XML->load( 'application/media/export.xml' );

      /*
        # START XSLT
        $xslt = new XSLTProcessor();

        # IMPORT STYLESHEET 1
        $XSL = new DOMDocument();
        $XSL->load( 'template1.xsl' );
        $xslt->importStylesheet( $XSL );

        #IMPORT STYLESHEET 2
        $XSL = new DOMDocument();
        $XSL->load( 'template2.xsl' );
        $xslt->importStylesheet( $XSL );

        #PRINT
        print $xslt->transformToXML( $XML );

        return;
       */

      $this->doc = new DOMDocument('1.0', 'UTF-8');
      $this->doc->formatOutput = true;
      $data = $this->doc->createElement('data');

      $object = Graph::getRootNode('cmsRootNode');
      $objects = $object->getChildren();

      $this->outputDir = 'application/export/' . $outputfilename . '/';

      foreach ($this->exportTierMOPFormat($objects) as $item) {
         $data->appendChild($item);
      }
      $this->doc->appendChild($data);

      try {
         mkdir($this->outputDir, 777);
      } catch (Exception $e) {
         
      }
      echo getcwd() . '/' . $this->outputDir;
      flush();
      ob_flush();
      chmod(getcwd() . '/' . $this->outputDir, 0777);
      $this->doc->save($this->outputDir . '/' . $outputfilename . '.xml');
      system('cp -Rp application/media/* ' . $this->outputDir);
   }

   public function action_export($xslt='') {

      //  $this->buildExportXml();

      $this->doc = new DOMDocument('1.0', 'UTF-8');
      $this->doc->formatOutput = true;
      $data = $this->doc->createElement('data');

      $object = Graph::getRootNode('cmsRootNode');
      $objects = $object->getChildren();


      foreach ($this->exportTier($objects) as $item) {
         $data->appendChild($item);
      }

      $this->doc->appendChild($data);
      $this->doc->save('application/media/export.xml');
   }

}
