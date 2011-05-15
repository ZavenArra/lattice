<?php
/*
 * Class: Database (MY_Database)
 * A Default override to the normal Kohana Database class
 */
class Database extends Database_Core {

	/**
	 * Transaction status variable
	 *
	 * @var in_transaction
	 */
	protected $in_transaction = false;

	public function __destruct()
	{
		self::trans_rollback();
	}

	/**
	 * Status of transaction
	 *
	 * @return  void
	 */
	public function trans_status()
	{
		return $this->in_transaction;
	}

	/**
	 * Start a transaction
	 *
	 * @return  void
	 */
	public function trans_start()
	{
		if ($this->in_transaction === false) {
			$this->query('SET AUTOCOMMIT=0');
			$this->query('BEGIN');
		}
		$this->in_transaction = true;
	}

	/**
	 * Finish the transaction
	 *
	 * @return  void
	 */
	public function trans_complete()
	{
		if ($this->in_transaction === true) {
			$this->query('COMMIT');
			$this->query('SET AUTOCOMMIT=1');
		}
		$this->in_transaction = false;
	}

	/**
	 * Undo the transaction
	 *
	 * @return  void
	 */
	public function trans_rollback()
	{
		if ($this->in_transaction === true) {
			$this->query('ROLLBACK');
			$this->query('SET AUTOCOMMIT=1');
		}
		$this->in_transaction = false;
	}


	public function emptySelect(){
		$this->select = array();
	}

	/**
	 * Selects the or like(s) for a database query.
	 *
	 * @param   string|array  field name or array of field => match pairs
	 * @param   string        like value to match with field
	 * @param   boolean       automatically add starting and ending wildcards
	 * @return  Database_Core        This Database object.
	 */
	public function distinctorlike($field, $match = '', $auto = TRUE)
	{
		$fields = is_array($field) ? $field : array($field => $match);

		$where = '';
		$i=0;
		$type = '';
		foreach ($fields as $field => $match)
		{
			$field         = (strpos($field, '.') !== FALSE) ? $this->config['table_prefix'].$field : $field;
			if($i){
				$type = ' OR ';
			}
			$where  .= $this->driver->like($field, $match, $auto, $type, count($this->where)+$i);
			$i++;
		}
		count($this->where) ? $and = 'AND' : $and = '';
		$this->where[] = $and . ' ('.$where.')';

		return $this;
	}

	public function distinctorwhere($field, $value = '', $quote = TRUE)
	{
		$fields = is_array($field) ? $field : array($field => $vaule);

		$where = '';
		$i=0;
		$type = '';
		foreach ($fields as $field => $value)
		{
			$field         = (strpos($field, '.') !== FALSE) ? $this->config['table_prefix'].$field : $field;
			if($i){
				$type = ' OR ';
			}
			$where  .= $this->driver->where($field, $value, $type, count($this->where)+$i, $quote);
			$i++;
		}
		count($this->where) ? $and = 'AND' : $and = '';
		$this->where[] = $and . ' ('.$where.')';

		return $this;
	}

	public function distinctorwhereAllowsSameField($fields, $values, $quote = TRUE)
	{

		$where = '';
		$i=0;
		$type = '';
		foreach ($fields as $index => $field)
		{
			$value = $values[$index];
			$field         = (strpos($field, '.') !== FALSE) ? $this->config['table_prefix'].$field : $field;
			if($i){
				$type = ' OR ';
			}
			$where  .= $this->driver->where($field, $value, $type, count($this->where)+$i, $quote);
			$i++;
		}
		count($this->where) ? $and = 'AND' : $and = '';
		$this->where[] = $and . ' ('.$where.')';

		return $this;
	}


	public function query($sql=''){
	//	Kohana::log('info', $sql);
		return parent::query($sql);
	}
}
?>
