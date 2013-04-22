#!/bin/bash

USERNAME=root
PASSWORD=root
DATABASE=junk3

TABLES=`tr '\n' ' ' < dataTables.txt | sed '$s/.$//'`
mysqldump -u $USERNAME --password=$PASSWORD -S /Applications/MAMP/tmp/mysql/mysql.sock $DATABASE $TABLES > latticeData.sql

