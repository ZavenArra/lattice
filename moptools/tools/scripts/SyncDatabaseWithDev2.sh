#!/bin/bash
echo "Preparing to sync database $1_$2 on this machine with dev2.winterroot.net"
echo "Dumping database $1_$2 on dev2.winterroot.net"
ssh dbsync@dev2.winterroot.net /var/scripts/dumpDatabase.sh $1 $2
echo "Transfering dump file to local server ..."
rsync -av dbsync@dev2.winterroot.net:/var/www/deepwinter/$1/modules/tools/scripts/database_$2.sql .
echo "Transfer Complete"
echo "Importing database to local Mysql server"
php mysqlImportDump.php $2
echo "Import Complete"
