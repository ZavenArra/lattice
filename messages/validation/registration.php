<?

$errors = array(
  'password' => array(
    'not_empty' => 'Password cannot be empty',
    'min_length' => 'Password must be at least 8 characters long',
    'matches' => 'Password must match confirm password',
  ),
  'username' => array(
    'not_empty' => 'Username cannot be empty',
    'min_length' => 'Username must be at least 4 characters long',
  ),
	'email' => array(
    'not_empty' => 'Email must not be empty',
    'min_length' => 'Email must be at least 4 characters long',
    'email' => 'Email must be a valid email',
  ),
  'firstName' => array(
    'not_empty' => 'First name cannot be empty',
    'min_length' => 'First name must be at least 4 characters long',
  ),
  'lastName' => array(
    'not_empty' => 'Last name cannot be empty',
    'min_length' => 'Last name must be at least 4 characters long',
  ),
);

return $errors;
