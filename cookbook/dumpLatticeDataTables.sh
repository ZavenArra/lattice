#!/bin/bash

TABLES=`tr '\n' ' ' < dataTables.txt | sed '$s/.$//'`
mysqldump -u root --password=root -S /Applications/MAMP/tmp/mysql/mysql.sock  junk3 $TABLES

