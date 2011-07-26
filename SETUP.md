Informal (for now) list of setup that needs doing

1) Create a new database on your server
2) Copy the demo database file to application/config
cp modules/database/config/database.php application/config/database.php
3) Edit the database config at application/config/database.php to contain the correct settings
4) Import a copy of the database sql (this step will soon be removed)
mysql -u username -p database < sql.sql
5) For DEV installs, change lattice to master branch
cd lattice (or lattice)
git checkout master
6) Load the cms url
http://mysite.org/cms
and copy the admin password
7) Reload the cms url, log in, and change your password or create a new user
8) Initialize site data
http://mysite.org/builder/initializeSite
This will soon contain a default build of the site, rather than the testing data, for deployments
9) Copy objects.xml and objects.dtd from lattice to application, and configure for your site
cp lattice/mopcms/config/objects.xml application/config/
cp lattice/mopcms/config/objects.dtd application/config/
10) Rerun initialization
