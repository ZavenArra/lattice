<?

require('../../../application/config/database.php');
$user = $config['default']['connection']['user'];
$pass = $config['default']['connection']['pass'];
$host = $config['default']['connection']['host'];
$database = $config['default']['connection']['database'];

$command = "/usr/bin/mysql";
$arguments[] = "-u$user";
//$arguments[] = "-p";
$arguments[] = "--password=$pass";
$arguments[] = "-h$host";
$arguments[] = "$database";
pcntl_exec($command, $arguments );
