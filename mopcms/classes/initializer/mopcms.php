<?php

Class Initializer_MOPCms {

	public function initialize() {
		$problems = array();
		if(!is_writable('application/views/generated/')){
			$message = 'application/views/generated/ must be writable';
			$problems[$message]  =$message;
		}
		if(!is_writable('application/views/frontend/')){
			$message = 'application/views/frontend/ must be writable';
			$problems[$message]  =$message;
		}
		if(!is_writable('application/media/')){
			$message = 'application/views/media/ must be writable';
			$problems[$message]  =$message;
		}
		return $problems;

	}


}
