<?

Class Lattice_Lattice_APIException extends Exception {

	public function __construct($message, array $variables = NULL, $code = 0) {

		parent::__construct($message, (int) $code);
	}

	public function getOneLineErrorReport(){
		return $this->message();
	}

}
