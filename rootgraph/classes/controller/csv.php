<?

Class Controller_CSV extends Controller {

	/*
	 * Function: createImportTemplateFilled($view)
	 * This function creates a csv import template which has data pre-filled from the table
	 */
	public function action_createImportTemplateFilled($exportParamterKey){
			//$data = mop::getViewContent($view);
         
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
					//	$label = mop::config('objects', 
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
}
