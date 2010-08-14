<?php
/**
 * FORGE submit input library.
 *
 * $Id: Form_Submit.php 3326 2008-08-09 21:24:30Z Shadowhand $
 *
 * @package    Forge
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Form_Submit_Core extends Form_Input {

	protected $data = array
	(
		'type'  => 'submit',
		'class' => 'submit'
	);

	protected $protect = array('type');

	public function __construct($value)
	{
		$this->data['value'] = $value;
	}

	public function render()
	{
		$data = $this->data;
		unset($data['label']);

		return form::button($data);
	}

	public function validate()
	{
		// Submit buttons do not need to be validated
		return $this->is_valid = TRUE;
	}

} // End Form Submit