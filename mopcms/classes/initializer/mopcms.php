<?php

Class Initializer_MOPCms {

	public function initialize() {
		$problems = array();
		if(!is_writable('application/media/')){
			$message = 'application/media/ must be writable';
			$problems[$message]  =$message;
		}      
      
		return $problems;

	}


}
