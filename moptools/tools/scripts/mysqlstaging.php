<?

require('../../../application/config/database.php');
$user = $config['staging']['connection']['user'];
$pass = $config['staging']['connection']['pass'];
$host = $config['staging']['connection']['host'];
$database = $config['staging']['connection']['database'];

$command = "/usr/bin/mysql";
$arguments[] = "-u$user";
//$arguments[] = "-p";
$arguments[] = "--password=$pass";
$arguments[] = "-h$host";
$arguments[] = "$database";
pcntl_exec($command, $arguments );
