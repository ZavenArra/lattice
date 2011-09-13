<?

Class Controller_CSV extends Controller {

   private $csvOutput = '';
   private $level = 0;
   
   public function action_index(){
         $view = new View('csv/index');
        $this->response->body($view->render());
   }
   
   public function action_export($exportFileIdentifier='latticeCsvExport'){
      $this->csvOutput = '';
      
      $rootObject = Graph::getLatticeRoot();
      
      
      $this->level = 0;
      
      $this->csvWalkTree($rootObject);
     
   //   echo 'done';
      $file = fopen('application/export/'.$exportFileIdentifier.'.csv', 'w');
      fwrite($file, $this->csvOutput);
      fclose($file);
   }
   
   private function csvWalkTree($parent){
      $objects = $parent->getLatticeChildren();
      foreach($objects as $object){
         $csvView = new View_CSV($this->level, $object);

         $this->csvOutput .= $csvView->render();
         $this->level++;
         $this->csvWalkTree($object);
         $this->level--;
      }
   
   }
   
	/*
	 * Function: createImportTemplateFilled($view)
	 * This function creates a csv import objectType which has data pre-filled from the table
	 */
	public function action_createImportTemplateFilled($exportParamterKey){
			//$data = lattice::getViewContent($view);
         
         $query = new Graph_ObjectQuery();
         $query->initWithArray(Kohana::config('csv.parameters.'.$exportParamterKey));

         $data = $query->run();

         //print_r($data);
         //$dataQueryResults = new Graph_ObjectQuery_Xml($dataQueryParameters)->run();

         
			$outputCSV = fopen('application/media/'.$exportParamterKey.'.csv', 'w');
			
			//print_r($data);
			//safely compute fields
			$columns = array();
			foreach($data as $item){
					foreach($item as $field => $value){
                  $columns[$field] = $field;
					}	
			}
			fputcsv($outputCSV, $columns);


			//output the file
			foreach($data as $item){
				$output = array();
				foreach($columns as $column => $label){
					if(isset($item[$column])){
						$output[] = $item[$column];
					} else {
						$output[] = '';
					}
				}
	//			print_r($output);
				fputcsv($outputCSV, $output);
			}

			fclose($outputCSV);
         echo 'Exported to application/media/'.$exportParamterKey.'.csv';
	}
   
   public function action_importUploadForm(){
       $view = new View('csv/uploadform');
       $this->response->body($view->render());
   }
   
   public function action_importCSVFile(){
      $csvFile = fopen($_FILES['upload']['tmp_name'], 'r');
      $columns = fgetcsv($csvFile); //skip 
      $columns = array_flip($columns);
      if(!isset($columns['id'])){
         throw new Kohana_Exception("CSV File must have ID column");
      }
      while($csvRow = fgetcsv($csvFile)){
         $id = $csvRow[$columns['id']];
         $object = Graph::object($id);
         foreach($columns as $column => $index){
            if($column == 'id' || $column == 'dateAdded' || $column == 'objectTypeName' ){
               continue;
            } 
            $object->$column = $csvRow[$index];
            //the update array should be passed to the object, not hanlded here
//            $object->contentTable->$column = $csvRow[$index];
         }
         $object->save();
      }
      echo 'Done';
   }
}
