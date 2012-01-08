<?
/*
 * Override for Kohana_Exception that provides a function generating a message
 * that is better formatted for sending as an error in json, for readability in firebug 
 * following an ajax request.
 */
Class Kohana_Exception extends Kohana_Kohana_Exception {


	public function getOneLineErrorReport(){
			$message = $this->getMessage();
			foreach( $this->getTrace() as $trace){
				if(isset($trace['file'])){
					$message .= " :::::\n ".$trace['file'].':'.$trace['line']."\n;";
				}
			}
			return $message;
	}
}
