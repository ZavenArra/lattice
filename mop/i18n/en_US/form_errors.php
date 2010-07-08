<?
$lang = array
(
	// Change 'field' to the name of the actual field (e.g., 'email').
	'username' => array
	(
		'length' => 'Username must be between 3 and 20 characters.',
		'user_exists'    => 'This username already exists.',
		'required' => 'Username cannot be empty',
		'default'  => 'Invalid Input.',
	),

	'password' => array
	(
		'required' => 'Password cannot be empty',
		'length' => 'Password must be between 5 and 20 characters',
		'default' => 'Invalid Input',
	),

	'email' => array
	( 
		'valid::email'=>'Invalid email address',
		'email_exists'=>'This email is already is use within the system',
	),
);

