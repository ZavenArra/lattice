<?

Class Controller_CSV extends Controller {

   private $csvOutput = '';
   private $level = 0;

	 public function __construct($request, $response){
		 parent::__construct($request, $response);
		 if(!latticeutil::checkRoleAccess('superuser')){
			 die('Only superuser can access builder tool');
		 }
	 }
   
   public function action_index(){
         $view = new View('csv/index');
        $this->response->body($view->render());
   }
   
   public function action_export($exportFileIdentifier='latticeCsvExport'){
      $this->csvOutput = '';
      
      $rootObject = Graph::getLatticeRoot();
      
      
      $this->level = 0;
      
      $this->csvWalkTree($rootObject);

			$filename = $exportFileIdentifier .'.csv';
			$filepath = 'application/export/'.$filename;
			$file = fopen($filepath, 'w');
			fwrite($file, $this->csvOutput);
    // exit;
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Content-Type: csv");
			header("Content-Disposition: attachment; filename=\"".$filename."\";");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".@filesize($filepath));
			set_time_limit(0);
			@readfile($filepath) or die("File not found.");	
			exit;
   }
   
   private function csvWalkTree($parent, $example = false){
      $objects = $parent->getLatticeChildren();
      
      if ($example || ($this->level > 0 && count($objects))) {
         $childrenLine = array_pad(array('Children'), -1 - $this->level, '');
         $this->csvOutput .= latticeutil::arrayToCsv($childrenLine, ',');
         $this->csvOutput .= "\n";
      }

      foreach($objects as $object){
         
				$csvView = NULL;
				if($object->objecttype->nodeType != 'container'){
					$csvView = new View_CSV($this->level, $object);
				} else {
					$csvView = new View_CSVContainer($this->level, $object);
				}
				$this->csvOutput .= $csvView->render();
				$this->level++;
				$this->csvWalkTree($object, false);  //false turning off example for now
																						 //big problem with walking descedent objects since they don't exist

				if($example){
					//And now append one example object of each addable object
					foreach ($object->objecttype->addableObjects as $addableObjectType) {
						$object = Graph::object()->setObjectType($addableObjectType['objectTypeId']);


						$csvView = new View_Csv($this->level, $object);
						$this->csvOutput .= $csvView->render();


					}
				}
				$this->level--;
      }
   
   }
   
   public function action_import(){
       $view = new View('csv/uploadform');
       $this->response->body($view->render());
   }
   
   public function action_importCSVFile(){
      $this->csvFile = fopen($_FILES['upload']['tmp_name'], 'r');
			$this->column = 0;

			$this->walkCSVObjects(Graph::getLatticeRoot());
			
			fclose($this->csvFile);
      echo 'Done';
   }

	 protected function walkCSVObjects($parent){
		 $this->advance();
		 while($this->line){
			 $objectTypeName = $this->line[$this->column];
			 if(!$objectTypeName){
				 throw new Kohana_Exception("Expecting objectType at column :column, but none found :line",
					 array(
						 ':column'=>$this->column,
						 ':line'=>implode(',',$this->line)
				 )); 
			 }

			 //check if this object type is valid for the current objects.xml
			 $objectConfig = lattice::config('objects', sprintf('//objectType[@name="%s"]', $objectTypeName));
			 if(!$objectConfig->item(0)){
				 throw new Kohana_Exception("No object type configured in objects.xml for ".$objectTypeName);	
			 }

			 //we have an objectType
			 $newObjectId = $parent->addObject($objectTypeName);
			 $newObject = Graph::object($newObjectId);
			 $this->walkCSVElements($newObject);

		 }
	 }

	 protected function walkCSVElements($object){
		 echo "Walking\n";

		 if($object->objecttype->nodeType != 'container'){ 
			 //get the elements line
			 $this->advance();
			 //check here for Elements in $this->column +1;
			 if($this->line[$this->column+1] != 'Elements'){
				 throw new Kohana_Exception("Didn't find expected Elements line");
			 }
		 }


		 //iterate through any elements
		 $this->advance();	
		 $data = array();
		 while(isset($this->line[$this->column]) 
			 && $this->line[$this->column]=='' 
			 && $this->line[$this->column+1]!='' 
			 && $this->line[$this->column+1]!='Children'){
			 $fieldName = $this->line[$this->column+1];	
			 echo "Reading $fieldName \n";
			 if(isset($this->line[$this->column+2])){
				 $value = $this->line[$this->column+2];
			 } else {
				$value = null;
			 }
			 $field = strtok($fieldName, '_');
			 $lang = strtok('_');
			 if(!isset($data[$lang])){
				 $data[$lang] = array();
			 }
			 $data[$lang][$field] = $value;

			 $this->advance();
		 }


		 //and actually add the data to the objects
		 foreach($data as $lang=>$langData){
				$objectToUpdate = $object->getTranslatedObject(Graph::language($lang));
				foreach($langData as $field => $value){
					$objectToUpdate->$field = $value;
				}
				$objectToUpdate->save();
		 }

		 //Check here for Children in $this->column +1
		 if(!isset($this->line[$this->column+1]) || $this->line[$this->column+1] != 'Children'){
			 echo "No children found, returning from Walk ";//.implode(',', $this->line)."\n";
			 return;
		 }

		 //Iterate through any children
		 $this->advance();
		 while(isset($this->line[$this->column]) 
			 && $this->line[$this->column]=='' 
			 && $this->line[$this->column+1]!=''){
			 echo "foudn Child\n";
			 echo $this->column;
			 $childObjectTypeName = $this->line[$this->column+1];	
			 $childObjectId = $object->addObject($childObjectTypeName);
			 $childObject = Graph::object($childObjectId);
			 $this->column++;
			 echo $this->column;
			 $this->walkCSVElements($childObject);
			 $this->column--;
		 }

		 echo "Returning from Walk\n";
		 //at this point this->line contains the next object to add at this depth level
	 }

	 protected function advance(){
		 $this->line = fgetcsv($this->csvFile);
	 }

}
