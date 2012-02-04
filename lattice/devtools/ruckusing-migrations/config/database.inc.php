<?php

require('../../testindex.php');


//----------------------------
// DATABASE CONFIGURATION
//----------------------------
$ruckusing_db_config = array(
	
  'development' => array(
     'type'      => 'mysql',
     'host'      => 'localhost',
     'port'      => 3306,
     'database'  => Kohana::config('database.default.connection.database'),
     'user'      => Kohana::config('database.default.connection.username'),
     'password'   => Kohana::config('database.default.connection.password'),
  ),

	'test' 					=> array(
			'type' 			=> 'mysql',
			'host' 			=> 'localhost',
			'port'			=> 3306,
			'database' 	=> 'php_migrator_test',
			'user' 			=> 'root',
			'password' 	=> ''
	),
	'production' 		=> array(
			'type' 			=> 'mysql',
			'host' 			=> 'localhost',
			'port'			=> 0,
			'database' 	=> 'prod_php_migrator',
			'user' 			=> 'root',
			'password' 	=> ''
	)
	
);



?>
