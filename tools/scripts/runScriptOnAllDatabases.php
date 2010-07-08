<?

require('../../../application/config/database.php');
$user = $config['default']['connection']['user'];
$pass = $config['default']['connection']['pass'];
$host = $config['default']['connection']['host'];
$database = $config['default']['connection']['database'];

$database = explode('_', $database);
$database = $database[0];


echo "Running {$argv[1]} on {$database}_dev \n";
$command = "mysql -u $user --password=$pass -h $host {$database}_dev < {$argv[1]}";
system($command);

echo "Running {$argv[1]} on {$database}_schema_dev \n";
$command = "mysql -u $user --password=$pass -h $host {$database}_schema_dev < {$argv[1]} ";
system($command);

echo "Running {$argv[1]} on {$database}_test \n";
$command = "mysql -u $user --password=$pass -h $host {$database}_test < {$argv[1]} ";
system($command);

echo "Running {$argv[1]} on {$database}_testbed \n";
$command = "mysql -u $user --password=$pass -h $host {$database}_testbed < {$argv[1]}";
system($command);

echo "Running {$argv[1]} on {$database}_schema_production \n";
$command = "mysql -u $user --password=$pass -h $host {$database}_schema_production < {$argv[1]} ";
system($command);
