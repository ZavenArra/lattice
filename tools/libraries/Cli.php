<?

Class CLI {

	public function exception_handler($e, $estr){
		die("\nDEAD EXCEPTION: ".$estr."\n\n");
	}

	public function error_handler($e , $estr, $eFile, $eLine){
		die("\nDEAD: ".$estr.' '.$eFile.' '.$eLine."\n\n");
	}
}
