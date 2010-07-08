<?php
/**
 * FORGE textarea input library.
 *
 * $Id: Form_Textarea.php 3326 2008-08-09 21:24:30Z Shadowhand $
 *
 * @package    Forge
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Form_Textarea_Core extends Form_Input {

	protected $data = array
	(
		'class' => 'textarea',
		'value' => '',
	);

	protected $protect = array('type');

	protected function html_element()
	{
		$data = $this->data;

		unset($data['label']);

		return form::textarea($data);
	}

} // End Form Textarea