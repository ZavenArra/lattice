<?

require('../../../application/config/database.php');
$user = $config['default']['connection']['user'];
$pass = $config['default']['connection']['pass'];
$host = $config['default']['connection']['host'];
$database = $config['default']['connection']['database'];

$database = explode('_', $database);
$database = $database[0].'_testbed';

$command = "/usr/bin/mysql";
$arguments[] = "-u$user";
//$arguments[] = "-p";
$arguments[] = "--password=$pass";
$arguments[] = "-h$host";
$arguments[] = "$database";
$arguments[] = "< database_testbed.sql";
echo "/usr/bin/mysql -u$user --password=$pass -h$host $database < database_testbed.sql";
system("/usr/bin/mysql -u$user --password=$pass -h$host $database < database_testbed.sql");
//pcntl_exec($command, $arguments );
