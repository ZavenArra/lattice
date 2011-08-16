<?php

Class Initializer_LatticeCms {

	public function initialize() {
		$problems = array();
		if(!is_writable('application/media/')){
			$message = 'application/media/ must be writable';
			$problems[$message]  =$message;
		}      
      
		return $problems;

	}


}
