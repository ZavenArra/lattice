<?php

Class Csv_imports_Controller extends Controller {

	/*
	 * Function: create_import_template_filled($view)
	 * This function creates a csv import template which has data pre-filled from the table
	 */
	public function create_import_template_filled($view){
			$data = mop::get_view_content($view);

			$outputCSV = fopen('application/media/'.$view.'.csv', 'w');
			
			//print_r($data);
			//safely compute fields
			$columns = array();
			foreach($data['content']['csv'] as $item){
					foreach($item as $field => $value){
					//	$label = mop::config('objects', 
						$columns[$field] = $field;
					}	
			}
			fputcsv($outputCSV, $columns);

	//		print_r($columns);

			//output the file
			foreach($data['content']['csv'] as $item){
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

	}
}
