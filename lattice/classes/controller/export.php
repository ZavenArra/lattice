<?

class Controller_Export extends Controller {

   public $outputDir;

   public function __construct() {
      if (!is_writable('application/views/xmldumps/')) {
//	die('application/views/xmldumps/ must be writable');
      }
   }
//all this logic should be moved to the export MODEL
   private function getObjectFields($object) {
      $nodes = array();
      $content = $object->getContent();
      foreach ($content as $key => $value) {
         if ($key == 'objectTypeName') {
            continue;
         }
         if ($key == 'id') {
            //continue;
         }
         $node = $this->doc->createElement($key);
         if (is_array($value)) {
            
         } else if (is_object($value)) {
            switch (get_class($value)) {
               case 'Model_File':
                  //or copy to directory and just use filename
                  if ($value->filename) {
										$targetPath = $this->outputDir . $value->filename;
										if(file_exists($targetPath)){
											$node->appendChild($this->doc->createTextNode($targetPath));
										}
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

   private function getObjectFieldsLatticeFormat($object) {
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
            //$value = microtime();
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
										 if(file_exists($targetPath)){
											 $node->appendChild($this->doc->createTextNode($targetPath));
										 }
                  }
                  break;
               case 'Model_Object':
                  foreach ($this->getObjectFieldsLatticeFormat($value) as $subElement) {
										$node->appendChild($subElement);
                  }
                  break;
            }
         } else {

            $node->appendChild($this->doc->createTextNode($value));
         }
         $nodes[] = $node;
			}
      $node = $this->doc->createElement('field');
      $nodeAttr = $this->doc->createAttribute('name');
      $nodeValue = $this->doc->createTextNode('published');
      $nodeAttr->appendChild($nodeValue);
      $node->appendChild($nodeAttr);
      $node->appendChild($this->doc->createTextNode($object->published));
			$nodes[] = $node;
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

   private function exportTierLatticeFormat($objects) {

      $nodes = array();
      foreach ($objects as $object) {
         $item = $this->doc->createElement('item');
         $objectTypeAttr = $this->doc->createAttribute('objectTypeName');
         $objectTypeValue = $this->doc->createTextNode($object->objecttype->objecttypename);
         $objectTypeAttr->appendChild($objectTypeValue);
         $item->appendChild($objectTypeAttr);

         foreach ($this->getObjectFieldsLatticeFormat($object) as $field) {
            $item->appendChild($field);
         }

         //and get the children
         $childObjects = $object->getChildren();
         foreach ($this->exportTierLatticeFormat($childObjects) as $childItem) {
            $item->appendChild($childItem);
         }
         $nodes[] = $item;
      }

      return $nodes;
   }

   //this should call action_export and then convert with xslt
   public function action_lattice($outputfilename='export') {

     $this->export('LatticeFormat', $outputfilename);

   } 

   public function action_xml($outputfilename='export') {

     $this->export('XMLFormat', $outputfilename);

   } 

   public function export($format, $outputfilename){

		 $this->outputDir = 'application/export/' . $outputfilename . '/';

		 try {
		 mkdir($this->outputDir, 777);
		 } catch ( Exception $e){

		 }
		 chmod(getcwd() . '/' . $this->outputDir, 0777);
		 system('cp -Rp application/media/* ' . $this->outputDir);

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
/*
      $this->doc = new DOMDocument('1.0', 'UTF-8');
      $this->doc->formatOutput = true;
      $data = $this->doc->createElement('data');
  */    
      //
      $implementation = new DOMImplementation();
      $dtd = $implementation->createDocumentType('data',
        '-//WINTERROOT//DTD Data//EN',
        '../../../lattice/lattice/xml/data.dtd');
      $this->doc = $implementation->createDocument('', '', $dtd);
   
      $this->doc->xmlVersion="1.0";
      $this->doc->encoding="UTF-8";
      $this->doc->formatOutput = true;
    
      $data = $this->doc->createElement('data');

      $object = Graph::getRootNode('cmsRootNode');
      $objects = $object->getChildren();

      $exportFunction = NULL;
      switch($format){
      case 'LatticeFormat':
        $exportFunction = 'exportTierLatticeFormat';
        break;
      case 'XMLFormat':
        $exportFunction = 'exportTier';
         break;
      }

      foreach ($this->$exportFunction($objects) as $item) {
         $data->appendChild($item);
      }
      $this->doc->appendChild($data);

           echo getcwd() . '/' . $this->outputDir;
      flush();
      ob_flush();
      $this->doc->save($this->outputDir . '/' . $outputfilename . '.xml');
      echo 'done';
   }

}
