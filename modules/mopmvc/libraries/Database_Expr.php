<?
/*
 * Class: Database_Expr
 * Helpfull class to allow using database expressions
 * Call constructor with expression and use to set values, such as NULL or NOW()
 */
class Database_Expr
{
	private $_value = NULL;

	public function __construct($value)
	{
		$this->_value = $value;
	}

	public function __toString()
	{
		return $this->_value;
	}
}

