<?

require('../../../application/config/database.php');
$user = $config['default']['connection']['user'];
$pass = $config['default']['connection']['pass'];
$host = $config['default']['connection']['host'];
$database = $config['default']['connection']['database'];

$database = explode('_', $database);
$database = $database[0];

$command = "mysqldump -u $user --password=$pass -h $host {$database}_{$argv[1]} > database_{$argv[1]}.sql";
system($command);
