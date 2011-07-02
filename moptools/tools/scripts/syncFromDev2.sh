#!/bin/bash
#cd $1
#git push
#rsync -r thiago@dev2.winterroot.net:dev/thiago/$1 .
ssh thiago@dev2.winterroot.net "echo dev/thiago/$1/modules/tools/scripts/; cd /home/deepwinter/dev/thiago/$1/modules/tools/scripts/; pwd; php dumpDatabase.php dev"
rsync -r thiago@dev2.winterroot.net:dev/thiago/$1/modules/tools/scripts/database_dev.sql .
echo 'CREATE DATABASE '$1'_dev; ' | ./mysql -u root --password=root -h localhost -P 3306 
./mysql -u root --password=root -h localhost -P 3306 $1_dev< database_dev.sql

