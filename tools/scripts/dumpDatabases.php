<?

require('../../../application/config/database.php');
$user = $config['default']['connection']['user'];
$pass = $config['default']['connection']['pass'];
$host = $config['default']['connection']['host'];
$database = $config['default']['connection']['database'];

$database = explode('_', $database);
$database = $database[0];

$command = "mysqldump -u $user --password=$pass -h $host {$database}_dev > database_dev.sql";
system($command);
$command = "mysqldump -u $user --password=$pass -h $host {$database}_test > database_test.sql";
system($command);
$command = "mysqldump -u $user --password=$pass -h $host --add-drop-database --databases {$database}_testbed > database_testbed.sql";
system($command);
