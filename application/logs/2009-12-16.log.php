<?php defined('SYSPATH') or die('No direct script access.'); ?>

2009-12-16 00:13:13 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:13:13 +00:00 --- debug: Database Library initialized
2009-12-16 00:13:14 +00:00 --- info: delete from templates
2009-12-16 00:13:14 +00:00 --- info: alter table templates AUTO_INCREMENT = 1
2009-12-16 00:13:14 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:14 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('basiccategory', 'content_small', 'CATEGORY')
2009-12-16 00:13:14 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:14 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singleipe', 'content_small', 'LEAF')
2009-12-16 00:13:14 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:14 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singleradiogroup', 'content_small', 'LEAF')
2009-12-16 00:13:14 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:14 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singlecheckbox', 'content_small', 'LEAF')
2009-12-16 00:13:14 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:14 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singledate', 'content_small', 'LEAF')
2009-12-16 00:13:14 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:14 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singletime', 'content_small', 'LEAF')
2009-12-16 00:13:14 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:14 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('portfolio', 'content_small', 'LEAF')
2009-12-16 00:13:17 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:13:17 +00:00 --- debug: Database Library initialized
2009-12-16 00:13:18 +00:00 --- info: delete from templates
2009-12-16 00:13:18 +00:00 --- info: alter table templates AUTO_INCREMENT = 1
2009-12-16 00:13:18 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:18 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('basiccategory', 'content_small', 'CATEGORY')
2009-12-16 00:13:18 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:18 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singleipe', 'content_small', 'LEAF')
2009-12-16 00:13:18 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:18 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singleradiogroup', 'content_small', 'LEAF')
2009-12-16 00:13:18 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:18 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singlecheckbox', 'content_small', 'LEAF')
2009-12-16 00:13:18 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:18 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singledate', 'content_small', 'LEAF')
2009-12-16 00:13:18 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:18 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singletime', 'content_small', 'LEAF')
2009-12-16 00:13:18 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:18 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('portfolio', 'content_small', 'LEAF')
2009-12-16 00:13:19 +00:00 --- info: delete from pages
2009-12-16 00:13:19 +00:00 --- info: alter table pages AUTO_INCREMENT = 1
2009-12-16 00:13:19 +00:00 --- info: delete from content_smalls
2009-12-16 00:13:19 +00:00 --- info: alter table content_smalls AUTO_INCREMENT = 1
2009-12-16 00:13:19 +00:00 --- info: delete from content_mediums
2009-12-16 00:13:19 +00:00 --- info: alter table content_mediums AUTO_INCREMENT = 1
2009-12-16 00:13:19 +00:00 --- info: delete from content_larges
2009-12-16 00:13:19 +00:00 --- info: alter table content_larges AUTO_INCREMENT = 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'basiccategory'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 0
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (1, 1, 0, 1, now())
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (1)
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'MoP UI Tests' WHERE `id` = 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singleipe'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (2, 1, 1, 1, now())
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (2)
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single IPE' WHERE `id` = 2
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singleradiogroup'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (3, 1, 1, 2, now())
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (3)
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Radio Group' WHERE `id` = 3
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singlecheckbox'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (4, 1, 1, 3, now())
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (4)
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Checkbox' WHERE `id` = 4
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singledate'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (5, 1, 1, 4, now())
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (5)
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Date' WHERE `id` = 5
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singletime'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (6, 1, 1, 5, now())
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (6)
2009-12-16 00:13:19 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:19 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Time' WHERE `id` = 6
2009-12-16 00:13:33 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:13:33 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:13:33 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:13:33 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:13:33 +00:00 --- debug: Database Library initialized
2009-12-16 00:13:33 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:33 +00:00 --- debug: Session Library initialized
2009-12-16 00:13:33 +00:00 --- debug: Auth Library loaded
2009-12-16 00:13:33 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:33 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:33 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:13:33 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:13:33 +00:00 --- debug: Loading module: navigation
2009-12-16 00:13:33 +00:00 --- debug: Loading controller: navigation
2009-12-16 00:13:33 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 00:13:33 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 00:13:33 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 00:13:33 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 00:13:33 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 00:13:33 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:13:33 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:13:33 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 00:13:33 +00:00 --- debug: found resources for adminpage
2009-12-16 00:13:33 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 00:13:33 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 00:13:33 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 00:13:33 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 00:13:33 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 00:13:33 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 00:13:33 +00:00 --- debug: Loading module: adminheader
2009-12-16 00:13:33 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 00:13:33 +00:00 --- debug: Loading module: mop_auth
2009-12-16 00:13:33 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 00:13:33 +00:00 --- debug: Loading module: adminfooter
2009-12-16 00:13:33 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 00:13:33 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:13:33 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:13:33 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 00:13:33 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 00:13:33 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 00:13:33 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 00:13:33 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 00:13:34 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:13:34 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:13:34 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:13:34 +00:00 --- debug: Database Library initialized
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:13:34 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:13:34 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:13:34 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:13:34 +00:00 --- debug: Database Library initialized
2009-12-16 00:13:34 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- debug: Session Library initialized
2009-12-16 00:13:34 +00:00 --- debug: Auth Library loaded
2009-12-16 00:13:34 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:13:34 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:13:34 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:13:34 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:34 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:13:36 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:13:36 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:13:36 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:13:36 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:13:36 +00:00 --- debug: Database Library initialized
2009-12-16 00:13:36 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:36 +00:00 --- debug: Session Library initialized
2009-12-16 00:13:36 +00:00 --- debug: Auth Library loaded
2009-12-16 00:13:36 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:36 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:13:36 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:13:36 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:36 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:13:36 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:13:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:36 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:13:37 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:13:37 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:13:37 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:13:37 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:13:37 +00:00 --- debug: Database Library initialized
2009-12-16 00:13:37 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:37 +00:00 --- debug: Session Library initialized
2009-12-16 00:13:37 +00:00 --- debug: Auth Library loaded
2009-12-16 00:13:37 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:37 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:37 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:13:37 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:13:37 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:37 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:37 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:13:37 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:13:37 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:37 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:37 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:37 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:37 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:13:55 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:13:55 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:13:55 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:13:55 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:13:55 +00:00 --- debug: Database Library initialized
2009-12-16 00:13:55 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:55 +00:00 --- debug: Session Library initialized
2009-12-16 00:13:55 +00:00 --- debug: Auth Library loaded
2009-12-16 00:13:55 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:55 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:55 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:13:55 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:13:55 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:55 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:55 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:13:55 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:13:55 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:55 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:55 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:55 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:55 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:13:56 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:13:56 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:13:56 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:13:56 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:13:56 +00:00 --- debug: Database Library initialized
2009-12-16 00:13:56 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:56 +00:00 --- debug: Session Library initialized
2009-12-16 00:13:56 +00:00 --- debug: Auth Library loaded
2009-12-16 00:13:56 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:56 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:56 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:13:56 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:13:56 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:56 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:56 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:13:56 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:13:56 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:56 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:59 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:13:59 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:13:59 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:13:59 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:13:59 +00:00 --- debug: Database Library initialized
2009-12-16 00:13:59 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:59 +00:00 --- debug: Session Library initialized
2009-12-16 00:13:59 +00:00 --- debug: Auth Library loaded
2009-12-16 00:13:59 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:59 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:59 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:13:59 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:13:59 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:59 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:59 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:13:59 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:13:59 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:59 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:13:59 +00:00 --- info: MY_ORM constructor
2009-12-16 00:13:59 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:00 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:14:00 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:14:00 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:14:00 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:14:00 +00:00 --- debug: Database Library initialized
2009-12-16 00:14:00 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:00 +00:00 --- debug: Session Library initialized
2009-12-16 00:14:00 +00:00 --- debug: Auth Library loaded
2009-12-16 00:14:00 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:00 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:00 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:14:00 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:14:00 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:00 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:00 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:14:00 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:14:00 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:00 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:00 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:00 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:00 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:14:01 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:14:01 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:14:01 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:14:01 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:14:01 +00:00 --- debug: Database Library initialized
2009-12-16 00:14:01 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:01 +00:00 --- debug: Session Library initialized
2009-12-16 00:14:01 +00:00 --- debug: Auth Library loaded
2009-12-16 00:14:01 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:01 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:01 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:14:01 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:14:01 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:01 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:01 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:14:01 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:14:01 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:01 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:01 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:01 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:01 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:14:02 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:14:02 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:14:02 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:14:02 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:14:02 +00:00 --- debug: Database Library initialized
2009-12-16 00:14:02 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:02 +00:00 --- debug: Session Library initialized
2009-12-16 00:14:02 +00:00 --- debug: Auth Library loaded
2009-12-16 00:14:02 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:02 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:02 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:14:02 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:14:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:02 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:02 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:14:02 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:14:02 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:02 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:07 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:14:07 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:14:07 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:14:07 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:14:07 +00:00 --- debug: Database Library initialized
2009-12-16 00:14:07 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:07 +00:00 --- debug: Session Library initialized
2009-12-16 00:14:07 +00:00 --- debug: Auth Library loaded
2009-12-16 00:14:07 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:07 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:07 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:14:07 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:14:07 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:07 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:07 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:14:07 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:14:07 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:07 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:07 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:07 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:54 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:14:54 +00:00 --- debug: Database Library initialized
2009-12-16 00:14:55 +00:00 --- info: delete from templates
2009-12-16 00:14:55 +00:00 --- info: alter table templates AUTO_INCREMENT = 1
2009-12-16 00:14:56 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:56 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('basiccategory', 'content_small', 'CATEGORY')
2009-12-16 00:14:56 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:56 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singleipe', 'content_small', 'LEAF')
2009-12-16 00:14:56 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:56 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singleradiogroup', 'content_small', 'LEAF')
2009-12-16 00:14:56 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:56 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singlecheckbox', 'content_small', 'LEAF')
2009-12-16 00:14:56 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:56 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singledate', 'content_small', 'LEAF')
2009-12-16 00:14:56 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:56 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singletime', 'content_small', 'LEAF')
2009-12-16 00:14:56 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:56 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('portfolio', 'content_small', 'LEAF')
2009-12-16 00:14:57 +00:00 --- info: delete from pages
2009-12-16 00:14:57 +00:00 --- info: alter table pages AUTO_INCREMENT = 1
2009-12-16 00:14:57 +00:00 --- info: delete from content_smalls
2009-12-16 00:14:57 +00:00 --- info: alter table content_smalls AUTO_INCREMENT = 1
2009-12-16 00:14:57 +00:00 --- info: delete from content_mediums
2009-12-16 00:14:57 +00:00 --- info: alter table content_mediums AUTO_INCREMENT = 1
2009-12-16 00:14:57 +00:00 --- info: delete from content_larges
2009-12-16 00:14:57 +00:00 --- info: alter table content_larges AUTO_INCREMENT = 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'basiccategory'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 0
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (1, 1, 0, 1, now())
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (1)
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'MoP UI Tests' WHERE `id` = 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singleipe'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (2, 1, 1, 1, now())
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (2)
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single IPE' WHERE `id` = 2
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singleradiogroup'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (3, 1, 1, 2, now())
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (3)
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Radio Group' WHERE `id` = 3
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singlecheckbox'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (4, 1, 1, 3, now())
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (4)
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Checkbox' WHERE `id` = 4
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singledate'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (5, 1, 1, 4, now())
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (5)
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Date' WHERE `id` = 5
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singletime'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (6, 1, 1, 5, now())
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (6)
2009-12-16 00:14:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:57 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Time' WHERE `id` = 6
2009-12-16 00:14:58 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:14:58 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:14:59 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:14:59 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:14:59 +00:00 --- debug: Database Library initialized
2009-12-16 00:14:59 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:59 +00:00 --- debug: Session Library initialized
2009-12-16 00:14:59 +00:00 --- debug: Auth Library loaded
2009-12-16 00:14:59 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:59 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:59 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:14:59 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:14:59 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:59 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:59 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:14:59 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:14:59 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:59 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:59 +00:00 --- info: MY_ORM constructor
2009-12-16 00:14:59 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:14:59 +00:00 --- error: Uncaught PHP Error: Undefined variable: radios in file modules/mopui/views/ui_radioGroup.php on line 6
2009-12-16 00:15:08 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:15:08 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:15:08 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:15:08 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:15:08 +00:00 --- debug: Database Library initialized
2009-12-16 00:15:08 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:08 +00:00 --- debug: Session Library initialized
2009-12-16 00:15:08 +00:00 --- debug: Auth Library loaded
2009-12-16 00:15:08 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:08 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:08 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:15:08 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:15:08 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:08 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:08 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:15:08 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:15:08 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:08 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:08 +00:00 --- error: Uncaught PHP Error: Undefined variable: radios in file modules/mopui/views/ui_radioGroup.php on line 6
2009-12-16 00:15:09 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:15:09 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:15:09 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:15:10 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:15:10 +00:00 --- debug: Database Library initialized
2009-12-16 00:15:10 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:10 +00:00 --- debug: Session Library initialized
2009-12-16 00:15:10 +00:00 --- debug: Auth Library loaded
2009-12-16 00:15:10 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:10 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:15:10 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:15:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:10 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:15:10 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:15:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:10 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:15:10 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:15:10 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:15:10 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:15:10 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:15:10 +00:00 --- debug: Database Library initialized
2009-12-16 00:15:10 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:10 +00:00 --- debug: Session Library initialized
2009-12-16 00:15:10 +00:00 --- debug: Auth Library loaded
2009-12-16 00:15:10 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:10 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:15:10 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:15:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:10 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:15:10 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:15:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:10 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:15:11 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:15:11 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:15:11 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:15:11 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:15:11 +00:00 --- debug: Database Library initialized
2009-12-16 00:15:11 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:11 +00:00 --- debug: Session Library initialized
2009-12-16 00:15:11 +00:00 --- debug: Auth Library loaded
2009-12-16 00:15:11 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:11 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:11 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:15:11 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:15:11 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:11 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:11 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:15:11 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:15:11 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:11 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:11 +00:00 --- info: MY_ORM constructor
2009-12-16 00:15:11 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:15:11 +00:00 --- error: Uncaught PHP Error: Undefined variable: radios in file modules/mopui/views/ui_radioGroup.php on line 6
2009-12-16 00:16:33 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:16:33 +00:00 --- debug: Database Library initialized
2009-12-16 00:16:35 +00:00 --- info: delete from templates
2009-12-16 00:16:35 +00:00 --- info: alter table templates AUTO_INCREMENT = 1
2009-12-16 00:16:35 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:35 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('basiccategory', 'content_small', 'CATEGORY')
2009-12-16 00:16:35 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:35 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singleipe', 'content_small', 'LEAF')
2009-12-16 00:16:35 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:35 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singleradiogroup', 'content_small', 'LEAF')
2009-12-16 00:16:35 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:35 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singlecheckbox', 'content_small', 'LEAF')
2009-12-16 00:16:35 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:35 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singledate', 'content_small', 'LEAF')
2009-12-16 00:16:35 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:35 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singletime', 'content_small', 'LEAF')
2009-12-16 00:16:35 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:35 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('portfolio', 'content_small', 'LEAF')
2009-12-16 00:16:36 +00:00 --- info: delete from pages
2009-12-16 00:16:36 +00:00 --- info: alter table pages AUTO_INCREMENT = 1
2009-12-16 00:16:36 +00:00 --- info: delete from content_smalls
2009-12-16 00:16:36 +00:00 --- info: alter table content_smalls AUTO_INCREMENT = 1
2009-12-16 00:16:36 +00:00 --- info: delete from content_mediums
2009-12-16 00:16:36 +00:00 --- info: alter table content_mediums AUTO_INCREMENT = 1
2009-12-16 00:16:36 +00:00 --- info: delete from content_larges
2009-12-16 00:16:36 +00:00 --- info: alter table content_larges AUTO_INCREMENT = 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'basiccategory'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 0
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (1, 1, 0, 1, now())
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (1)
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'MoP UI Tests' WHERE `id` = 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singleipe'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (2, 1, 1, 1, now())
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (2)
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single IPE' WHERE `id` = 2
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singleradiogroup'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (3, 1, 1, 2, now())
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (3)
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Radio Group' WHERE `id` = 3
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singlecheckbox'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (4, 1, 1, 3, now())
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (4)
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Checkbox' WHERE `id` = 4
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singledate'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (5, 1, 1, 4, now())
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (5)
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Date' WHERE `id` = 5
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singletime'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (6, 1, 1, 5, now())
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (6)
2009-12-16 00:16:36 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:36 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Time' WHERE `id` = 6
2009-12-16 00:16:38 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:16:38 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:16:38 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:16:38 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:16:38 +00:00 --- debug: Database Library initialized
2009-12-16 00:16:38 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:38 +00:00 --- debug: Session Library initialized
2009-12-16 00:16:38 +00:00 --- debug: Auth Library loaded
2009-12-16 00:16:38 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:38 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:38 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:16:38 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:16:38 +00:00 --- debug: Loading module: navigation
2009-12-16 00:16:38 +00:00 --- debug: Loading controller: navigation
2009-12-16 00:16:38 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 00:16:38 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 00:16:38 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 00:16:38 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 00:16:38 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 00:16:38 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:16:38 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:16:38 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 00:16:38 +00:00 --- debug: found resources for adminpage
2009-12-16 00:16:38 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 00:16:38 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 00:16:38 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 00:16:38 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 00:16:38 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 00:16:38 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 00:16:38 +00:00 --- debug: Loading module: adminheader
2009-12-16 00:16:38 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 00:16:38 +00:00 --- debug: Loading module: mop_auth
2009-12-16 00:16:38 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 00:16:38 +00:00 --- debug: Loading module: adminfooter
2009-12-16 00:16:38 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 00:16:38 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:16:38 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:16:38 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 00:16:38 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 00:16:38 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 00:16:38 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 00:16:38 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 00:16:39 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:16:39 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:16:39 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:16:39 +00:00 --- debug: Database Library initialized
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:16:39 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:16:39 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:16:39 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:16:39 +00:00 --- debug: Database Library initialized
2009-12-16 00:16:39 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- debug: Session Library initialized
2009-12-16 00:16:39 +00:00 --- debug: Auth Library loaded
2009-12-16 00:16:39 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:16:39 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:16:39 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:16:39 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:39 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:39 +00:00 --- error: Uncaught PHP Error: Undefined variable: radioname in file modules/mopui/views/ui_radioGroup.php on line 7
2009-12-16 00:16:41 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:16:41 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:16:41 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:16:41 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:16:41 +00:00 --- debug: Database Library initialized
2009-12-16 00:16:41 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:41 +00:00 --- debug: Session Library initialized
2009-12-16 00:16:41 +00:00 --- debug: Auth Library loaded
2009-12-16 00:16:41 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:41 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:41 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:16:41 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:16:41 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:41 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:41 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:16:41 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:16:41 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:41 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:41 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:41 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:41 +00:00 --- error: Uncaught PHP Error: Undefined variable: radioname in file modules/mopui/views/ui_radioGroup.php on line 7
2009-12-16 00:16:42 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:16:42 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:16:42 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:16:42 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:16:42 +00:00 --- debug: Database Library initialized
2009-12-16 00:16:42 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:42 +00:00 --- debug: Session Library initialized
2009-12-16 00:16:42 +00:00 --- debug: Auth Library loaded
2009-12-16 00:16:42 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:42 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:16:42 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:16:42 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:42 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:16:42 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:16:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:42 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:42 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:42 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:16:44 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:16:44 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:16:44 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:16:44 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:16:44 +00:00 --- debug: Database Library initialized
2009-12-16 00:16:44 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:44 +00:00 --- debug: Session Library initialized
2009-12-16 00:16:44 +00:00 --- debug: Auth Library loaded
2009-12-16 00:16:44 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:44 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:16:44 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:16:44 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:44 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:16:44 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:16:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:44 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:44 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:44 +00:00 --- error: Uncaught PHP Error: Undefined variable: radioname in file modules/mopui/views/ui_radioGroup.php on line 7
2009-12-16 00:16:48 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:16:48 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:16:48 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:16:48 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:16:48 +00:00 --- debug: Database Library initialized
2009-12-16 00:16:48 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:48 +00:00 --- debug: Session Library initialized
2009-12-16 00:16:48 +00:00 --- debug: Auth Library loaded
2009-12-16 00:16:48 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:48 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:48 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:16:48 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:16:48 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:48 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:48 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:16:48 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:16:48 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:48 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:48 +00:00 --- info: MY_ORM constructor
2009-12-16 00:16:48 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:16:48 +00:00 --- error: Uncaught PHP Error: Undefined variable: radioname in file modules/mopui/views/ui_radioGroup.php on line 7
2009-12-16 00:17:15 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:15 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:15 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:16 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:16 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:16 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:16 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:16 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:16 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:16 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:16 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:16 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:16 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:16 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:16 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:16 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:16 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:16 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:16 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:16 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:16 +00:00 --- error: Uncaught PHP Error: Undefined variable: radioname in file modules/mopui/views/ui_radioGroup.php on line 7
2009-12-16 00:17:20 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:20 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:21 +00:00 --- info: delete from templates
2009-12-16 00:17:21 +00:00 --- info: alter table templates AUTO_INCREMENT = 1
2009-12-16 00:17:21 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:21 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('basiccategory', 'content_small', 'CATEGORY')
2009-12-16 00:17:21 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:21 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singleipe', 'content_small', 'LEAF')
2009-12-16 00:17:21 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:21 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singleradiogroup', 'content_small', 'LEAF')
2009-12-16 00:17:21 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:21 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singlecheckbox', 'content_small', 'LEAF')
2009-12-16 00:17:21 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:21 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singledate', 'content_small', 'LEAF')
2009-12-16 00:17:21 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:21 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('singletime', 'content_small', 'LEAF')
2009-12-16 00:17:21 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:21 +00:00 --- info: INSERT INTO `templates` (`templatename`, `contenttable`, `nodetype`) VALUES ('portfolio', 'content_small', 'LEAF')
2009-12-16 00:17:23 +00:00 --- info: delete from pages
2009-12-16 00:17:23 +00:00 --- info: alter table pages AUTO_INCREMENT = 1
2009-12-16 00:17:23 +00:00 --- info: delete from content_smalls
2009-12-16 00:17:23 +00:00 --- info: alter table content_smalls AUTO_INCREMENT = 1
2009-12-16 00:17:23 +00:00 --- info: delete from content_mediums
2009-12-16 00:17:23 +00:00 --- info: alter table content_mediums AUTO_INCREMENT = 1
2009-12-16 00:17:23 +00:00 --- info: delete from content_larges
2009-12-16 00:17:23 +00:00 --- info: alter table content_larges AUTO_INCREMENT = 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'basiccategory'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 0
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (1, 1, 0, 1, now())
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (1)
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'MoP UI Tests' WHERE `id` = 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singleipe'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (2, 1, 1, 1, now())
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (2)
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single IPE' WHERE `id` = 2
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singleradiogroup'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (3, 1, 1, 2, now())
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (3)
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Radio Group' WHERE `id` = 3
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singlecheckbox'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (4, 1, 1, 3, now())
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (4)
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Checkbox' WHERE `id` = 4
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singledate'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (5, 1, 1, 4, now())
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (5)
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Date' WHERE `id` = 5
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`templatename` = 'singletime'
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT max(sortorder) as maxsort
FROM (`pages`)
WHERE `parentid` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `pages` (`template_id`, `published`, `parentid`, `sortorder`, `dateadded`) VALUES (6, 1, 1, 5, now())
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: INSERT INTO `content_smalls` (`page_id`) VALUES (6)
2009-12-16 00:17:23 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:23 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'Single Time' WHERE `id` = 6
2009-12-16 00:17:25 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:25 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:25 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:25 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:25 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:25 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:25 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:25 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:25 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:25 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:25 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:25 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:25 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:25 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:25 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:25 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:25 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:25 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:25 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:25 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:25 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:17:30 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:30 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:30 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:30 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:30 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:30 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:30 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:30 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:30 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:30 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:30 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:30 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:30 +00:00 --- debug: Loading module: navigation
2009-12-16 00:17:30 +00:00 --- debug: Loading controller: navigation
2009-12-16 00:17:30 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 00:17:30 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 00:17:30 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 00:17:30 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 00:17:30 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 00:17:30 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:17:30 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:17:30 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 00:17:30 +00:00 --- debug: found resources for adminpage
2009-12-16 00:17:30 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 00:17:30 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 00:17:30 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 00:17:30 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 00:17:30 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 00:17:30 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 00:17:30 +00:00 --- debug: Loading module: adminheader
2009-12-16 00:17:30 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 00:17:30 +00:00 --- debug: Loading module: mop_auth
2009-12-16 00:17:30 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 00:17:30 +00:00 --- debug: Loading module: adminfooter
2009-12-16 00:17:30 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 00:17:30 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:17:30 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:17:30 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 00:17:30 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 00:17:30 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 00:17:30 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 00:17:30 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 00:17:31 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:31 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:31 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:31 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:31 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:31 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:31 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:31 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:31 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:31 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:31 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:31 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:31 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:31 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:31 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:17:38 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:38 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:38 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:38 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:38 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:38 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:38 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:38 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:38 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:38 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:38 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:38 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:38 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:38 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:38 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:38 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:38 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:38 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:38 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:38 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:38 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:17:39 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:39 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:39 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:39 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:39 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:39 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:39 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:39 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:39 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:39 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:39 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:39 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:39 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:39 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:39 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:39 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:39 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:39 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:17:40 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:40 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:40 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:40 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:40 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:40 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:40 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:40 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:40 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:40 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:40 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:40 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:40 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:40 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:40 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:40 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:40 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:40 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:40 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:40 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:40 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:17:41 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:41 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:41 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:41 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:41 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:41 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:41 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:41 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:41 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:41 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:41 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:41 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:41 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:41 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:41 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:41 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:41 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:41 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:41 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:41 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:41 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:17:42 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:42 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:42 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:42 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:42 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:42 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:42 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:42 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:42 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:42 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:42 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:42 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:42 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:42 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:42 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:42 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:42 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:17:44 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:44 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:44 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:44 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:44 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:44 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:44 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:44 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:44 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:44 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:44 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:44 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:44 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:44 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:44 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:44 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:44 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:17:44 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:44 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:44 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:44 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:44 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:44 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:44 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:44 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:44 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:44 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:44 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:44 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:44 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:44 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:44 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:44 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:44 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:17:46 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:46 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:46 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:46 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:46 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:46 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:46 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:46 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:46 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:46 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:46 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:46 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:46 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:46 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:46 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:46 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:46 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:46 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:46 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:46 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:46 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:17:50 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:17:50 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:17:50 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:17:50 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:17:50 +00:00 --- debug: Database Library initialized
2009-12-16 00:17:50 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:50 +00:00 --- debug: Session Library initialized
2009-12-16 00:17:50 +00:00 --- debug: Auth Library loaded
2009-12-16 00:17:50 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:50 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:50 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:17:50 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:17:50 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:50 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:50 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:17:50 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:17:50 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:50 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:50 +00:00 --- info: MY_ORM constructor
2009-12-16 00:17:50 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:17:50 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:23:41 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:23:41 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:23:41 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:23:41 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:23:41 +00:00 --- debug: Database Library initialized
2009-12-16 00:23:41 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 1
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:41 +00:00 --- debug: Session Library initialized
2009-12-16 00:23:41 +00:00 --- debug: Auth Library loaded
2009-12-16 00:23:41 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:23:41 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:23:41 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:23:41 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:23:41 +00:00 --- debug: Database Library initialized
2009-12-16 00:23:41 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 0
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:41 +00:00 --- debug: Session Library initialized
2009-12-16 00:23:41 +00:00 --- debug: Auth Library loaded
2009-12-16 00:23:41 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 00:23:41 +00:00 --- debug: found resources for adminpage
2009-12-16 00:23:41 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 00:23:41 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 00:23:41 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 00:23:41 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 00:23:41 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 00:23:41 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 00:23:41 +00:00 --- debug: Loading module: adminheader
2009-12-16 00:23:41 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 00:23:41 +00:00 --- debug: Loading module: mop_auth
2009-12-16 00:23:41 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 00:23:41 +00:00 --- debug: Loading module: adminfooter
2009-12-16 00:23:41 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 00:23:41 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:23:41 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:23:41 +00:00 --- debug: autoloading library frontend resources for auth/template
2009-12-16 00:23:41 +00:00 --- debug: autoloading frontend resources for auth/template
2009-12-16 00:23:41 +00:00 --- debug: autoloading library frontend resources for auth
2009-12-16 00:23:41 +00:00 --- debug: found resources for auth
2009-12-16 00:23:41 +00:00 --- info: adding resource librarycssmodules/cms/views/cms.css
2009-12-16 00:23:49 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:23:49 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:23:49 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:23:49 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:23:49 +00:00 --- debug: Database Library initialized
2009-12-16 00:23:49 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 0
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:49 +00:00 --- debug: Session Library initialized
2009-12-16 00:23:49 +00:00 --- debug: Auth Library loaded
2009-12-16 00:23:50 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:23:50 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:23:50 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:23:50 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:23:50 +00:00 --- debug: Database Library initialized
2009-12-16 00:23:50 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 0
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:50 +00:00 --- debug: Session Library initialized
2009-12-16 00:23:50 +00:00 --- debug: Auth Library loaded
2009-12-16 00:23:50 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 00:23:50 +00:00 --- debug: found resources for adminpage
2009-12-16 00:23:50 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 00:23:50 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 00:23:50 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 00:23:50 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 00:23:50 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 00:23:50 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 00:23:50 +00:00 --- debug: Loading module: adminheader
2009-12-16 00:23:50 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 00:23:50 +00:00 --- debug: Loading module: mop_auth
2009-12-16 00:23:50 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 00:23:50 +00:00 --- debug: Loading module: adminfooter
2009-12-16 00:23:50 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 00:23:50 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:23:50 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:23:50 +00:00 --- debug: autoloading library frontend resources for auth/template
2009-12-16 00:23:50 +00:00 --- debug: autoloading frontend resources for auth/template
2009-12-16 00:23:50 +00:00 --- debug: autoloading library frontend resources for auth
2009-12-16 00:23:50 +00:00 --- debug: found resources for auth
2009-12-16 00:23:50 +00:00 --- info: adding resource librarycssmodules/cms/views/cms.css
2009-12-16 00:23:53 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:23:53 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:23:53 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:23:53 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:23:53 +00:00 --- debug: Database Library initialized
2009-12-16 00:23:53 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 0
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:53 +00:00 --- debug: Session Library initialized
2009-12-16 00:23:53 +00:00 --- debug: Auth Library loaded
2009-12-16 00:23:53 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`username` = 'deepwinter'
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:53 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:53 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'login'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:53 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:53 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:23:53 +00:00 --- info: UPDATE `users` SET `logins` = 30, `last_login` = 1260923033 WHERE `id` = 3
2009-12-16 00:23:53 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:23:53 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:23:53 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:23:53 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:23:53 +00:00 --- debug: Database Library initialized
2009-12-16 00:23:53 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:53 +00:00 --- debug: Session Library initialized
2009-12-16 00:23:53 +00:00 --- debug: Auth Library loaded
2009-12-16 00:23:53 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:53 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:53 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:23:53 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:23:53 +00:00 --- debug: Loading module: navigation
2009-12-16 00:23:53 +00:00 --- debug: Loading controller: navigation
2009-12-16 00:23:53 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 00:23:53 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 00:23:53 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 00:23:53 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 00:23:53 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 00:23:53 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:23:53 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:23:53 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 00:23:53 +00:00 --- debug: found resources for adminpage
2009-12-16 00:23:53 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 00:23:53 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 00:23:53 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 00:23:53 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 00:23:53 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 00:23:53 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 00:23:53 +00:00 --- debug: Loading module: adminheader
2009-12-16 00:23:53 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 00:23:53 +00:00 --- debug: Loading module: mop_auth
2009-12-16 00:23:53 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 00:23:53 +00:00 --- debug: Loading module: adminfooter
2009-12-16 00:23:53 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 00:23:53 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:23:53 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:23:53 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 00:23:53 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 00:23:53 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 00:23:53 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 00:23:53 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 00:23:54 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:23:54 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:23:54 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:23:54 +00:00 --- debug: Database Library initialized
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:57 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:23:57 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:23:57 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:23:57 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:23:57 +00:00 --- debug: Database Library initialized
2009-12-16 00:23:57 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:57 +00:00 --- debug: Session Library initialized
2009-12-16 00:23:57 +00:00 --- debug: Auth Library loaded
2009-12-16 00:23:57 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:57 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:23:57 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:23:57 +00:00 --- debug: Loading module: navigation
2009-12-16 00:23:57 +00:00 --- debug: Loading controller: navigation
2009-12-16 00:23:57 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 00:23:57 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 00:23:57 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 00:23:57 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 00:23:57 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 00:23:57 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:23:57 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:23:57 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 00:23:57 +00:00 --- debug: found resources for adminpage
2009-12-16 00:23:57 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 00:23:57 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 00:23:57 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 00:23:57 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 00:23:57 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 00:23:57 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 00:23:57 +00:00 --- debug: Loading module: adminheader
2009-12-16 00:23:57 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 00:23:57 +00:00 --- debug: Loading module: mop_auth
2009-12-16 00:23:57 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 00:23:57 +00:00 --- debug: Loading module: adminfooter
2009-12-16 00:23:57 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 00:23:57 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:23:57 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:23:57 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 00:23:57 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 00:23:57 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 00:23:57 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 00:23:57 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 00:23:58 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:23:58 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:23:58 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:23:58 +00:00 --- debug: Database Library initialized
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:23:58 +00:00 --- info: MY_ORM constructor
2009-12-16 00:23:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:28 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:28 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:28 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:28 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:28 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:28 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:28 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:28 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:28 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:28 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:28 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:28 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:28 +00:00 --- debug: Loading module: navigation
2009-12-16 00:25:28 +00:00 --- debug: Loading controller: navigation
2009-12-16 00:25:28 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 00:25:28 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 00:25:28 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 00:25:28 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 00:25:28 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 00:25:28 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:25:28 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:25:28 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 00:25:28 +00:00 --- debug: found resources for adminpage
2009-12-16 00:25:28 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 00:25:28 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 00:25:28 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 00:25:28 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 00:25:28 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 00:25:28 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 00:25:28 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 00:25:28 +00:00 --- debug: Loading module: adminheader
2009-12-16 00:25:28 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 00:25:28 +00:00 --- debug: Loading module: mop_auth
2009-12-16 00:25:28 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 00:25:28 +00:00 --- debug: Loading module: adminfooter
2009-12-16 00:25:28 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 00:25:28 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:25:28 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:25:28 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 00:25:28 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 00:25:28 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 00:25:28 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 00:25:28 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 00:25:29 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:29 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:29 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:29 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:29 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:29 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:34 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:34 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:34 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:34 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:34 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:34 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:34 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:34 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:34 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:34 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:34 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:34 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:34 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:25:34 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:25:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:34 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:34 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:25:35 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:35 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:35 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:35 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:35 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:35 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:35 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:35 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:35 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:35 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:35 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:35 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:35 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:35 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:35 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:25:35 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:25:35 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:35 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:36 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:25:40 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:40 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:40 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:40 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:40 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:40 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:40 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:40 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:40 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:40 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:40 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:40 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:40 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:40 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:40 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:40 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:40 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:40 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:40 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'test' WHERE `id` = 2
2009-12-16 00:25:40 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:40 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:40 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:40 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:40 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:40 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:42 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:42 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:42 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:42 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:42 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:42 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:42 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:42 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:42 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:42 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:42 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:42 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:42 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:25:42 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:25:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:42 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:42 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:42 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:42 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:25:44 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:44 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:44 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:44 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:44 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:44 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:44 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:44 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:44 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:44 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:44 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:44 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:44 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:44 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:44 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'Array' WHERE `id` = 3
2009-12-16 00:25:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:44 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:44 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:44 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:44 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:46 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:46 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:46 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:46 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:46 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:46 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:46 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:46 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:46 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:46 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:46 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:46 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:46 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:46 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:46 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:25:46 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:25:46 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:46 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:46 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:46 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:46 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:25:47 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:47 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:47 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:47 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:47 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:47 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:47 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:47 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:47 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:47 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:47 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:47 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:47 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:47 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:47 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:25:47 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:25:47 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:47 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:47 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:47 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:47 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:25:51 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:51 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:51 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:51 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:51 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:51 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:51 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:51 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:51 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:51 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:51 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:51 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:51 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:51 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:51 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:25:51 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:25:51 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:51 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:51 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:51 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:51 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:25:52 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:52 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:52 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:53 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:53 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:53 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:53 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:53 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:53 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:53 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:53 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:53 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:53 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:53 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:53 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:53 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:53 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '1' WHERE `id` = 4
2009-12-16 00:25:53 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:53 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:53 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:53 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:54 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:54 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:54 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:54 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:54 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:54 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:54 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:54 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:54 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:54 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:54 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:54 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:54 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:25:54 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:25:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:54 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:54 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:25:55 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:55 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:55 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:55 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:55 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:55 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:55 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:55 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:55 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:55 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:55 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:55 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:55 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:55 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:55 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:25:55 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:25:55 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:55 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:55 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:55 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:55 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:25:57 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:25:57 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:25:57 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:25:57 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:25:57 +00:00 --- debug: Database Library initialized
2009-12-16 00:25:57 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:57 +00:00 --- debug: Session Library initialized
2009-12-16 00:25:57 +00:00 --- debug: Auth Library loaded
2009-12-16 00:25:57 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:57 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:25:57 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:25:57 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:57 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:25:57 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:25:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:57 +00:00 --- info: MY_ORM constructor
2009-12-16 00:25:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:25:57 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:26:00 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:26:00 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:26:00 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:26:00 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:26:00 +00:00 --- debug: Database Library initialized
2009-12-16 00:26:00 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:00 +00:00 --- debug: Session Library initialized
2009-12-16 00:26:00 +00:00 --- debug: Auth Library loaded
2009-12-16 00:26:00 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:00 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:00 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:26:00 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:26:00 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:00 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:00 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:00 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:00 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:00 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:00 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '2009/12/02' WHERE `id` = 5
2009-12-16 00:26:00 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:00 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:00 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:00 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:00 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:00 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:01 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:26:01 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:26:01 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:26:01 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:26:01 +00:00 --- debug: Database Library initialized
2009-12-16 00:26:01 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:01 +00:00 --- debug: Session Library initialized
2009-12-16 00:26:01 +00:00 --- debug: Auth Library loaded
2009-12-16 00:26:01 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:01 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:01 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:26:01 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:26:01 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:01 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:01 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:26:01 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:26:01 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:01 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:01 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:01 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:01 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:26:04 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:26:04 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:26:04 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:26:04 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:26:04 +00:00 --- debug: Database Library initialized
2009-12-16 00:26:04 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:04 +00:00 --- debug: Session Library initialized
2009-12-16 00:26:04 +00:00 --- debug: Auth Library loaded
2009-12-16 00:26:04 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:04 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:04 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:26:04 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:26:04 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:04 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:04 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:04 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:04 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:04 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:04 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '19:25' WHERE `id` = 6
2009-12-16 00:26:04 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:04 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:04 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:04 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:04 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:04 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:09 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:26:09 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:26:09 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:26:09 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:26:09 +00:00 --- debug: Database Library initialized
2009-12-16 00:26:09 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:09 +00:00 --- debug: Session Library initialized
2009-12-16 00:26:09 +00:00 --- debug: Auth Library loaded
2009-12-16 00:26:09 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:09 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:09 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:26:09 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:26:09 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:09 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:09 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:09 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:09 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:09 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:09 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '19:12' WHERE `id` = 6
2009-12-16 00:26:09 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:09 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:09 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:09 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:09 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:09 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:10 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:26:10 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:26:10 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:26:10 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:26:10 +00:00 --- debug: Database Library initialized
2009-12-16 00:26:10 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:10 +00:00 --- debug: Session Library initialized
2009-12-16 00:26:10 +00:00 --- debug: Auth Library loaded
2009-12-16 00:26:10 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:10 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:26:10 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:26:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:10 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:26:10 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:26:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:10 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:26:10 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:26:10 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:26:10 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:26:10 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:26:10 +00:00 --- debug: Database Library initialized
2009-12-16 00:26:10 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:10 +00:00 --- debug: Session Library initialized
2009-12-16 00:26:10 +00:00 --- debug: Auth Library loaded
2009-12-16 00:26:10 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:10 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:26:10 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:26:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:10 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:26:10 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:26:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:10 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:10 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:26:11 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:26:11 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:26:11 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:26:11 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 00:26:11 +00:00 --- debug: Database Library initialized
2009-12-16 00:26:11 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:11 +00:00 --- debug: Session Library initialized
2009-12-16 00:26:11 +00:00 --- debug: Auth Library loaded
2009-12-16 00:26:11 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:11 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:11 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 00:26:11 +00:00 --- info: cms needs to choose navigation module
2009-12-16 00:26:11 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:11 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:11 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 00:26:11 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 00:26:11 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:11 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:11 +00:00 --- info: MY_ORM constructor
2009-12-16 00:26:11 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 00:26:11 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 00:47:01 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:47:01 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:47:01 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:47:01 +00:00 --- debug: Session Library initialized
2009-12-16 00:47:01 +00:00 --- debug: Auth Library loaded
2009-12-16 00:47:01 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 00:47:01 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 00:47:01 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 00:47:01 +00:00 --- debug: Session Library initialized
2009-12-16 00:47:01 +00:00 --- debug: Auth Library loaded
2009-12-16 00:47:01 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 00:47:01 +00:00 --- debug: found resources for adminpage
2009-12-16 00:47:01 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 00:47:01 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 00:47:01 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 00:47:01 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 00:47:01 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 00:47:01 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 00:47:01 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 00:47:01 +00:00 --- debug: Loading module: adminheader
2009-12-16 00:47:01 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 00:47:01 +00:00 --- debug: Loading module: mop_auth
2009-12-16 00:47:01 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 00:47:01 +00:00 --- debug: Loading module: adminfooter
2009-12-16 00:47:01 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 00:47:01 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 00:47:01 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 00:47:01 +00:00 --- debug: autoloading library frontend resources for auth/template
2009-12-16 00:47:01 +00:00 --- debug: autoloading frontend resources for auth/template
2009-12-16 00:47:01 +00:00 --- debug: autoloading library frontend resources for auth
2009-12-16 00:47:01 +00:00 --- debug: found resources for auth
2009-12-16 00:47:01 +00:00 --- info: adding resource librarycssmodules/cms/views/cms.css
2009-12-16 16:36:52 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:36:52 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:36:52 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:36:52 +00:00 --- debug: Session Library initialized
2009-12-16 16:36:52 +00:00 --- debug: Auth Library loaded
2009-12-16 16:36:52 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:36:52 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:36:52 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:36:52 +00:00 --- debug: Session Library initialized
2009-12-16 16:36:52 +00:00 --- debug: Auth Library loaded
2009-12-16 16:36:52 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:36:52 +00:00 --- debug: found resources for adminpage
2009-12-16 16:36:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:36:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:36:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:36:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:36:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:36:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:36:52 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:36:52 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:36:52 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:36:52 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:36:52 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:36:52 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:36:52 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:36:52 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:36:52 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:36:52 +00:00 --- debug: autoloading library frontend resources for auth/template
2009-12-16 16:36:52 +00:00 --- debug: autoloading frontend resources for auth/template
2009-12-16 16:36:52 +00:00 --- debug: autoloading library frontend resources for auth
2009-12-16 16:36:52 +00:00 --- debug: found resources for auth
2009-12-16 16:36:52 +00:00 --- info: adding resource librarycssmodules/cms/views/cms.css
2009-12-16 16:36:57 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:36:57 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:36:57 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:36:57 +00:00 --- debug: Session Library initialized
2009-12-16 16:36:57 +00:00 --- debug: Auth Library loaded
2009-12-16 16:36:57 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:36:57 +00:00 --- debug: Database Library initialized
2009-12-16 16:36:57 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`username` = 'deepwinter'
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:57 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:57 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'login'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:57 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:57 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:36:57 +00:00 --- info: UPDATE `users` SET `logins` = 31, `last_login` = 1260981417 WHERE `id` = 3
2009-12-16 16:36:57 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:36:57 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:36:57 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:36:57 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:36:57 +00:00 --- debug: Database Library initialized
2009-12-16 16:36:57 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:57 +00:00 --- debug: Session Library initialized
2009-12-16 16:36:57 +00:00 --- debug: Auth Library loaded
2009-12-16 16:36:57 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:57 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:57 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:36:57 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:36:57 +00:00 --- debug: Loading module: navigation
2009-12-16 16:36:57 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:36:57 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:36:57 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:36:57 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:36:57 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:36:57 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:36:57 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:36:57 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:36:57 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:36:57 +00:00 --- debug: found resources for adminpage
2009-12-16 16:36:57 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:36:57 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:36:57 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:36:57 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:36:57 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:36:57 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:36:57 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:36:57 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:36:57 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:36:57 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:36:57 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:36:57 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:36:57 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:36:57 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:36:57 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:36:57 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:36:57 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:36:57 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:36:57 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:36:57 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:36:58 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:36:58 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:36:58 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:36:58 +00:00 --- debug: Database Library initialized
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:36:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:36:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:00 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:37:00 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:37:00 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:37:00 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:37:00 +00:00 --- debug: Database Library initialized
2009-12-16 16:37:00 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:00 +00:00 --- debug: Session Library initialized
2009-12-16 16:37:00 +00:00 --- debug: Auth Library loaded
2009-12-16 16:37:00 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:00 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:00 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:37:00 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:37:00 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:00 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:00 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:37:00 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:37:00 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:00 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:00 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:00 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:00 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:37:04 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:37:04 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:37:04 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:37:04 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:37:04 +00:00 --- debug: Database Library initialized
2009-12-16 16:37:04 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:04 +00:00 --- debug: Session Library initialized
2009-12-16 16:37:04 +00:00 --- debug: Auth Library loaded
2009-12-16 16:37:04 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:04 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:37:04 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:37:04 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:04 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:37:04 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:37:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:04 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:04 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:04 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:37:07 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:37:07 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:37:07 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:37:07 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:37:07 +00:00 --- debug: Database Library initialized
2009-12-16 16:37:07 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:07 +00:00 --- debug: Session Library initialized
2009-12-16 16:37:07 +00:00 --- debug: Auth Library loaded
2009-12-16 16:37:07 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:07 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:07 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:37:07 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:37:07 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:07 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:07 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:37:07 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:37:07 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:07 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:07 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:07 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:07 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:37:09 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:37:09 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:37:09 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:37:09 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:37:09 +00:00 --- debug: Database Library initialized
2009-12-16 16:37:09 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:09 +00:00 --- debug: Session Library initialized
2009-12-16 16:37:09 +00:00 --- debug: Auth Library loaded
2009-12-16 16:37:09 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:09 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:09 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:37:09 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:37:09 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:09 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:09 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:09 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:09 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:09 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:09 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'Array' WHERE `id` = 3
2009-12-16 16:37:09 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:09 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:09 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:09 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:09 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:09 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:11 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:37:11 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:37:11 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:37:11 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:37:11 +00:00 --- debug: Database Library initialized
2009-12-16 16:37:11 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:11 +00:00 --- debug: Session Library initialized
2009-12-16 16:37:11 +00:00 --- debug: Auth Library loaded
2009-12-16 16:37:11 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:11 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:11 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:37:11 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:37:11 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:11 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:11 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:37:11 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:37:11 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:11 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:11 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:11 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:11 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:37:14 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:37:14 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:37:14 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:37:14 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:37:14 +00:00 --- debug: Database Library initialized
2009-12-16 16:37:14 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- debug: Session Library initialized
2009-12-16 16:37:14 +00:00 --- debug: Auth Library loaded
2009-12-16 16:37:14 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:37:14 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '0' WHERE `id` = 4
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:37:14 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:37:14 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:37:14 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:37:14 +00:00 --- debug: Database Library initialized
2009-12-16 16:37:14 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- debug: Session Library initialized
2009-12-16 16:37:14 +00:00 --- debug: Auth Library loaded
2009-12-16 16:37:14 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:37:14 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '1' WHERE `id` = 4
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:14 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:15 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:37:15 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:37:15 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:37:15 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:37:15 +00:00 --- debug: Database Library initialized
2009-12-16 16:37:15 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:15 +00:00 --- debug: Session Library initialized
2009-12-16 16:37:15 +00:00 --- debug: Auth Library loaded
2009-12-16 16:37:15 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:15 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:15 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:37:15 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:37:15 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:15 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:15 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:37:15 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:37:15 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:15 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:15 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:15 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:15 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:37:17 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:37:17 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:37:17 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:37:17 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:37:17 +00:00 --- debug: Database Library initialized
2009-12-16 16:37:17 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:17 +00:00 --- debug: Session Library initialized
2009-12-16 16:37:17 +00:00 --- debug: Auth Library loaded
2009-12-16 16:37:17 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:17 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:37:17 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:37:17 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:17 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:37:17 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:37:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:17 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:17 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:17 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:37:20 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:37:20 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:37:20 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:37:20 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:37:20 +00:00 --- debug: Database Library initialized
2009-12-16 16:37:20 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:20 +00:00 --- debug: Session Library initialized
2009-12-16 16:37:20 +00:00 --- debug: Auth Library loaded
2009-12-16 16:37:20 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:20 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:20 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:37:20 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:37:20 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:20 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:20 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:37:20 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:37:20 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:20 +00:00 --- info: MY_ORM constructor
2009-12-16 16:37:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:37:20 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:39:34 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:39:34 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:39:34 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:39:34 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:39:34 +00:00 --- debug: Database Library initialized
2009-12-16 16:39:34 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:34 +00:00 --- debug: Session Library initialized
2009-12-16 16:39:34 +00:00 --- debug: Auth Library loaded
2009-12-16 16:39:34 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:34 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:39:34 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:39:34 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:34 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:39:34 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:39:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:34 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:39:36 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:39:36 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:39:36 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:39:36 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:39:36 +00:00 --- debug: Database Library initialized
2009-12-16 16:39:36 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:36 +00:00 --- debug: Session Library initialized
2009-12-16 16:39:36 +00:00 --- debug: Auth Library loaded
2009-12-16 16:39:36 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:36 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:36 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:39:36 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:39:36 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:36 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:36 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:39:36 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:39:36 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:36 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:36 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:39:53 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:39:53 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:39:53 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:39:53 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:39:53 +00:00 --- debug: Database Library initialized
2009-12-16 16:39:53 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:53 +00:00 --- debug: Session Library initialized
2009-12-16 16:39:53 +00:00 --- debug: Auth Library loaded
2009-12-16 16:39:53 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:53 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:39:53 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:39:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:53 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:53 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'this is a test.' WHERE `id` = 2
2009-12-16 16:39:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:53 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:39:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:39:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:42:12 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:42:12 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:42:12 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:42:12 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:42:12 +00:00 --- debug: Database Library initialized
2009-12-16 16:42:12 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:42:12 +00:00 --- debug: Session Library initialized
2009-12-16 16:42:12 +00:00 --- debug: Auth Library loaded
2009-12-16 16:42:13 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:42:13 +00:00 --- info: MY_ORM constructor
2009-12-16 16:42:13 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:42:13 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:42:13 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:42:13 +00:00 --- info: MY_ORM constructor
2009-12-16 16:42:13 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:42:13 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:42:13 +00:00 --- info: MY_ORM constructor
2009-12-16 16:42:13 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:42:13 +00:00 --- info: MY_ORM constructor
2009-12-16 16:42:13 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:42:13 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:42:13 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:42:13 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:42:13 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:42:13 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:42:13 +00:00 --- debug: Database Library initialized
2009-12-16 16:42:13 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:42:13 +00:00 --- debug: Session Library initialized
2009-12-16 16:42:13 +00:00 --- debug: Auth Library loaded
2009-12-16 16:42:13 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:42:13 +00:00 --- info: MY_ORM constructor
2009-12-16 16:42:13 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:42:13 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:42:13 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:42:13 +00:00 --- info: MY_ORM constructor
2009-12-16 16:42:13 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:42:13 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:42:13 +00:00 --- info: MY_ORM constructor
2009-12-16 16:42:13 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:42:13 +00:00 --- info: MY_ORM constructor
2009-12-16 16:42:13 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:42:13 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:43:06 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:43:06 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:43:06 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:43:06 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:43:06 +00:00 --- debug: Database Library initialized
2009-12-16 16:43:06 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:06 +00:00 --- debug: Session Library initialized
2009-12-16 16:43:06 +00:00 --- debug: Auth Library loaded
2009-12-16 16:43:06 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:06 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:06 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:43:06 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:43:06 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:06 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:06 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:43:06 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:43:06 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:06 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:06 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:06 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:06 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:43:06 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:43:06 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:43:06 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:43:06 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:43:06 +00:00 --- debug: Database Library initialized
2009-12-16 16:43:06 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:06 +00:00 --- debug: Session Library initialized
2009-12-16 16:43:06 +00:00 --- debug: Auth Library loaded
2009-12-16 16:43:06 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:06 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:06 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:43:06 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:43:06 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:06 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:06 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:43:06 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:43:06 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:06 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:06 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:06 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:06 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:43:08 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:43:08 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:43:08 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:43:08 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:43:08 +00:00 --- debug: Database Library initialized
2009-12-16 16:43:08 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:08 +00:00 --- debug: Session Library initialized
2009-12-16 16:43:08 +00:00 --- debug: Auth Library loaded
2009-12-16 16:43:08 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:08 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:43:08 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:43:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:08 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:08 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'this is a test.' WHERE `id` = 2
2009-12-16 16:43:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:08 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:19 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:43:19 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:43:19 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:43:19 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:43:19 +00:00 --- debug: Database Library initialized
2009-12-16 16:43:19 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:19 +00:00 --- debug: Session Library initialized
2009-12-16 16:43:19 +00:00 --- debug: Auth Library loaded
2009-12-16 16:43:19 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:19 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:19 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:43:19 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:43:19 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:19 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:19 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:19 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:19 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'test' WHERE `id` = 2
2009-12-16 16:43:19 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:19 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:19 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:43:19 +00:00 --- info: MY_ORM constructor
2009-12-16 16:43:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:08 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:44:08 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:44:08 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:44:08 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:44:08 +00:00 --- debug: Database Library initialized
2009-12-16 16:44:08 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:08 +00:00 --- debug: Session Library initialized
2009-12-16 16:44:08 +00:00 --- debug: Auth Library loaded
2009-12-16 16:44:08 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:08 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:44:08 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:44:08 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:08 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:44:08 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:44:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:08 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:44:16 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:44:16 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:44:16 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:44:16 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:44:16 +00:00 --- debug: Database Library initialized
2009-12-16 16:44:16 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:16 +00:00 --- debug: Session Library initialized
2009-12-16 16:44:16 +00:00 --- debug: Auth Library loaded
2009-12-16 16:44:16 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:16 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:16 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:44:16 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:44:16 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:16 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:16 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:44:16 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:44:16 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:16 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:16 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:16 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:17 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:44:27 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:44:27 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:44:27 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:44:27 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:44:27 +00:00 --- debug: Database Library initialized
2009-12-16 16:44:27 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:27 +00:00 --- debug: Session Library initialized
2009-12-16 16:44:27 +00:00 --- debug: Auth Library loaded
2009-12-16 16:44:27 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:27 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:27 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:44:27 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:44:27 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:27 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:27 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:27 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:27 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:27 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:27 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'this is a test.' WHERE `id` = 2
2009-12-16 16:44:27 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:27 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:27 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:27 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:27 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:27 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:42 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:44:42 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:44:42 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:44:42 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:44:42 +00:00 --- debug: Database Library initialized
2009-12-16 16:44:42 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:42 +00:00 --- debug: Session Library initialized
2009-12-16 16:44:42 +00:00 --- debug: Auth Library loaded
2009-12-16 16:44:42 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:42 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:42 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:44:42 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:44:42 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:42 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:42 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:44:42 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:44:42 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:42 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:42 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:42 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:42 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:44:52 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:44:52 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:44:52 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:44:52 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:44:52 +00:00 --- debug: Database Library initialized
2009-12-16 16:44:52 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:52 +00:00 --- debug: Session Library initialized
2009-12-16 16:44:52 +00:00 --- debug: Auth Library loaded
2009-12-16 16:44:52 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:52 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:44:52 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:44:52 +00:00 --- debug: Loading module: navigation
2009-12-16 16:44:52 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:44:52 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:44:52 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:44:52 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:44:52 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:44:52 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:44:52 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:44:52 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:44:52 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:44:52 +00:00 --- debug: found resources for adminpage
2009-12-16 16:44:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:44:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:44:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:44:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:44:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:44:52 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:44:52 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:44:52 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:44:52 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:44:52 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:44:52 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:44:52 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:44:52 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:44:52 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:44:52 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:44:52 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:44:52 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:44:52 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:44:52 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:44:52 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:44:53 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:44:53 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:44:53 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:44:53 +00:00 --- debug: Database Library initialized
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:44:53 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:44:53 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:44:53 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:44:53 +00:00 --- debug: Database Library initialized
2009-12-16 16:44:53 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- debug: Session Library initialized
2009-12-16 16:44:53 +00:00 --- debug: Auth Library loaded
2009-12-16 16:44:53 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:44:53 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:44:53 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:44:53 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:53 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:44:59 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:44:59 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:44:59 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:44:59 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:44:59 +00:00 --- debug: Database Library initialized
2009-12-16 16:44:59 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:59 +00:00 --- debug: Session Library initialized
2009-12-16 16:44:59 +00:00 --- debug: Auth Library loaded
2009-12-16 16:44:59 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:59 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:59 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:44:59 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:44:59 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:59 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:59 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:44:59 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:44:59 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:59 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:59 +00:00 --- info: MY_ORM constructor
2009-12-16 16:44:59 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:44:59 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:45:00 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:45:00 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:45:00 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:45:00 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:45:00 +00:00 --- debug: Database Library initialized
2009-12-16 16:45:00 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:00 +00:00 --- debug: Session Library initialized
2009-12-16 16:45:00 +00:00 --- debug: Auth Library loaded
2009-12-16 16:45:00 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:00 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:00 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:45:00 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:45:00 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:00 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:00 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:45:00 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:45:00 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:00 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:00 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:00 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:00 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:45:03 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:45:03 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:45:03 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:45:03 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:45:03 +00:00 --- debug: Database Library initialized
2009-12-16 16:45:03 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:03 +00:00 --- debug: Session Library initialized
2009-12-16 16:45:03 +00:00 --- debug: Auth Library loaded
2009-12-16 16:45:03 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:03 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:45:03 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:45:03 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:03 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:45:03 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:45:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:03 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:03 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:03 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:45:30 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:45:30 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:45:30 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:45:30 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:45:30 +00:00 --- debug: Database Library initialized
2009-12-16 16:45:30 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:30 +00:00 --- debug: Session Library initialized
2009-12-16 16:45:30 +00:00 --- debug: Auth Library loaded
2009-12-16 16:45:30 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:30 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:45:30 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:45:30 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:30 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:45:30 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:45:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:30 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:30 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:30 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:45:30 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:45:30 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:45:30 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:45:30 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:45:30 +00:00 --- debug: Database Library initialized
2009-12-16 16:45:30 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:30 +00:00 --- debug: Session Library initialized
2009-12-16 16:45:30 +00:00 --- debug: Auth Library loaded
2009-12-16 16:45:30 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:30 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:45:30 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:45:30 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:30 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:45:30 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:45:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:30 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:30 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:30 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:45:32 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:45:32 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:45:32 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:45:32 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:45:32 +00:00 --- debug: Database Library initialized
2009-12-16 16:45:32 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:32 +00:00 --- debug: Session Library initialized
2009-12-16 16:45:32 +00:00 --- debug: Auth Library loaded
2009-12-16 16:45:32 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:32 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:32 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:45:32 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:45:32 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:32 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:32 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:45:32 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:45:32 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:32 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:32 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:32 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:32 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:45:39 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:45:39 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:45:39 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:45:39 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:45:39 +00:00 --- debug: Database Library initialized
2009-12-16 16:45:39 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:39 +00:00 --- debug: Session Library initialized
2009-12-16 16:45:39 +00:00 --- debug: Auth Library loaded
2009-12-16 16:45:39 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:39 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:39 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:45:39 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:45:39 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:39 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:39 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:45:39 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:45:39 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:39 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:39 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:39 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:39 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:45:45 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:45:45 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:45:45 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:45:45 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:45:45 +00:00 --- debug: Database Library initialized
2009-12-16 16:45:45 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:45 +00:00 --- debug: Session Library initialized
2009-12-16 16:45:45 +00:00 --- debug: Auth Library loaded
2009-12-16 16:45:45 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:45 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:45 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:45:45 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:45:45 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:45 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:45 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:45 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE  `slug` REGEXP '^mopuitests[0-9]*$'
ORDER BY `slug` ASC
2009-12-16 16:45:45 +00:00 --- info: UPDATE `pages` SET `slug` = 'mopuitests' WHERE `id` = 1
2009-12-16 16:45:45 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:45 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:45 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:45 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:45 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'MoP UI Tests' WHERE `id` = 1
2009-12-16 16:45:45 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:45 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:45 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:45 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:45 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:45 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:49 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:45:49 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:45:49 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:45:49 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:45:49 +00:00 --- debug: Database Library initialized
2009-12-16 16:45:49 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:49 +00:00 --- debug: Session Library initialized
2009-12-16 16:45:49 +00:00 --- debug: Auth Library loaded
2009-12-16 16:45:49 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:49 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:49 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:45:49 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:45:49 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:49 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:49 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:45:49 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:45:49 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:49 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:49 +00:00 --- info: MY_ORM constructor
2009-12-16 16:45:49 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:45:49 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:46:04 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:46:04 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:46:04 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:46:04 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:46:04 +00:00 --- debug: Database Library initialized
2009-12-16 16:46:04 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:04 +00:00 --- debug: Session Library initialized
2009-12-16 16:46:04 +00:00 --- debug: Auth Library loaded
2009-12-16 16:46:04 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:04 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:46:04 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:46:04 +00:00 --- debug: Loading module: navigation
2009-12-16 16:46:04 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:46:04 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:46:04 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:46:04 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:46:04 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:46:04 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:46:04 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:46:04 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:46:04 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:46:04 +00:00 --- debug: found resources for adminpage
2009-12-16 16:46:04 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:46:04 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:46:04 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:46:04 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:46:04 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:46:04 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:46:04 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:46:04 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:46:04 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:46:04 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:46:04 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:46:04 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:46:04 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:46:04 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:46:04 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:46:04 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:46:04 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:46:04 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:46:04 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:46:04 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:46:05 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:46:05 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:46:05 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:46:05 +00:00 --- debug: Database Library initialized
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:46:05 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:46:05 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:46:05 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:46:05 +00:00 --- debug: Database Library initialized
2009-12-16 16:46:05 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- debug: Session Library initialized
2009-12-16 16:46:05 +00:00 --- debug: Auth Library loaded
2009-12-16 16:46:05 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:46:05 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:46:05 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:46:05 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:05 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:05 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:46:10 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:46:10 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:46:10 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:46:10 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:46:10 +00:00 --- debug: Database Library initialized
2009-12-16 16:46:10 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:10 +00:00 --- debug: Session Library initialized
2009-12-16 16:46:10 +00:00 --- debug: Auth Library loaded
2009-12-16 16:46:10 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:10 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:10 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:46:10 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:46:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:10 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:10 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:46:10 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:46:10 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:10 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:10 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:46:23 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:46:23 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:46:23 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:46:23 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:46:23 +00:00 --- debug: Database Library initialized
2009-12-16 16:46:23 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:23 +00:00 --- debug: Session Library initialized
2009-12-16 16:46:23 +00:00 --- debug: Auth Library loaded
2009-12-16 16:46:23 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:23 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:46:23 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:46:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:23 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:23 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'test test test' WHERE `id` = 2
2009-12-16 16:46:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:23 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:46:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:46:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:47:29 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:47:29 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:47:29 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:47:29 +00:00 --- debug: Database Library initialized
2009-12-16 16:47:29 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- debug: Session Library initialized
2009-12-16 16:47:29 +00:00 --- debug: Auth Library loaded
2009-12-16 16:47:29 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:47:29 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:47:29 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:47:29 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:47:29 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:47:29 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:47:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:47:29 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:47:29 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:47:29 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:47:29 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:47:29 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:47:29 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:47:29 +00:00 --- debug: Database Library initialized
2009-12-16 16:47:29 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- debug: Session Library initialized
2009-12-16 16:47:29 +00:00 --- debug: Auth Library loaded
2009-12-16 16:47:29 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:47:29 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:47:29 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:47:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:47:29 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:47:29 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:47:29 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'test test test' WHERE `id` = 2
2009-12-16 16:47:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:47:29 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:47:29 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:47:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:47:29 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:54 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:51:54 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:51:54 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:51:54 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:51:54 +00:00 --- debug: Database Library initialized
2009-12-16 16:51:55 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:55 +00:00 --- debug: Session Library initialized
2009-12-16 16:51:55 +00:00 --- debug: Auth Library loaded
2009-12-16 16:51:55 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:55 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:55 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:51:55 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:51:55 +00:00 --- debug: Loading module: navigation
2009-12-16 16:51:55 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:51:55 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:51:55 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:51:55 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:51:55 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:51:55 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:51:55 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:51:55 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:51:55 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:51:55 +00:00 --- debug: found resources for adminpage
2009-12-16 16:51:55 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:51:55 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:51:55 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:51:55 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:51:55 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:51:55 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:51:55 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:51:55 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:51:55 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:51:55 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:51:55 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:51:55 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:51:55 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:51:55 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:51:55 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:51:55 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:51:55 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:51:55 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:51:55 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:51:55 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:51:56 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:51:56 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:51:56 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:51:56 +00:00 --- debug: Database Library initialized
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:51:56 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:51:56 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:51:56 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:51:56 +00:00 --- debug: Database Library initialized
2009-12-16 16:51:56 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- debug: Session Library initialized
2009-12-16 16:51:56 +00:00 --- debug: Auth Library loaded
2009-12-16 16:51:56 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:51:56 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:51:56 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:51:56 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:51:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:51:56 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:52:03 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:52:03 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:52:03 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:52:03 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:52:03 +00:00 --- debug: Database Library initialized
2009-12-16 16:52:03 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:03 +00:00 --- debug: Session Library initialized
2009-12-16 16:52:03 +00:00 --- debug: Auth Library loaded
2009-12-16 16:52:03 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:03 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:52:03 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:52:03 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:03 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:52:03 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:52:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:03 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:03 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:03 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:52:10 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:52:10 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:52:10 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:52:10 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:52:10 +00:00 --- debug: Database Library initialized
2009-12-16 16:52:10 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:10 +00:00 --- debug: Session Library initialized
2009-12-16 16:52:10 +00:00 --- debug: Auth Library loaded
2009-12-16 16:52:10 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:10 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:10 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:52:10 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:52:10 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:10 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:10 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:10 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'test test test' WHERE `id` = 2
2009-12-16 16:52:10 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:10 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:10 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:14 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:52:14 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:52:14 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:52:14 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:52:14 +00:00 --- debug: Database Library initialized
2009-12-16 16:52:14 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:14 +00:00 --- debug: Session Library initialized
2009-12-16 16:52:14 +00:00 --- debug: Auth Library loaded
2009-12-16 16:52:14 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:14 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:52:14 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:52:14 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:14 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:52:14 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:52:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:14 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:14 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:14 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:14 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:52:15 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:52:15 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:52:15 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:52:15 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:52:15 +00:00 --- debug: Database Library initialized
2009-12-16 16:52:15 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:15 +00:00 --- debug: Session Library initialized
2009-12-16 16:52:15 +00:00 --- debug: Auth Library loaded
2009-12-16 16:52:15 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:15 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:15 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:52:15 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:52:15 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:15 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:15 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:52:15 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:52:15 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:15 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:15 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:15 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:15 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:52:21 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:52:21 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:52:21 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:52:21 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:52:21 +00:00 --- debug: Database Library initialized
2009-12-16 16:52:21 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:21 +00:00 --- debug: Session Library initialized
2009-12-16 16:52:21 +00:00 --- debug: Auth Library loaded
2009-12-16 16:52:21 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:21 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:52:21 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:52:21 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:21 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:52:21 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:52:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:21 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:21 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:21 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:52:25 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:52:25 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:52:25 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:52:25 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:52:25 +00:00 --- debug: Database Library initialized
2009-12-16 16:52:25 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:25 +00:00 --- debug: Session Library initialized
2009-12-16 16:52:25 +00:00 --- debug: Auth Library loaded
2009-12-16 16:52:25 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:25 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:25 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:52:25 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:52:25 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:25 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:25 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:25 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE  `slug` REGEXP '^mopuitests[0-9]*$'
ORDER BY `slug` ASC
2009-12-16 16:52:25 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:25 +00:00 --- info: UPDATE `pages` SET `slug` = 'mopuitests1' WHERE `id` = 1
2009-12-16 16:52:25 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:25 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:25 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:25 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:25 +00:00 --- info: UPDATE `content_smalls` SET `title` = 'MoP UI Tests' WHERE `id` = 1
2009-12-16 16:52:25 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:25 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:25 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:25 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:25 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:25 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:29 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:52:29 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:52:29 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:52:29 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:52:29 +00:00 --- debug: Database Library initialized
2009-12-16 16:52:29 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:29 +00:00 --- debug: Session Library initialized
2009-12-16 16:52:29 +00:00 --- debug: Auth Library loaded
2009-12-16 16:52:29 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:29 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:52:29 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:52:29 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:29 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:52:29 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:52:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:29 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:29 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:29 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:52:30 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:52:30 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:52:30 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:52:30 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:52:30 +00:00 --- debug: Database Library initialized
2009-12-16 16:52:30 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:30 +00:00 --- debug: Session Library initialized
2009-12-16 16:52:30 +00:00 --- debug: Auth Library loaded
2009-12-16 16:52:30 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:30 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:52:30 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:52:30 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:30 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:52:30 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:52:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:30 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:52:30 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:52:30 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:53:29 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:53:29 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:53:29 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:53:29 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:53:29 +00:00 --- debug: Database Library initialized
2009-12-16 16:53:29 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:29 +00:00 --- debug: Session Library initialized
2009-12-16 16:53:29 +00:00 --- debug: Auth Library loaded
2009-12-16 16:53:29 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:29 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:29 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:53:29 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:53:29 +00:00 --- debug: Loading module: navigation
2009-12-16 16:53:29 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:53:29 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:53:29 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:53:29 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:53:29 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:53:29 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:53:29 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:53:29 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:53:29 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:53:29 +00:00 --- debug: found resources for adminpage
2009-12-16 16:53:29 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:53:29 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:53:29 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:53:29 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:53:29 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:53:29 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:53:29 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:53:29 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:53:29 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:53:29 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:53:29 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:53:29 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:53:29 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:53:29 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:53:29 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:53:29 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:53:29 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:53:29 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:53:29 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:53:29 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:53:30 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:53:30 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:53:30 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:53:30 +00:00 --- debug: Database Library initialized
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:53:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:53:30 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:04 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:54:04 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:54:04 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:54:04 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:54:04 +00:00 --- debug: Database Library initialized
2009-12-16 16:54:04 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:04 +00:00 --- debug: Session Library initialized
2009-12-16 16:54:04 +00:00 --- debug: Auth Library loaded
2009-12-16 16:54:04 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:04 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:54:04 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:54:04 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:04 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:54:04 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:54:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:04 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:04 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:04 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:54:04 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:54:04 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:54:04 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:54:04 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:54:04 +00:00 --- debug: Database Library initialized
2009-12-16 16:54:04 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:04 +00:00 --- debug: Session Library initialized
2009-12-16 16:54:04 +00:00 --- debug: Auth Library loaded
2009-12-16 16:54:04 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:04 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:54:04 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:54:04 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:04 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:54:04 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:54:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:04 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:04 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:04 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:04 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:54:07 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:54:07 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:54:07 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:54:07 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:54:07 +00:00 --- debug: Database Library initialized
2009-12-16 16:54:07 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:07 +00:00 --- debug: Session Library initialized
2009-12-16 16:54:07 +00:00 --- debug: Auth Library loaded
2009-12-16 16:54:07 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:07 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:07 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:54:07 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:54:07 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:07 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:07 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:54:07 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:54:07 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:07 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:07 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:07 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:07 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:54:25 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:54:25 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:54:25 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:54:25 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:54:25 +00:00 --- debug: Database Library initialized
2009-12-16 16:54:25 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:25 +00:00 --- debug: Session Library initialized
2009-12-16 16:54:25 +00:00 --- debug: Auth Library loaded
2009-12-16 16:54:25 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:25 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:25 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:54:25 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:54:25 +00:00 --- debug: Loading module: navigation
2009-12-16 16:54:25 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:54:25 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:54:25 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:54:25 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:54:25 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:54:25 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:54:25 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:54:25 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:54:25 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:54:25 +00:00 --- debug: found resources for adminpage
2009-12-16 16:54:25 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:54:25 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:54:25 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:54:25 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:54:25 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:54:25 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:54:25 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:54:25 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:54:25 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:54:25 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:54:25 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:54:25 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:54:25 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:54:25 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:54:25 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:54:25 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:54:25 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:54:25 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:54:25 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:54:25 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:54:26 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:54:26 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:54:26 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:54:26 +00:00 --- debug: Database Library initialized
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:26 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:26 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:30 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:54:30 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:54:30 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:54:30 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:54:30 +00:00 --- debug: Database Library initialized
2009-12-16 16:54:30 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:30 +00:00 --- debug: Session Library initialized
2009-12-16 16:54:30 +00:00 --- debug: Auth Library loaded
2009-12-16 16:54:30 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:30 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:30 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:54:30 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:54:30 +00:00 --- debug: Loading module: navigation
2009-12-16 16:54:30 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:54:30 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:54:30 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:54:30 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:54:30 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:54:30 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:54:30 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:54:30 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:54:30 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:54:30 +00:00 --- debug: found resources for adminpage
2009-12-16 16:54:30 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:54:30 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:54:30 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:54:30 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:54:30 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:54:30 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:54:30 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:54:30 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:54:30 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:54:30 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:54:30 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:54:30 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:54:30 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:54:30 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:54:30 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:54:30 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:54:30 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:54:30 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:54:30 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:54:30 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:54:31 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:54:31 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:54:31 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:54:31 +00:00 --- debug: Database Library initialized
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:31 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:35 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:54:35 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:54:35 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:54:35 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:54:35 +00:00 --- debug: Database Library initialized
2009-12-16 16:54:35 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:35 +00:00 --- debug: Session Library initialized
2009-12-16 16:54:35 +00:00 --- debug: Auth Library loaded
2009-12-16 16:54:35 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:35 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:54:35 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:54:35 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:35 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:54:35 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:54:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:35 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:54:36 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:54:36 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:54:36 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:54:36 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:54:36 +00:00 --- debug: Database Library initialized
2009-12-16 16:54:36 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:36 +00:00 --- debug: Session Library initialized
2009-12-16 16:54:36 +00:00 --- debug: Auth Library loaded
2009-12-16 16:54:36 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:36 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:36 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:54:36 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:54:36 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:36 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:36 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:54:36 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:54:36 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:36 +00:00 --- info: MY_ORM constructor
2009-12-16 16:54:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:54:36 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:55:34 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:55:34 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:55:34 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:55:34 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:55:34 +00:00 --- debug: Database Library initialized
2009-12-16 16:55:34 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:34 +00:00 --- debug: Session Library initialized
2009-12-16 16:55:34 +00:00 --- debug: Auth Library loaded
2009-12-16 16:55:34 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:34 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:55:34 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:55:34 +00:00 --- debug: Loading module: navigation
2009-12-16 16:55:34 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:55:34 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:55:34 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:55:34 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:55:34 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:55:34 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:55:34 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:55:34 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:55:34 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:55:34 +00:00 --- debug: found resources for adminpage
2009-12-16 16:55:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:55:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:55:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:55:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:55:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:55:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:55:34 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:55:34 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:55:34 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:55:34 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:55:34 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:55:34 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:55:34 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:55:34 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:55:34 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:55:34 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:55:34 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:55:34 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:55:34 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:55:34 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:55:35 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:55:35 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:55:35 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:55:35 +00:00 --- debug: Database Library initialized
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:35 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:57 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:55:57 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:55:57 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:55:57 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:55:57 +00:00 --- debug: Database Library initialized
2009-12-16 16:55:57 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:57 +00:00 --- debug: Session Library initialized
2009-12-16 16:55:57 +00:00 --- debug: Auth Library loaded
2009-12-16 16:55:57 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:57 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:57 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:55:57 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:55:57 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:57 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:57 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:55:57 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:55:57 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:57 +00:00 --- info: MY_ORM constructor
2009-12-16 16:55:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:55:57 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:56:22 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:56:22 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:56:22 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:56:22 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:56:22 +00:00 --- debug: Database Library initialized
2009-12-16 16:56:22 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:22 +00:00 --- debug: Session Library initialized
2009-12-16 16:56:22 +00:00 --- debug: Auth Library loaded
2009-12-16 16:56:22 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:22 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:22 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:56:22 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:56:22 +00:00 --- debug: Loading module: navigation
2009-12-16 16:56:22 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:56:22 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:56:22 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:56:22 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:56:22 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:56:22 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:56:22 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:56:22 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:56:22 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:56:22 +00:00 --- debug: found resources for adminpage
2009-12-16 16:56:22 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:56:22 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:56:22 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:56:22 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:56:22 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:56:22 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:56:22 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:56:22 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:56:22 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:56:22 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:56:22 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:56:22 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:56:22 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:56:22 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:56:22 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:56:22 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:56:22 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:56:22 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:56:22 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:56:22 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:56:23 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:56:23 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:56:23 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:56:23 +00:00 --- debug: Database Library initialized
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:23 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:56:34 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:56:34 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:56:34 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:56:34 +00:00 --- debug: Database Library initialized
2009-12-16 16:56:34 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- debug: Session Library initialized
2009-12-16 16:56:34 +00:00 --- debug: Auth Library loaded
2009-12-16 16:56:34 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:56:34 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:56:34 +00:00 --- debug: Loading module: navigation
2009-12-16 16:56:34 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:56:34 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:56:34 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:56:34 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:56:34 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:56:34 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:56:34 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:56:34 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:56:34 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:56:34 +00:00 --- debug: found resources for adminpage
2009-12-16 16:56:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:56:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:56:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:56:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:56:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:56:34 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:56:34 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:56:34 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:56:34 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:56:34 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:56:34 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:56:34 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:56:34 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:56:34 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:56:34 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:56:34 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:56:34 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:56:34 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:56:34 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:56:34 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:56:34 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:56:34 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:56:34 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:56:34 +00:00 --- debug: Database Library initialized
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:34 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:51 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:56:51 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:56:51 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:56:51 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:56:51 +00:00 --- debug: Database Library initialized
2009-12-16 16:56:51 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:51 +00:00 --- debug: Session Library initialized
2009-12-16 16:56:51 +00:00 --- debug: Auth Library loaded
2009-12-16 16:56:51 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:51 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:51 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:56:51 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:56:51 +00:00 --- debug: Loading module: navigation
2009-12-16 16:56:51 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:56:51 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:56:51 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:56:51 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:56:51 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:56:51 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:56:51 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:56:51 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:56:51 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:56:51 +00:00 --- debug: found resources for adminpage
2009-12-16 16:56:51 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:56:51 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:56:51 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:56:51 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:56:51 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:56:51 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:56:51 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:56:51 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:56:51 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:56:51 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:56:51 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:56:51 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:56:51 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:56:51 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:56:51 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:56:51 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:56:51 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:56:51 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:56:51 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:56:51 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:56:52 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:56:52 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:56:52 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:56:52 +00:00 --- debug: Database Library initialized
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:52 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:52 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:53 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:56:53 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:56:53 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:56:53 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:56:53 +00:00 --- debug: Database Library initialized
2009-12-16 16:56:53 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:53 +00:00 --- debug: Session Library initialized
2009-12-16 16:56:53 +00:00 --- debug: Auth Library loaded
2009-12-16 16:56:53 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:53 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:56:53 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:56:53 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:53 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:56:53 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:56:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:53 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:56:54 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:56:54 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:56:54 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:56:54 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:56:54 +00:00 --- debug: Database Library initialized
2009-12-16 16:56:54 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:54 +00:00 --- debug: Session Library initialized
2009-12-16 16:56:54 +00:00 --- debug: Auth Library loaded
2009-12-16 16:56:54 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:54 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:56:54 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:56:54 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:54 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:56:54 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:56:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:56:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:56:54 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:57:03 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:57:03 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:57:03 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:57:03 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:57:03 +00:00 --- debug: Database Library initialized
2009-12-16 16:57:03 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:03 +00:00 --- debug: Session Library initialized
2009-12-16 16:57:03 +00:00 --- debug: Auth Library loaded
2009-12-16 16:57:03 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:03 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:57:03 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:57:03 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:03 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:57:03 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:57:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:03 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:03 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:03 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:03 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:57:07 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:57:07 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:57:07 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:57:07 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:57:07 +00:00 --- debug: Database Library initialized
2009-12-16 16:57:07 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:07 +00:00 --- debug: Session Library initialized
2009-12-16 16:57:07 +00:00 --- debug: Auth Library loaded
2009-12-16 16:57:07 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:07 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:07 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:57:07 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:57:07 +00:00 --- debug: Loading module: navigation
2009-12-16 16:57:07 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:57:07 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:57:07 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:57:07 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:57:07 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:57:07 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:57:07 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:57:07 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:57:07 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:57:07 +00:00 --- debug: found resources for adminpage
2009-12-16 16:57:07 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:57:07 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:57:07 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:57:07 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:57:07 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:57:07 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:57:07 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:57:07 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:57:07 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:57:07 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:57:07 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:57:07 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:57:07 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:57:07 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:57:07 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:57:07 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:57:07 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:57:07 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:57:07 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:57:07 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:57:08 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:57:08 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:57:08 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:57:08 +00:00 --- debug: Database Library initialized
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:08 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:16 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:57:16 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:57:16 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:57:16 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:57:16 +00:00 --- debug: Database Library initialized
2009-12-16 16:57:16 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:16 +00:00 --- debug: Session Library initialized
2009-12-16 16:57:16 +00:00 --- debug: Auth Library loaded
2009-12-16 16:57:16 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:16 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:16 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:57:16 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:57:16 +00:00 --- debug: Loading module: navigation
2009-12-16 16:57:16 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:57:16 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:57:16 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:57:16 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:57:16 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:57:16 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:57:16 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:57:16 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:57:16 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:57:16 +00:00 --- debug: found resources for adminpage
2009-12-16 16:57:16 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:57:16 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:57:16 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:57:16 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:57:16 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:57:16 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:57:16 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:57:16 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:57:16 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:57:16 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:57:16 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:57:16 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:57:16 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:57:16 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:57:16 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:57:16 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:57:16 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:57:16 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:57:16 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:57:16 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:57:17 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:57:17 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:57:17 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:57:17 +00:00 --- debug: Database Library initialized
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:17 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:17 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:18 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:57:18 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:57:18 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:57:18 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:57:18 +00:00 --- debug: Database Library initialized
2009-12-16 16:57:18 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:18 +00:00 --- debug: Session Library initialized
2009-12-16 16:57:18 +00:00 --- debug: Auth Library loaded
2009-12-16 16:57:18 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:18 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:18 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:57:18 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:57:18 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:18 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:18 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:57:18 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:57:18 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:18 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:18 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:18 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:18 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:57:20 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:57:20 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:57:20 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:57:20 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:57:20 +00:00 --- debug: Database Library initialized
2009-12-16 16:57:20 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:20 +00:00 --- debug: Session Library initialized
2009-12-16 16:57:20 +00:00 --- debug: Auth Library loaded
2009-12-16 16:57:20 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:20 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:20 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:57:20 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:57:20 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:20 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:20 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:57:20 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:57:20 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:20 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:20 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:57:53 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:57:53 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:57:53 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:57:53 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:57:53 +00:00 --- debug: Database Library initialized
2009-12-16 16:57:53 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- debug: Session Library initialized
2009-12-16 16:57:53 +00:00 --- debug: Auth Library loaded
2009-12-16 16:57:53 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:57:53 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:57:53 +00:00 --- debug: Loading module: navigation
2009-12-16 16:57:53 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:57:53 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:57:53 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:57:53 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:57:53 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:57:53 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:57:53 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:57:53 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:57:53 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:57:53 +00:00 --- debug: found resources for adminpage
2009-12-16 16:57:53 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:57:53 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:57:53 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:57:53 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:57:53 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:57:53 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:57:53 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:57:53 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:57:53 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:57:53 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:57:53 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:57:53 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:57:53 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:57:53 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:57:53 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:57:53 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:57:53 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:57:53 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:57:53 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:57:53 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:57:53 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:57:53 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:57:53 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:57:53 +00:00 --- debug: Database Library initialized
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:57:53 +00:00 --- info: MY_ORM constructor
2009-12-16 16:57:53 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:21 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:58:21 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:58:21 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:58:21 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:58:21 +00:00 --- debug: Database Library initialized
2009-12-16 16:58:21 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:21 +00:00 --- debug: Session Library initialized
2009-12-16 16:58:21 +00:00 --- debug: Auth Library loaded
2009-12-16 16:58:21 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:21 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:58:21 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:58:21 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:21 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:58:21 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:58:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:21 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:21 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:21 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:58:37 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:58:37 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:58:37 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:58:37 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:58:37 +00:00 --- debug: Database Library initialized
2009-12-16 16:58:37 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- debug: Session Library initialized
2009-12-16 16:58:37 +00:00 --- debug: Auth Library loaded
2009-12-16 16:58:37 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:58:37 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:58:37 +00:00 --- debug: Loading module: navigation
2009-12-16 16:58:37 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:58:37 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:58:37 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:58:37 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:58:37 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:58:37 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:58:37 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:58:37 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:58:37 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:58:37 +00:00 --- debug: found resources for adminpage
2009-12-16 16:58:37 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:58:37 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:58:37 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:58:37 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:58:37 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:58:37 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:58:37 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:58:37 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:58:37 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:58:37 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:58:37 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:58:37 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:58:37 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:58:37 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:58:37 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:58:37 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:58:37 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:58:37 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:58:37 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:58:37 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:58:37 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:58:37 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:58:37 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:58:37 +00:00 --- debug: Database Library initialized
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:37 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:37 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:49 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:58:49 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:58:49 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:58:49 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:58:49 +00:00 --- debug: Database Library initialized
2009-12-16 16:58:49 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:49 +00:00 --- debug: Session Library initialized
2009-12-16 16:58:49 +00:00 --- debug: Auth Library loaded
2009-12-16 16:58:49 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:49 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:49 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:58:49 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:58:49 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:49 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:49 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:58:49 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:58:49 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:49 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:49 +00:00 --- info: MY_ORM constructor
2009-12-16 16:58:49 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:58:49 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:59:21 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:59:21 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:59:21 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:59:21 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:59:21 +00:00 --- debug: Database Library initialized
2009-12-16 16:59:21 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:21 +00:00 --- debug: Session Library initialized
2009-12-16 16:59:21 +00:00 --- debug: Auth Library loaded
2009-12-16 16:59:21 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:21 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:59:21 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:59:21 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:21 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:59:21 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:59:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:21 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:21 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:21 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:21 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:59:22 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:59:22 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:59:22 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:59:22 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:59:22 +00:00 --- debug: Database Library initialized
2009-12-16 16:59:22 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:22 +00:00 --- debug: Session Library initialized
2009-12-16 16:59:22 +00:00 --- debug: Auth Library loaded
2009-12-16 16:59:22 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:22 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:22 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:59:22 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:59:22 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:22 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:22 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:59:22 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:59:22 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:22 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:22 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:22 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:59:54 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:59:54 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:59:54 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:59:54 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:59:54 +00:00 --- debug: Database Library initialized
2009-12-16 16:59:54 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- debug: Session Library initialized
2009-12-16 16:59:54 +00:00 --- debug: Auth Library loaded
2009-12-16 16:59:54 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:59:54 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:59:54 +00:00 --- debug: Loading module: navigation
2009-12-16 16:59:54 +00:00 --- debug: Loading controller: navigation
2009-12-16 16:59:54 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 16:59:54 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 16:59:54 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 16:59:54 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 16:59:54 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 16:59:54 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:59:54 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:59:54 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 16:59:54 +00:00 --- debug: found resources for adminpage
2009-12-16 16:59:54 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 16:59:54 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 16:59:54 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 16:59:54 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 16:59:54 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 16:59:54 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 16:59:54 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 16:59:54 +00:00 --- debug: Loading module: adminheader
2009-12-16 16:59:54 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 16:59:54 +00:00 --- debug: Loading module: mop_auth
2009-12-16 16:59:54 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 16:59:54 +00:00 --- debug: Loading module: adminfooter
2009-12-16 16:59:54 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 16:59:54 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 16:59:54 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 16:59:54 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 16:59:54 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 16:59:54 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 16:59:54 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 16:59:54 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 16:59:54 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:59:54 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:59:54 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:59:54 +00:00 --- debug: Database Library initialized
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:54 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:55 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:59:55 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:59:55 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:59:55 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:59:55 +00:00 --- debug: Database Library initialized
2009-12-16 16:59:55 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:55 +00:00 --- debug: Session Library initialized
2009-12-16 16:59:55 +00:00 --- debug: Auth Library loaded
2009-12-16 16:59:55 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:55 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:55 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:59:55 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:59:55 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:55 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:55 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:59:55 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:59:55 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:55 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:55 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:55 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:55 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:59:56 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:59:56 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:59:56 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:59:56 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:59:56 +00:00 --- debug: Database Library initialized
2009-12-16 16:59:56 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:56 +00:00 --- debug: Session Library initialized
2009-12-16 16:59:56 +00:00 --- debug: Auth Library loaded
2009-12-16 16:59:56 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:56 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:59:56 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:59:56 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:56 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:59:56 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:59:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:56 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:56 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:59:57 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:59:57 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:59:57 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:59:57 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:59:57 +00:00 --- debug: Database Library initialized
2009-12-16 16:59:57 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:57 +00:00 --- debug: Session Library initialized
2009-12-16 16:59:57 +00:00 --- debug: Auth Library loaded
2009-12-16 16:59:57 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:57 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:57 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:59:57 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:59:57 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:57 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:57 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:59:57 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:59:57 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:57 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:57 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:59:58 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:59:58 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:59:58 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:59:58 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:59:58 +00:00 --- debug: Database Library initialized
2009-12-16 16:59:58 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:58 +00:00 --- debug: Session Library initialized
2009-12-16 16:59:58 +00:00 --- debug: Auth Library loaded
2009-12-16 16:59:58 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:58 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:59:58 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:59:58 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:58 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 16:59:58 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 16:59:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:58 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:58 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 16:59:59 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 16:59:59 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 16:59:59 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 16:59:59 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 16:59:59 +00:00 --- debug: Database Library initialized
2009-12-16 16:59:59 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:59 +00:00 --- debug: Session Library initialized
2009-12-16 16:59:59 +00:00 --- debug: Auth Library loaded
2009-12-16 16:59:59 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:59 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:59 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 16:59:59 +00:00 --- info: cms needs to choose navigation module
2009-12-16 16:59:59 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:59 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:59 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:59 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:59 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:59 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:59 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'test test test' WHERE `id` = 2
2009-12-16 16:59:59 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:59 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:59 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:59 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 16:59:59 +00:00 --- info: MY_ORM constructor
2009-12-16 16:59:59 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:20 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:20 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:00:20 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:20 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:20 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- debug: Session Library initialized
2009-12-16 17:00:20 +00:00 --- debug: Auth Library loaded
2009-12-16 17:00:20 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:00:20 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:00:20 +00:00 --- debug: Loading module: navigation
2009-12-16 17:00:20 +00:00 --- debug: Loading controller: navigation
2009-12-16 17:00:20 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 17:00:20 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 17:00:20 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 17:00:20 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 17:00:20 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 17:00:20 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:00:20 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:00:20 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 17:00:20 +00:00 --- debug: found resources for adminpage
2009-12-16 17:00:20 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 17:00:20 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 17:00:20 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 17:00:20 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 17:00:20 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 17:00:20 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 17:00:20 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 17:00:20 +00:00 --- debug: Loading module: adminheader
2009-12-16 17:00:20 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 17:00:20 +00:00 --- debug: Loading module: mop_auth
2009-12-16 17:00:20 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 17:00:20 +00:00 --- debug: Loading module: adminfooter
2009-12-16 17:00:20 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 17:00:20 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:00:20 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:00:20 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 17:00:20 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 17:00:20 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 17:00:20 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 17:00:20 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 17:00:20 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:20 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:20 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:20 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:22 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:22 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:22 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:00:22 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:22 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:22 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:22 +00:00 --- debug: Session Library initialized
2009-12-16 17:00:22 +00:00 --- debug: Auth Library loaded
2009-12-16 17:00:22 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:22 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:00:22 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:00:22 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:22 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:00:22 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:00:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:22 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:22 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:00:23 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:23 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:23 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:00:23 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:23 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:23 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:23 +00:00 --- debug: Session Library initialized
2009-12-16 17:00:23 +00:00 --- debug: Auth Library loaded
2009-12-16 17:00:23 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:23 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:00:23 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:00:23 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:23 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:00:23 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:00:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:23 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:00:23 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:23 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:23 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:00:23 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:23 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:23 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:23 +00:00 --- debug: Session Library initialized
2009-12-16 17:00:23 +00:00 --- debug: Auth Library loaded
2009-12-16 17:00:23 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:23 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:00:23 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:00:23 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:23 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:00:23 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:00:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:23 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:00:24 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:24 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:24 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:00:24 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:24 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:24 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:24 +00:00 --- debug: Session Library initialized
2009-12-16 17:00:24 +00:00 --- debug: Auth Library loaded
2009-12-16 17:00:24 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:24 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:00:24 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:00:24 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:24 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:00:24 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:00:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:24 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:24 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:24 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:00:25 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:25 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:25 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:00:25 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:25 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:25 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:25 +00:00 --- debug: Session Library initialized
2009-12-16 17:00:25 +00:00 --- debug: Auth Library loaded
2009-12-16 17:00:25 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:25 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:00:25 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:00:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:25 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:25 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:25 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:25 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'test test test' WHERE `id` = 2
2009-12-16 17:00:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:25 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:25 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:25 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:35 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:35 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:00:35 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:35 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:35 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- debug: Session Library initialized
2009-12-16 17:00:35 +00:00 --- debug: Auth Library loaded
2009-12-16 17:00:35 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:00:35 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:00:35 +00:00 --- debug: Loading module: navigation
2009-12-16 17:00:35 +00:00 --- debug: Loading controller: navigation
2009-12-16 17:00:35 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 17:00:35 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 17:00:35 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 17:00:35 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 17:00:35 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 17:00:35 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:00:35 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:00:35 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 17:00:35 +00:00 --- debug: found resources for adminpage
2009-12-16 17:00:35 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 17:00:35 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 17:00:35 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 17:00:35 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 17:00:35 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 17:00:35 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 17:00:35 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 17:00:35 +00:00 --- debug: Loading module: adminheader
2009-12-16 17:00:35 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 17:00:35 +00:00 --- debug: Loading module: mop_auth
2009-12-16 17:00:35 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 17:00:35 +00:00 --- debug: Loading module: adminfooter
2009-12-16 17:00:35 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 17:00:35 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:00:35 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:00:35 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 17:00:35 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 17:00:35 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 17:00:35 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 17:00:35 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 17:00:35 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:35 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:35 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:35 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:37 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:37 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:37 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:00:37 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:37 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:37 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:37 +00:00 --- debug: Session Library initialized
2009-12-16 17:00:37 +00:00 --- debug: Auth Library loaded
2009-12-16 17:00:37 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:37 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:00:37 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:00:37 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:37 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:00:37 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:00:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:37 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:37 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:37 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:00:38 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:38 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:38 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:00:38 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:38 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:38 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:38 +00:00 --- debug: Session Library initialized
2009-12-16 17:00:38 +00:00 --- debug: Auth Library loaded
2009-12-16 17:00:38 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:38 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:38 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:00:38 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:00:38 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:38 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:38 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:00:38 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:00:38 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:38 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:38 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:38 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:38 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:00:44 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:00:44 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:00:44 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:00:44 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:00:44 +00:00 --- debug: Database Library initialized
2009-12-16 17:00:44 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:44 +00:00 --- debug: Session Library initialized
2009-12-16 17:00:44 +00:00 --- debug: Auth Library loaded
2009-12-16 17:00:44 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:44 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:44 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:00:44 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:00:44 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:44 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:45 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:45 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:45 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:45 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:45 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'test test test' WHERE `id` = 2
2009-12-16 17:00:45 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:45 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:45 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:45 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:00:45 +00:00 --- info: MY_ORM constructor
2009-12-16 17:00:45 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:19 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:01:19 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:01:19 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:01:19 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:01:19 +00:00 --- debug: Database Library initialized
2009-12-16 17:01:19 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:19 +00:00 --- debug: Session Library initialized
2009-12-16 17:01:19 +00:00 --- debug: Auth Library loaded
2009-12-16 17:01:19 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:19 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:01:19 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:01:19 +00:00 --- debug: Loading module: navigation
2009-12-16 17:01:19 +00:00 --- debug: Loading controller: navigation
2009-12-16 17:01:19 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 17:01:19 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 17:01:19 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 17:01:19 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 17:01:19 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 17:01:19 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:01:19 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:01:19 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 17:01:19 +00:00 --- debug: found resources for adminpage
2009-12-16 17:01:19 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 17:01:19 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 17:01:19 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 17:01:19 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 17:01:19 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 17:01:19 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 17:01:19 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 17:01:19 +00:00 --- debug: Loading module: adminheader
2009-12-16 17:01:19 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 17:01:19 +00:00 --- debug: Loading module: mop_auth
2009-12-16 17:01:19 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 17:01:19 +00:00 --- debug: Loading module: adminfooter
2009-12-16 17:01:19 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 17:01:19 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:01:19 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:01:19 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 17:01:19 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 17:01:19 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 17:01:19 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 17:01:19 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 17:01:20 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:01:20 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:01:20 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:01:20 +00:00 --- debug: Database Library initialized
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:22 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:01:22 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:01:22 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:01:22 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:01:22 +00:00 --- debug: Database Library initialized
2009-12-16 17:01:22 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:22 +00:00 --- debug: Session Library initialized
2009-12-16 17:01:22 +00:00 --- debug: Auth Library loaded
2009-12-16 17:01:22 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:22 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:01:22 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:01:22 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:22 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:01:22 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:01:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:22 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:22 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:01:25 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:01:25 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:01:25 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:01:25 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:01:25 +00:00 --- debug: Database Library initialized
2009-12-16 17:01:25 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:25 +00:00 --- debug: Session Library initialized
2009-12-16 17:01:25 +00:00 --- debug: Auth Library loaded
2009-12-16 17:01:25 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:25 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:01:25 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:01:25 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:25 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:01:25 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:01:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:25 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:25 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:25 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:01:31 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:01:31 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:01:31 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:01:31 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:01:31 +00:00 --- debug: Database Library initialized
2009-12-16 17:01:31 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:31 +00:00 --- debug: Session Library initialized
2009-12-16 17:01:31 +00:00 --- debug: Auth Library loaded
2009-12-16 17:01:31 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:31 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:01:31 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:01:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:31 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:31 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'test test test' WHERE `id` = 2
2009-12-16 17:01:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:31 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:01:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:01:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:02:31 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:02:31 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:02:31 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:02:31 +00:00 --- debug: Database Library initialized
2009-12-16 17:02:31 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- debug: Session Library initialized
2009-12-16 17:02:31 +00:00 --- debug: Auth Library loaded
2009-12-16 17:02:31 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:02:31 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:02:31 +00:00 --- debug: Loading module: navigation
2009-12-16 17:02:31 +00:00 --- debug: Loading controller: navigation
2009-12-16 17:02:31 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 17:02:31 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 17:02:31 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 17:02:31 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 17:02:31 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 17:02:31 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:02:31 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:02:31 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 17:02:31 +00:00 --- debug: found resources for adminpage
2009-12-16 17:02:31 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 17:02:31 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 17:02:31 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 17:02:31 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 17:02:31 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 17:02:31 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 17:02:31 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 17:02:31 +00:00 --- debug: Loading module: adminheader
2009-12-16 17:02:31 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 17:02:31 +00:00 --- debug: Loading module: mop_auth
2009-12-16 17:02:31 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 17:02:31 +00:00 --- debug: Loading module: adminfooter
2009-12-16 17:02:31 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 17:02:31 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:02:31 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:02:31 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 17:02:31 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 17:02:31 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 17:02:31 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 17:02:31 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 17:02:31 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:02:31 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:02:31 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:02:31 +00:00 --- debug: Database Library initialized
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:38 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:02:38 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:02:38 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:02:38 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:02:38 +00:00 --- debug: Database Library initialized
2009-12-16 17:02:38 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:38 +00:00 --- debug: Session Library initialized
2009-12-16 17:02:38 +00:00 --- debug: Auth Library loaded
2009-12-16 17:02:38 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:38 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:38 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:02:38 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:02:38 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:38 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:38 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:02:38 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:02:38 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:38 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:38 +00:00 --- info: MY_ORM constructor
2009-12-16 17:02:38 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:02:38 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:03:36 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:03:36 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:03:36 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:03:36 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:03:36 +00:00 --- debug: Database Library initialized
2009-12-16 17:03:36 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:36 +00:00 --- debug: Session Library initialized
2009-12-16 17:03:36 +00:00 --- debug: Auth Library loaded
2009-12-16 17:03:36 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:36 +00:00 --- info: MY_ORM constructor
2009-12-16 17:03:36 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:03:36 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:03:36 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:36 +00:00 --- info: MY_ORM constructor
2009-12-16 17:03:36 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:03:36 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:03:36 +00:00 --- info: MY_ORM constructor
2009-12-16 17:03:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:36 +00:00 --- info: MY_ORM constructor
2009-12-16 17:03:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:36 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:03:39 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:03:39 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:03:39 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:03:39 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:03:39 +00:00 --- debug: Database Library initialized
2009-12-16 17:03:39 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:39 +00:00 --- debug: Session Library initialized
2009-12-16 17:03:39 +00:00 --- debug: Auth Library loaded
2009-12-16 17:03:39 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:39 +00:00 --- info: MY_ORM constructor
2009-12-16 17:03:39 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:03:39 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:03:39 +00:00 --- info: MY_ORM constructor
2009-12-16 17:03:39 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:39 +00:00 --- info: MY_ORM constructor
2009-12-16 17:03:39 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:39 +00:00 --- info: MY_ORM constructor
2009-12-16 17:03:39 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:39 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'Array' WHERE `id` = 3
2009-12-16 17:03:39 +00:00 --- info: MY_ORM constructor
2009-12-16 17:03:39 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:39 +00:00 --- info: MY_ORM constructor
2009-12-16 17:03:39 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:03:39 +00:00 --- info: MY_ORM constructor
2009-12-16 17:03:39 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:21 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:05:21 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:05:21 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:05:21 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:05:21 +00:00 --- debug: Database Library initialized
2009-12-16 17:05:21 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:21 +00:00 --- debug: Session Library initialized
2009-12-16 17:05:21 +00:00 --- debug: Auth Library loaded
2009-12-16 17:05:21 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:05:21 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:05:21 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:05:21 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:05:21 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:05:21 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:05:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:05:21 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:05:21 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:21 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:05:22 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:05:22 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:05:22 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:05:22 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:05:22 +00:00 --- debug: Database Library initialized
2009-12-16 17:05:22 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:22 +00:00 --- debug: Session Library initialized
2009-12-16 17:05:22 +00:00 --- debug: Auth Library loaded
2009-12-16 17:05:22 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:05:22 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:05:22 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:05:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:05:22 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:05:22 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:05:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:22 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'Array' WHERE `id` = 3
2009-12-16 17:05:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:05:22 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:05:22 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:05:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:05:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:04 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:06:04 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:06:04 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:06:04 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:06:04 +00:00 --- debug: Database Library initialized
2009-12-16 17:06:04 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:04 +00:00 --- debug: Session Library initialized
2009-12-16 17:06:04 +00:00 --- debug: Auth Library loaded
2009-12-16 17:06:04 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:04 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:06:04 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:06:04 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:04 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:06:04 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:06:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:04 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:04 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:04 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:06:08 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:06:08 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:06:08 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:06:08 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:06:08 +00:00 --- debug: Database Library initialized
2009-12-16 17:06:08 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:08 +00:00 --- debug: Session Library initialized
2009-12-16 17:06:08 +00:00 --- debug: Auth Library loaded
2009-12-16 17:06:08 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:08 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:06:08 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:06:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:08 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:08 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '0' WHERE `id` = 4
2009-12-16 17:06:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:08 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:11 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:06:11 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:06:11 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:06:12 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:06:12 +00:00 --- debug: Database Library initialized
2009-12-16 17:06:12 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:12 +00:00 --- debug: Session Library initialized
2009-12-16 17:06:12 +00:00 --- debug: Auth Library loaded
2009-12-16 17:06:12 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:12 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:12 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:06:12 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:06:12 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:12 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:12 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:12 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:12 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:12 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:12 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '1' WHERE `id` = 4
2009-12-16 17:06:12 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:12 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:12 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:12 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:12 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:12 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:56 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:06:56 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:06:56 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:06:56 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:06:56 +00:00 --- debug: Database Library initialized
2009-12-16 17:06:56 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:56 +00:00 --- debug: Session Library initialized
2009-12-16 17:06:56 +00:00 --- debug: Auth Library loaded
2009-12-16 17:06:56 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:56 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:06:56 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:06:56 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:56 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:06:56 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:06:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:06:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:06:56 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:15:06 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:15:06 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:15:06 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:15:06 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:15:06 +00:00 --- debug: Database Library initialized
2009-12-16 17:15:06 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- debug: Session Library initialized
2009-12-16 17:15:06 +00:00 --- debug: Auth Library loaded
2009-12-16 17:15:06 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:06 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:15:06 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:15:06 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:06 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:15:06 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:15:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:06 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:06 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:15:06 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:15:06 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:15:06 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:15:06 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:15:06 +00:00 --- debug: Database Library initialized
2009-12-16 17:15:06 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- debug: Session Library initialized
2009-12-16 17:15:06 +00:00 --- debug: Auth Library loaded
2009-12-16 17:15:06 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:06 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:15:06 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:15:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:06 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:06 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:06 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '0' WHERE `id` = 4
2009-12-16 17:15:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:06 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:06 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:06 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:54 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:15:54 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:15:54 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:15:54 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:15:54 +00:00 --- debug: Database Library initialized
2009-12-16 17:15:54 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:54 +00:00 --- debug: Session Library initialized
2009-12-16 17:15:54 +00:00 --- debug: Auth Library loaded
2009-12-16 17:15:54 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:54 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:54 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:15:54 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:15:54 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:54 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:54 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:15:54 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:15:54 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:54 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:54 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:54 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:54 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:15:56 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:15:56 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:15:56 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:15:56 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:15:56 +00:00 --- debug: Database Library initialized
2009-12-16 17:15:56 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:56 +00:00 --- debug: Session Library initialized
2009-12-16 17:15:56 +00:00 --- debug: Auth Library loaded
2009-12-16 17:15:56 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:56 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:15:56 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:15:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:56 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:56 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '1' WHERE `id` = 4
2009-12-16 17:15:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:56 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:15:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:15:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:26 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:16:26 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:16:26 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:16:26 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:16:26 +00:00 --- debug: Database Library initialized
2009-12-16 17:16:26 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:26 +00:00 --- debug: Session Library initialized
2009-12-16 17:16:26 +00:00 --- debug: Auth Library loaded
2009-12-16 17:16:26 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:26 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:26 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:16:26 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:16:26 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:26 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:26 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:26 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:26 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:26 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:26 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '0' WHERE `id` = 4
2009-12-16 17:16:26 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:26 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:26 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:26 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:26 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:26 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:32 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:16:32 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:16:32 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:16:32 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:16:32 +00:00 --- debug: Database Library initialized
2009-12-16 17:16:32 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:32 +00:00 --- debug: Session Library initialized
2009-12-16 17:16:32 +00:00 --- debug: Auth Library loaded
2009-12-16 17:16:32 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:32 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:32 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:16:32 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:16:32 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:32 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:32 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:16:32 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:16:32 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:32 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:32 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:32 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:32 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:16:34 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:16:34 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:16:34 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:16:34 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:16:34 +00:00 --- debug: Database Library initialized
2009-12-16 17:16:34 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:34 +00:00 --- debug: Session Library initialized
2009-12-16 17:16:34 +00:00 --- debug: Auth Library loaded
2009-12-16 17:16:34 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:34 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:34 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:16:34 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:16:34 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:34 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:34 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:34 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:34 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '1' WHERE `id` = 4
2009-12-16 17:16:34 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:34 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:34 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:34 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:34 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:34 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:57 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:16:57 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:16:57 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:16:57 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:16:57 +00:00 --- debug: Database Library initialized
2009-12-16 17:16:57 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:57 +00:00 --- debug: Session Library initialized
2009-12-16 17:16:57 +00:00 --- debug: Auth Library loaded
2009-12-16 17:16:57 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:57 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:57 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:16:57 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:16:57 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:57 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:57 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:16:57 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:16:57 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:57 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:57 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:16:58 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:16:58 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:16:58 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:16:58 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:16:58 +00:00 --- debug: Database Library initialized
2009-12-16 17:16:58 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:58 +00:00 --- debug: Session Library initialized
2009-12-16 17:16:58 +00:00 --- debug: Auth Library loaded
2009-12-16 17:16:58 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:58 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:58 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:16:58 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:16:58 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:58 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:58 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:58 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:58 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '0' WHERE `id` = 4
2009-12-16 17:16:58 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:58 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:58 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:58 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:16:58 +00:00 --- info: MY_ORM constructor
2009-12-16 17:16:58 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:00 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:17:00 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:17:00 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:17:00 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:17:00 +00:00 --- debug: Database Library initialized
2009-12-16 17:17:00 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:00 +00:00 --- debug: Session Library initialized
2009-12-16 17:17:00 +00:00 --- debug: Auth Library loaded
2009-12-16 17:17:00 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:00 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:00 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:17:00 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:17:00 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:00 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:00 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:00 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:00 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:00 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:00 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '1' WHERE `id` = 4
2009-12-16 17:17:00 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:00 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:00 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:00 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:00 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:00 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:08 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:17:08 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:17:08 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:17:08 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:17:08 +00:00 --- debug: Database Library initialized
2009-12-16 17:17:08 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:08 +00:00 --- debug: Session Library initialized
2009-12-16 17:17:08 +00:00 --- debug: Auth Library loaded
2009-12-16 17:17:08 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:08 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:17:08 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:17:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:08 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:08 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '0' WHERE `id` = 4
2009-12-16 17:17:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:08 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:10 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:17:10 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:17:10 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:17:10 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:17:10 +00:00 --- debug: Database Library initialized
2009-12-16 17:17:10 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:10 +00:00 --- debug: Session Library initialized
2009-12-16 17:17:10 +00:00 --- debug: Auth Library loaded
2009-12-16 17:17:10 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:10 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:17:10 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:17:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:10 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '1' WHERE `id` = 4
2009-12-16 17:17:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:17:11 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:17:11 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:17:11 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:17:11 +00:00 --- debug: Database Library initialized
2009-12-16 17:17:11 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- debug: Session Library initialized
2009-12-16 17:17:11 +00:00 --- debug: Auth Library loaded
2009-12-16 17:17:11 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:17:11 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '0' WHERE `id` = 4
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:17:11 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:17:11 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:17:11 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:17:11 +00:00 --- debug: Database Library initialized
2009-12-16 17:17:11 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- debug: Session Library initialized
2009-12-16 17:17:11 +00:00 --- debug: Auth Library loaded
2009-12-16 17:17:11 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:17:11 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '1' WHERE `id` = 4
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:11 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:14 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:17:14 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:17:14 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:17:14 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:17:14 +00:00 --- debug: Database Library initialized
2009-12-16 17:17:14 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:14 +00:00 --- debug: Session Library initialized
2009-12-16 17:17:14 +00:00 --- debug: Auth Library loaded
2009-12-16 17:17:14 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:14 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:14 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:17:14 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:17:14 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:14 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:14 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:14 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:14 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:14 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:14 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '0' WHERE `id` = 4
2009-12-16 17:17:14 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:14 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:14 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:14 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:14 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:14 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:18 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:17:18 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:17:18 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:17:18 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:17:18 +00:00 --- debug: Database Library initialized
2009-12-16 17:17:18 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:18 +00:00 --- debug: Session Library initialized
2009-12-16 17:17:18 +00:00 --- debug: Auth Library loaded
2009-12-16 17:17:18 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:18 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:18 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:17:18 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:17:18 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:18 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:18 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:17:18 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:17:18 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:18 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:18 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:18 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:18 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:17:20 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:17:20 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:17:20 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:17:20 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:17:20 +00:00 --- debug: Database Library initialized
2009-12-16 17:17:20 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:20 +00:00 --- debug: Session Library initialized
2009-12-16 17:17:20 +00:00 --- debug: Auth Library loaded
2009-12-16 17:17:20 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:20 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:17:20 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:17:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:20 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:20 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '1' WHERE `id` = 4
2009-12-16 17:17:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:20 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:24 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:17:24 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:17:24 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:17:24 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:17:24 +00:00 --- debug: Database Library initialized
2009-12-16 17:17:24 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:24 +00:00 --- debug: Session Library initialized
2009-12-16 17:17:24 +00:00 --- debug: Auth Library loaded
2009-12-16 17:17:24 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:24 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:17:24 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:17:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:24 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:24 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:24 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:24 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '0' WHERE `id` = 4
2009-12-16 17:17:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:24 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:24 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:17:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:17:24 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:09 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:18:09 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:18:09 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:18:09 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:18:09 +00:00 --- debug: Database Library initialized
2009-12-16 17:18:09 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:09 +00:00 --- debug: Session Library initialized
2009-12-16 17:18:09 +00:00 --- debug: Auth Library loaded
2009-12-16 17:18:09 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:09 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:09 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:18:09 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:18:09 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:09 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:09 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:18:09 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:18:09 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:09 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:09 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:09 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:09 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:18:10 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:18:10 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:18:10 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:18:10 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:18:10 +00:00 --- debug: Database Library initialized
2009-12-16 17:18:10 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:10 +00:00 --- debug: Session Library initialized
2009-12-16 17:18:10 +00:00 --- debug: Auth Library loaded
2009-12-16 17:18:10 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:10 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:18:10 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:18:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:10 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'Array' WHERE `id` = 3
2009-12-16 17:18:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:13 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:18:13 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:18:13 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:18:13 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:18:13 +00:00 --- debug: Database Library initialized
2009-12-16 17:18:13 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:13 +00:00 --- debug: Session Library initialized
2009-12-16 17:18:13 +00:00 --- debug: Auth Library loaded
2009-12-16 17:18:13 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:13 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:13 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:18:13 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:18:13 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:13 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:13 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:18:13 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:18:13 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:13 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:13 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:13 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:13 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:18:14 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:18:14 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:18:14 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:18:14 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:18:14 +00:00 --- debug: Database Library initialized
2009-12-16 17:18:14 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:14 +00:00 --- debug: Session Library initialized
2009-12-16 17:18:14 +00:00 --- debug: Auth Library loaded
2009-12-16 17:18:14 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:14 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:14 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:18:14 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:18:14 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:14 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:14 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:18:14 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:18:14 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:14 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:14 +00:00 --- info: MY_ORM constructor
2009-12-16 17:18:14 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:18:14 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:19:11 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:19:11 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:19:11 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:19:11 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:19:11 +00:00 --- debug: Database Library initialized
2009-12-16 17:19:11 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:19:11 +00:00 --- debug: Session Library initialized
2009-12-16 17:19:11 +00:00 --- debug: Auth Library loaded
2009-12-16 17:19:11 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:19:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:19:11 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:19:11 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:19:11 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:19:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:19:11 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:19:11 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:19:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:19:11 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:19:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:19:11 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:19:11 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:25:32 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:25:32 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:25:32 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:25:32 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:25:32 +00:00 --- debug: Database Library initialized
2009-12-16 17:25:32 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:25:32 +00:00 --- debug: Session Library initialized
2009-12-16 17:25:32 +00:00 --- debug: Auth Library loaded
2009-12-16 17:25:32 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:25:32 +00:00 --- info: MY_ORM constructor
2009-12-16 17:25:32 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:25:32 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:25:32 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:25:32 +00:00 --- info: MY_ORM constructor
2009-12-16 17:25:32 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:25:32 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:25:32 +00:00 --- info: MY_ORM constructor
2009-12-16 17:25:32 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:25:32 +00:00 --- info: MY_ORM constructor
2009-12-16 17:25:32 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:25:32 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:25:35 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:25:35 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:25:35 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:25:35 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:25:35 +00:00 --- debug: Database Library initialized
2009-12-16 17:25:35 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:25:35 +00:00 --- debug: Session Library initialized
2009-12-16 17:25:35 +00:00 --- debug: Auth Library loaded
2009-12-16 17:25:35 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:25:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:25:35 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:25:35 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:25:35 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:25:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:25:35 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:25:35 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:25:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:25:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:25:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:25:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:25:35 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:26:02 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:02 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:02 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:02 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:02 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:02 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:02 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:02 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:02 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:02 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:02 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:02 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'nope' WHERE `id` = 2
2009-12-16 17:26:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:21 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:21 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:21 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:21 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:21 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:21 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:21 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:21 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:21 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:21 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:21 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:21 +00:00 --- debug: Loading module: navigation
2009-12-16 17:26:21 +00:00 --- debug: Loading controller: navigation
2009-12-16 17:26:21 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 17:26:21 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 17:26:21 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 17:26:21 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 17:26:21 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 17:26:21 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:26:21 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:26:21 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 17:26:21 +00:00 --- debug: found resources for adminpage
2009-12-16 17:26:21 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 17:26:21 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 17:26:21 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 17:26:21 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 17:26:21 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 17:26:21 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 17:26:21 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 17:26:21 +00:00 --- debug: Loading module: adminheader
2009-12-16 17:26:21 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 17:26:21 +00:00 --- debug: Loading module: mop_auth
2009-12-16 17:26:21 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 17:26:21 +00:00 --- debug: Loading module: adminfooter
2009-12-16 17:26:21 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 17:26:21 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:26:21 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:26:21 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 17:26:21 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 17:26:21 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 17:26:21 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 17:26:21 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 17:26:21 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:21 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:21 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:21 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:21 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:26:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:21 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:23 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:23 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:23 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:23 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:23 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:23 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:23 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:23 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:23 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:23 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:23 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:23 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:23 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:26:23 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:26:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:23 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:23 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:23 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:23 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:26:24 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:24 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:24 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:24 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:24 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:24 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:24 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:24 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:24 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:24 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:24 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:24 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:24 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:26:24 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:26:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:24 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:24 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:24 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:26:25 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:25 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:25 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:25 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:25 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:25 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:25 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:25 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:25 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:25 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:25 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:25 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:25 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:25 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:25 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'test test test' WHERE `id` = 2
2009-12-16 17:26:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:25 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:25 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:25 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:27 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:27 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:27 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:27 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:27 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:27 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:27 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:27 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:27 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:27 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:27 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:27 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:27 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:27 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:27 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:26:27 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:26:27 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:27 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:27 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:27 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:27 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:26:28 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:28 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:28 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:28 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:28 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:28 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:28 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:28 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:28 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:28 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:28 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:28 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:28 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:28 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:28 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:26:28 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:26:28 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:28 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:28 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:28 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:28 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:26:33 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:33 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:33 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:33 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:33 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:33 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:33 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:33 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:33 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:33 +00:00 --- debug: Loading module: navigation
2009-12-16 17:26:33 +00:00 --- debug: Loading controller: navigation
2009-12-16 17:26:33 +00:00 --- debug: autoloading library frontend resources for navigation
2009-12-16 17:26:33 +00:00 --- debug: autoloading frontend resources for navigation
2009-12-16 17:26:33 +00:00 --- info: found module resource /var/www/testarea/mop/modules/navigation/views/navigation.js
2009-12-16 17:26:33 +00:00 --- info: adding resource jsmodules/navigation/views/navigation.js
2009-12-16 17:26:33 +00:00 --- info: adding resource cssmodules/navigation/views/navigation.css
2009-12-16 17:26:33 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:26:33 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:26:33 +00:00 --- debug: autoloading library frontend resources for adminpage
2009-12-16 17:26:33 +00:00 --- debug: found resources for adminpage
2009-12-16 17:26:33 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-core-nc.js
2009-12-16 17:26:33 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/mootools/mootools-more.js
2009-12-16 17:26:33 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/digitarald/Swiff.Uploader.js
2009-12-16 17:26:33 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/monkeyphysics/datepicker-nc.js
2009-12-16 17:26:33 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPCore.js
2009-12-16 17:26:33 +00:00 --- info: adding resource libraryjsmodules/mop/views/js/MoPUI.js
2009-12-16 17:26:33 +00:00 --- debug: autoloading frontend resources for adminpage
2009-12-16 17:26:33 +00:00 --- debug: Loading module: adminheader
2009-12-16 17:26:33 +00:00 --- debug: No Controller, just Loading View: adminheader
2009-12-16 17:26:33 +00:00 --- debug: Loading module: mop_auth
2009-12-16 17:26:33 +00:00 --- debug: Loading controller: mop_auth
2009-12-16 17:26:33 +00:00 --- debug: Loading module: adminfooter
2009-12-16 17:26:33 +00:00 --- debug: No Controller, just Loading View: adminfooter
2009-12-16 17:26:33 +00:00 --- debug: autoloading library frontend resources for controller
2009-12-16 17:26:33 +00:00 --- debug: autoloading frontend resources for controller
2009-12-16 17:26:33 +00:00 --- debug: autoloading library frontend resources for cms
2009-12-16 17:26:33 +00:00 --- debug: autoloading frontend resources for cms
2009-12-16 17:26:33 +00:00 --- info: found module resource /var/www/testarea/mop/modules/cms/views/cms.js
2009-12-16 17:26:33 +00:00 --- info: adding resource jsmodules/cms/views/cms.js
2009-12-16 17:26:33 +00:00 --- info: adding resource cssmodules/cms/views/cms.css
2009-12-16 17:26:33 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:33 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:33 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:33 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =0
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE parentid =1
AND activity IS NULL
ORDER BY `sortorder` ASC, `pages`.`id` ASC
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:33 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:35 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:35 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:35 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:35 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:35 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:35 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:35 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:35 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:35 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:35 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:35 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:35 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '1'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:35 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:26:35 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:26:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:35 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 1
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:35 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:35 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 1
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:35 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:26:37 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:37 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:37 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:37 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:37 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:37 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:37 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:37 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:37 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:37 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:37 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:38 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:38 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:38 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:26:38 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:26:38 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:38 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:38 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:38 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:38 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:26:42 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:42 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:42 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:42 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:42 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:42 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:42 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:42 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:42 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:42 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:42 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:42 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:42 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:42 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:42 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:42 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:42 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:42 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:42 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'test test test' WHERE `id` = 2
2009-12-16 17:26:42 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:42 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:42 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:42 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:42 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:42 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:45 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:45 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:45 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:45 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:45 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:45 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:45 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:45 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:45 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:45 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:45 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:45 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:45 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:45 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:45 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:26:45 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:26:45 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:45 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:45 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:45 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:45 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:26:46 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:26:46 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:26:46 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:26:46 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:26:46 +00:00 --- debug: Database Library initialized
2009-12-16 17:26:46 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:46 +00:00 --- debug: Session Library initialized
2009-12-16 17:26:46 +00:00 --- debug: Auth Library loaded
2009-12-16 17:26:46 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:46 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:46 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:26:46 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:26:46 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '2'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:46 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:46 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:26:46 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:26:46 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:46 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 2
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:46 +00:00 --- info: MY_ORM constructor
2009-12-16 17:26:46 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 2
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:26:46 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:27:02 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:27:02 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:27:02 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:27:02 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:27:02 +00:00 --- debug: Database Library initialized
2009-12-16 17:27:02 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:02 +00:00 --- debug: Session Library initialized
2009-12-16 17:27:02 +00:00 --- debug: Auth Library loaded
2009-12-16 17:27:02 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:02 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:27:02 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:27:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:02 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:27:02 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:27:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:02 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:27:10 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:27:10 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:27:10 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:27:10 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:27:10 +00:00 --- debug: Database Library initialized
2009-12-16 17:27:10 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:10 +00:00 --- debug: Session Library initialized
2009-12-16 17:27:10 +00:00 --- debug: Auth Library loaded
2009-12-16 17:27:10 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:10 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:27:10 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:27:10 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:10 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:27:10 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:27:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:10 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:10 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:10 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:10 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:27:11 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:27:11 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:27:11 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:27:11 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:27:11 +00:00 --- debug: Database Library initialized
2009-12-16 17:27:11 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:11 +00:00 --- debug: Session Library initialized
2009-12-16 17:27:11 +00:00 --- debug: Auth Library loaded
2009-12-16 17:27:11 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:11 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:27:11 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:27:11 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:11 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:27:11 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:27:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:11 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:27:11 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:27:11 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:28:00 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:28:00 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:28:00 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:28:00 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:28:00 +00:00 --- debug: Database Library initialized
2009-12-16 17:28:00 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:00 +00:00 --- debug: Session Library initialized
2009-12-16 17:28:00 +00:00 --- debug: Auth Library loaded
2009-12-16 17:28:00 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:00 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:00 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:28:00 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:28:00 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:00 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:00 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:28:00 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:28:00 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:00 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:00 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:00 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:00 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:28:15 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:28:15 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:28:15 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:28:15 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:28:15 +00:00 --- debug: Database Library initialized
2009-12-16 17:28:15 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:15 +00:00 --- debug: Session Library initialized
2009-12-16 17:28:15 +00:00 --- debug: Auth Library loaded
2009-12-16 17:28:15 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:15 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:15 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:28:15 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:28:15 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:15 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:15 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:28:15 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:28:15 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:15 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:15 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:15 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:15 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:28:17 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:28:17 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:28:17 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:28:17 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:28:17 +00:00 --- debug: Database Library initialized
2009-12-16 17:28:17 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:17 +00:00 --- debug: Session Library initialized
2009-12-16 17:28:17 +00:00 --- debug: Auth Library loaded
2009-12-16 17:28:17 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:17 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:17 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:28:17 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:28:17 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:17 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:17 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:17 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:17 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:17 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:17 +00:00 --- info: UPDATE `content_smalls` SET `field1` = 'Array' WHERE `id` = 3
2009-12-16 17:28:17 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:17 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:17 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:17 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:17 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:17 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:20 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:28:20 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:28:20 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:28:20 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:28:20 +00:00 --- debug: Database Library initialized
2009-12-16 17:28:20 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:20 +00:00 --- debug: Session Library initialized
2009-12-16 17:28:20 +00:00 --- debug: Auth Library loaded
2009-12-16 17:28:20 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:20 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:28:20 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:28:20 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:20 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:28:20 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:28:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:20 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:28:21 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:28:21 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:28:21 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:28:21 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:28:21 +00:00 --- debug: Database Library initialized
2009-12-16 17:28:21 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:21 +00:00 --- debug: Session Library initialized
2009-12-16 17:28:21 +00:00 --- debug: Auth Library loaded
2009-12-16 17:28:21 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:21 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:28:21 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:28:21 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '3'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:21 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:28:21 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:28:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:21 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 3
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:21 +00:00 --- info: MY_ORM constructor
2009-12-16 17:28:21 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 3
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:28:21 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:33:31 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:33:31 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:33:31 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:33:31 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:33:31 +00:00 --- debug: Database Library initialized
2009-12-16 17:33:31 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:31 +00:00 --- debug: Session Library initialized
2009-12-16 17:33:31 +00:00 --- debug: Auth Library loaded
2009-12-16 17:33:31 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:31 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:33:31 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:33:31 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:31 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:33:31 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:33:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:31 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:31 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:31 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:31 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:33:41 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:33:41 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:33:41 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:33:41 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:33:41 +00:00 --- debug: Database Library initialized
2009-12-16 17:33:41 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:41 +00:00 --- debug: Session Library initialized
2009-12-16 17:33:41 +00:00 --- debug: Auth Library loaded
2009-12-16 17:33:41 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:41 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:41 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:33:41 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:33:41 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:41 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:41 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:33:41 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:33:41 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:41 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:41 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:41 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:41 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:33:42 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:33:42 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:33:42 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:33:42 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:33:42 +00:00 --- debug: Database Library initialized
2009-12-16 17:33:42 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:42 +00:00 --- debug: Session Library initialized
2009-12-16 17:33:42 +00:00 --- debug: Auth Library loaded
2009-12-16 17:33:42 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:42 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:42 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:33:42 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:33:42 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:42 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:42 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:33:42 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:33:42 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:42 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:42 +00:00 --- info: MY_ORM constructor
2009-12-16 17:33:42 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:33:42 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:34:05 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:34:05 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:34:05 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:34:05 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:34:05 +00:00 --- debug: Database Library initialized
2009-12-16 17:34:05 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:05 +00:00 --- debug: Session Library initialized
2009-12-16 17:34:05 +00:00 --- debug: Auth Library loaded
2009-12-16 17:34:05 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:05 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:05 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:34:05 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:34:05 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:05 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:05 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:34:05 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:34:05 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:05 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:05 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:05 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:05 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:34:07 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:34:07 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:34:07 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:34:07 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:34:07 +00:00 --- debug: Database Library initialized
2009-12-16 17:34:07 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:07 +00:00 --- debug: Session Library initialized
2009-12-16 17:34:07 +00:00 --- debug: Auth Library loaded
2009-12-16 17:34:07 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:07 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:07 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:34:07 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:34:07 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:07 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:07 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:07 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:07 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:07 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:07 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '1' WHERE `id` = 4
2009-12-16 17:34:07 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:07 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:07 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:07 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:07 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:07 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:10 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:34:10 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:34:10 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:34:10 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:34:10 +00:00 --- debug: Database Library initialized
2009-12-16 17:34:11 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:11 +00:00 --- debug: Session Library initialized
2009-12-16 17:34:11 +00:00 --- debug: Auth Library loaded
2009-12-16 17:34:11 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:11 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:34:11 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:34:11 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:11 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:34:11 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:34:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:11 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:11 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:11 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:11 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:34:12 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:34:12 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:34:12 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:34:12 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:34:12 +00:00 --- debug: Database Library initialized
2009-12-16 17:34:12 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:12 +00:00 --- debug: Session Library initialized
2009-12-16 17:34:12 +00:00 --- debug: Auth Library loaded
2009-12-16 17:34:12 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:12 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:12 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:34:12 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:34:12 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:12 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:12 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:34:12 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:34:12 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:12 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:12 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:12 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:12 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:34:28 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:34:28 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:34:28 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:34:28 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:34:28 +00:00 --- debug: Database Library initialized
2009-12-16 17:34:29 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:29 +00:00 --- debug: Session Library initialized
2009-12-16 17:34:29 +00:00 --- debug: Auth Library loaded
2009-12-16 17:34:29 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:29 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:29 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:34:29 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:34:29 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:29 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:29 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:34:29 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:34:29 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:29 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:29 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:29 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:29 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:34:48 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:34:48 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:34:48 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:34:48 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:34:48 +00:00 --- debug: Database Library initialized
2009-12-16 17:34:48 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:48 +00:00 --- debug: Session Library initialized
2009-12-16 17:34:48 +00:00 --- debug: Auth Library loaded
2009-12-16 17:34:48 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:48 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:48 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:34:48 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:34:48 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:48 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:48 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:48 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:48 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:48 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:48 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '2009/11/01' WHERE `id` = 5
2009-12-16 17:34:48 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:48 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:48 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:48 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:34:48 +00:00 --- info: MY_ORM constructor
2009-12-16 17:34:48 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:16 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:35:16 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:35:16 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:35:16 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:35:16 +00:00 --- debug: Database Library initialized
2009-12-16 17:35:16 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:16 +00:00 --- debug: Session Library initialized
2009-12-16 17:35:16 +00:00 --- debug: Auth Library loaded
2009-12-16 17:35:16 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:16 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:16 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:35:16 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:35:16 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:16 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:16 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:35:16 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:35:16 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:16 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:16 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:16 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:16 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:35:19 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:35:19 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:35:19 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:35:19 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:35:19 +00:00 --- debug: Database Library initialized
2009-12-16 17:35:19 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:19 +00:00 --- debug: Session Library initialized
2009-12-16 17:35:19 +00:00 --- debug: Auth Library loaded
2009-12-16 17:35:19 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:19 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:35:19 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:35:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:19 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:19 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '2009/10/04' WHERE `id` = 5
2009-12-16 17:35:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:19 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:30 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:35:30 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:35:30 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:35:30 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:35:30 +00:00 --- debug: Database Library initialized
2009-12-16 17:35:30 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:30 +00:00 --- debug: Session Library initialized
2009-12-16 17:35:30 +00:00 --- debug: Auth Library loaded
2009-12-16 17:35:30 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:30 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:30 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:35:30 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:35:30 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:30 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:30 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:35:30 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:35:30 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:30 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:30 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:30 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:30 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:35:33 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:35:33 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:35:33 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:35:33 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:35:33 +00:00 --- debug: Database Library initialized
2009-12-16 17:35:33 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:33 +00:00 --- debug: Session Library initialized
2009-12-16 17:35:33 +00:00 --- debug: Auth Library loaded
2009-12-16 17:35:33 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:33 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:35:33 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:35:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:33 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:33 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:33 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:33 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '2009/09/06' WHERE `id` = 5
2009-12-16 17:35:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:33 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:33 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:33 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:47 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:35:47 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:35:47 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:35:47 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:35:47 +00:00 --- debug: Database Library initialized
2009-12-16 17:35:47 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:47 +00:00 --- debug: Session Library initialized
2009-12-16 17:35:47 +00:00 --- debug: Auth Library loaded
2009-12-16 17:35:47 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:47 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:35:47 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:35:47 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:47 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:35:47 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:35:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:47 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:47 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:47 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:35:50 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:35:50 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:35:50 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:35:50 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:35:50 +00:00 --- debug: Database Library initialized
2009-12-16 17:35:50 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:50 +00:00 --- debug: Session Library initialized
2009-12-16 17:35:50 +00:00 --- debug: Auth Library loaded
2009-12-16 17:35:50 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:50 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:35:50 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:35:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:50 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:50 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:50 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:50 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '2009/09/06' WHERE `id` = 5
2009-12-16 17:35:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:50 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:50 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:50 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:55 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:35:55 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:35:55 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:35:55 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:35:55 +00:00 --- debug: Database Library initialized
2009-12-16 17:35:55 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:55 +00:00 --- debug: Session Library initialized
2009-12-16 17:35:55 +00:00 --- debug: Auth Library loaded
2009-12-16 17:35:55 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:55 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:55 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:35:55 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:35:55 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:55 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:55 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:35:55 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:35:55 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:55 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:55 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:55 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:55 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:35:56 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:35:56 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:35:56 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:35:56 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:35:56 +00:00 --- debug: Database Library initialized
2009-12-16 17:35:56 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:56 +00:00 --- debug: Session Library initialized
2009-12-16 17:35:56 +00:00 --- debug: Auth Library loaded
2009-12-16 17:35:56 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:56 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:35:56 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:35:56 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:56 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:35:56 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:35:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:35:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:35:56 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:36:56 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:36:56 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:36:56 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:36:56 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:36:56 +00:00 --- debug: Database Library initialized
2009-12-16 17:36:56 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:36:56 +00:00 --- debug: Session Library initialized
2009-12-16 17:36:56 +00:00 --- debug: Auth Library loaded
2009-12-16 17:36:56 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:36:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:36:56 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:36:56 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:36:56 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:36:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:36:56 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:36:56 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:36:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:36:56 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:36:56 +00:00 --- info: MY_ORM constructor
2009-12-16 17:36:56 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:36:56 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:37:01 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:37:01 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:37:01 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:37:01 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:37:01 +00:00 --- debug: Database Library initialized
2009-12-16 17:37:01 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:01 +00:00 --- debug: Session Library initialized
2009-12-16 17:37:01 +00:00 --- debug: Auth Library loaded
2009-12-16 17:37:01 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:01 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:01 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:37:01 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:37:01 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:01 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:01 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:37:01 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:37:01 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:01 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:01 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:01 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:01 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:37:02 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:37:02 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:37:02 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:37:02 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:37:02 +00:00 --- debug: Database Library initialized
2009-12-16 17:37:02 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- debug: Session Library initialized
2009-12-16 17:37:02 +00:00 --- debug: Auth Library loaded
2009-12-16 17:37:02 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:37:02 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '0' WHERE `id` = 4
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:37:02 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:37:02 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:37:02 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:37:02 +00:00 --- debug: Database Library initialized
2009-12-16 17:37:02 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- debug: Session Library initialized
2009-12-16 17:37:02 +00:00 --- debug: Auth Library loaded
2009-12-16 17:37:02 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:37:02 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: UPDATE `content_smalls` SET `flag1` = '1' WHERE `id` = 4
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '4'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 4
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 4
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:19 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:37:19 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:37:19 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:37:19 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:37:19 +00:00 --- debug: Database Library initialized
2009-12-16 17:37:19 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:19 +00:00 --- debug: Session Library initialized
2009-12-16 17:37:19 +00:00 --- debug: Auth Library loaded
2009-12-16 17:37:19 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:19 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:37:19 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:37:19 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:19 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:37:19 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:37:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:19 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:19 +00:00 --- info: MY_ORM constructor
2009-12-16 17:37:19 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:37:19 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:40:24 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:40:24 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:40:24 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:40:24 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:40:24 +00:00 --- debug: Database Library initialized
2009-12-16 17:40:24 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:24 +00:00 --- debug: Session Library initialized
2009-12-16 17:40:24 +00:00 --- debug: Auth Library loaded
2009-12-16 17:40:24 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:24 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:40:24 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:40:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:24 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:24 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:24 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:24 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '2009/12/17' WHERE `id` = 5
2009-12-16 17:40:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:24 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:24 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:24 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:24 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:33 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:40:33 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:40:33 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:40:33 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:40:33 +00:00 --- debug: Database Library initialized
2009-12-16 17:40:33 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:33 +00:00 --- debug: Session Library initialized
2009-12-16 17:40:33 +00:00 --- debug: Auth Library loaded
2009-12-16 17:40:33 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:33 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:40:33 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:40:33 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:33 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:40:33 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:40:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:33 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:33 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:33 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:33 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:40:37 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:40:37 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:40:37 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:40:37 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:40:37 +00:00 --- debug: Database Library initialized
2009-12-16 17:40:37 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:37 +00:00 --- debug: Session Library initialized
2009-12-16 17:40:37 +00:00 --- debug: Auth Library loaded
2009-12-16 17:40:37 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:37 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:40:37 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:40:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:37 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:37 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:37 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:37 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '2009/11/01' WHERE `id` = 5
2009-12-16 17:40:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:37 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:37 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:37 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:37 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:50 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:40:50 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:40:50 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:40:50 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:40:50 +00:00 --- debug: Database Library initialized
2009-12-16 17:40:50 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:50 +00:00 --- debug: Session Library initialized
2009-12-16 17:40:50 +00:00 --- debug: Auth Library loaded
2009-12-16 17:40:50 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:50 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:40:50 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:40:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:50 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:50 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:50 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:50 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '2009/12/17' WHERE `id` = 5
2009-12-16 17:40:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:50 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:50 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:50 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:59 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:40:59 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:40:59 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:40:59 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:40:59 +00:00 --- debug: Database Library initialized
2009-12-16 17:40:59 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:59 +00:00 --- debug: Session Library initialized
2009-12-16 17:40:59 +00:00 --- debug: Auth Library loaded
2009-12-16 17:40:59 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:59 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:59 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:40:59 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:40:59 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:59 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:59 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:40:59 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:40:59 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:59 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:59 +00:00 --- info: MY_ORM constructor
2009-12-16 17:40:59 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:40:59 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:41:02 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:41:02 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:41:02 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:41:02 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:41:02 +00:00 --- debug: Database Library initialized
2009-12-16 17:41:02 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:02 +00:00 --- debug: Session Library initialized
2009-12-16 17:41:02 +00:00 --- debug: Auth Library loaded
2009-12-16 17:41:02 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:02 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:41:02 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:41:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:02 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '2009/11/01' WHERE `id` = 5
2009-12-16 17:41:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:20 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:41:20 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:41:20 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:41:20 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:41:20 +00:00 --- debug: Database Library initialized
2009-12-16 17:41:20 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:20 +00:00 --- debug: Session Library initialized
2009-12-16 17:41:20 +00:00 --- debug: Auth Library loaded
2009-12-16 17:41:20 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:20 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:41:20 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:41:20 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:20 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:41:20 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:41:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:20 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:20 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:20 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:20 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:41:22 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:41:22 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:41:22 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:41:22 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:41:22 +00:00 --- debug: Database Library initialized
2009-12-16 17:41:22 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:22 +00:00 --- debug: Session Library initialized
2009-12-16 17:41:22 +00:00 --- debug: Auth Library loaded
2009-12-16 17:41:22 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:22 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:41:22 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:41:22 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:22 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:41:22 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:41:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:22 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:22 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:22 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:22 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:41:36 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:41:36 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:41:36 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:41:36 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:41:36 +00:00 --- debug: Database Library initialized
2009-12-16 17:41:36 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:36 +00:00 --- debug: Session Library initialized
2009-12-16 17:41:36 +00:00 --- debug: Auth Library loaded
2009-12-16 17:41:36 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:36 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:36 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:41:36 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:41:36 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:36 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:36 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:36 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:36 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '2009/12/17' WHERE `id` = 5
2009-12-16 17:41:36 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:36 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:36 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:36 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:41:36 +00:00 --- info: MY_ORM constructor
2009-12-16 17:41:36 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:01 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:42:01 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:42:01 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:42:01 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:42:01 +00:00 --- debug: Database Library initialized
2009-12-16 17:42:01 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:01 +00:00 --- debug: Session Library initialized
2009-12-16 17:42:01 +00:00 --- debug: Auth Library loaded
2009-12-16 17:42:01 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:01 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:01 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:42:01 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:42:01 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:01 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:01 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:42:01 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:42:01 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:01 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:01 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:01 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:01 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:42:04 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:42:04 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:42:04 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:42:04 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:42:04 +00:00 --- debug: Database Library initialized
2009-12-16 17:42:04 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:04 +00:00 --- debug: Session Library initialized
2009-12-16 17:42:04 +00:00 --- debug: Auth Library loaded
2009-12-16 17:42:04 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:04 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:42:04 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:42:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:04 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:04 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:04 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:04 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '2009/11/01' WHERE `id` = 5
2009-12-16 17:42:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:04 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:04 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:04 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:07 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:42:07 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:42:07 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:42:07 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:42:07 +00:00 --- debug: Database Library initialized
2009-12-16 17:42:08 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:08 +00:00 --- debug: Session Library initialized
2009-12-16 17:42:08 +00:00 --- debug: Auth Library loaded
2009-12-16 17:42:08 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:08 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:42:08 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:42:08 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:08 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:42:08 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:42:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:08 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:08 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:08 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:08 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:42:09 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:42:09 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:42:09 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:42:09 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:42:09 +00:00 --- debug: Database Library initialized
2009-12-16 17:42:09 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:09 +00:00 --- debug: Session Library initialized
2009-12-16 17:42:09 +00:00 --- debug: Auth Library loaded
2009-12-16 17:42:09 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:09 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:09 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:42:09 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:42:09 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:09 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:09 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:42:09 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:42:09 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:09 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:09 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:09 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:09 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:42:57 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:42:57 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:42:57 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:42:57 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:42:57 +00:00 --- debug: Database Library initialized
2009-12-16 17:42:57 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:57 +00:00 --- debug: Session Library initialized
2009-12-16 17:42:57 +00:00 --- debug: Auth Library loaded
2009-12-16 17:42:57 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:57 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:57 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:42:57 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:42:57 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:57 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:57 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:42:57 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:42:57 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:57 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:57 +00:00 --- info: MY_ORM constructor
2009-12-16 17:42:57 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:42:57 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:43:04 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:43:04 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:43:04 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:43:04 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:43:04 +00:00 --- debug: Database Library initialized
2009-12-16 17:43:04 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:43:04 +00:00 --- debug: Session Library initialized
2009-12-16 17:43:04 +00:00 --- debug: Auth Library loaded
2009-12-16 17:43:04 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:43:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:43:04 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:43:04 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:43:04 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:43:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:43:04 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:43:04 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:43:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:43:04 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:43:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:43:04 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:43:04 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:43:25 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:43:25 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:43:25 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:43:25 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:43:25 +00:00 --- debug: Database Library initialized
2009-12-16 17:43:25 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:43:25 +00:00 --- debug: Session Library initialized
2009-12-16 17:43:25 +00:00 --- debug: Auth Library loaded
2009-12-16 17:43:25 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:43:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:43:25 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:43:25 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:43:25 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:43:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:43:25 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:43:25 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:43:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:43:25 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:43:25 +00:00 --- info: MY_ORM constructor
2009-12-16 17:43:25 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:43:25 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:44:46 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:44:46 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:44:46 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:44:46 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:44:46 +00:00 --- debug: Database Library initialized
2009-12-16 17:44:47 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:44:47 +00:00 --- debug: Session Library initialized
2009-12-16 17:44:47 +00:00 --- debug: Auth Library loaded
2009-12-16 17:44:47 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:44:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:44:47 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:44:47 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:44:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:44:47 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:44:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:44:47 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:44:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:44:47 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:44:47 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '05:45' WHERE `id` = 6
2009-12-16 17:44:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:44:47 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:44:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:44:47 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:44:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:44:47 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:03 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:45:03 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:45:03 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:45:03 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:45:03 +00:00 --- debug: Database Library initialized
2009-12-16 17:45:03 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:03 +00:00 --- debug: Session Library initialized
2009-12-16 17:45:03 +00:00 --- debug: Auth Library loaded
2009-12-16 17:45:03 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:03 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:03 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:45:03 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:45:03 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:03 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:03 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:45:03 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:45:03 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:03 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:03 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:03 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:03 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:45:04 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:45:04 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:45:04 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:45:04 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:45:04 +00:00 --- debug: Database Library initialized
2009-12-16 17:45:04 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:04 +00:00 --- debug: Session Library initialized
2009-12-16 17:45:04 +00:00 --- debug: Auth Library loaded
2009-12-16 17:45:04 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:04 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:45:04 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:45:04 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:04 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:45:04 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:45:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:04 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:04 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:04 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:04 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:45:51 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:45:51 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:45:51 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:45:51 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:45:51 +00:00 --- debug: Database Library initialized
2009-12-16 17:45:51 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:51 +00:00 --- debug: Session Library initialized
2009-12-16 17:45:51 +00:00 --- debug: Auth Library loaded
2009-12-16 17:45:51 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:51 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:51 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:45:51 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:45:51 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:51 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:51 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:51 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:51 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:51 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:51 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '07:02' WHERE `id` = 6
2009-12-16 17:45:51 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:51 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:51 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:51 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:45:51 +00:00 --- info: MY_ORM constructor
2009-12-16 17:45:51 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:02 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:46:02 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:46:02 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:46:02 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:46:02 +00:00 --- debug: Database Library initialized
2009-12-16 17:46:02 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:02 +00:00 --- debug: Session Library initialized
2009-12-16 17:46:02 +00:00 --- debug: Auth Library loaded
2009-12-16 17:46:02 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:02 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:46:02 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:46:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:02 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '05:45' WHERE `id` = 6
2009-12-16 17:46:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:02 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:02 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:02 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:02 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:05 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:46:05 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:46:05 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:46:05 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:46:05 +00:00 --- debug: Database Library initialized
2009-12-16 17:46:05 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:05 +00:00 --- debug: Session Library initialized
2009-12-16 17:46:05 +00:00 --- debug: Auth Library loaded
2009-12-16 17:46:05 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:05 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:46:05 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:46:05 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:05 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:46:05 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:05 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:05 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:05 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:05 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:46:06 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:46:06 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:46:06 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:46:06 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:46:06 +00:00 --- debug: Database Library initialized
2009-12-16 17:46:06 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:06 +00:00 --- debug: Session Library initialized
2009-12-16 17:46:06 +00:00 --- debug: Auth Library loaded
2009-12-16 17:46:06 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:06 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:46:06 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:46:06 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:06 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:46:06 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:46:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:06 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:06 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:06 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:06 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:46:43 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:46:43 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:46:43 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:46:43 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:46:43 +00:00 --- debug: Database Library initialized
2009-12-16 17:46:43 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:43 +00:00 --- debug: Session Library initialized
2009-12-16 17:46:43 +00:00 --- debug: Auth Library loaded
2009-12-16 17:46:43 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:43 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:43 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:46:43 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:46:43 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:43 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:43 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:46:43 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:46:43 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:43 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:43 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:43 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:43 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:46:47 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:46:47 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:46:47 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:46:47 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:46:47 +00:00 --- debug: Database Library initialized
2009-12-16 17:46:47 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:47 +00:00 --- debug: Session Library initialized
2009-12-16 17:46:47 +00:00 --- debug: Auth Library loaded
2009-12-16 17:46:47 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:47 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:46:47 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:46:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:47 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:47 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:47 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:47 +00:00 --- info: UPDATE `content_smalls` SET `field1` = '05:45' WHERE `id` = 6
2009-12-16 17:46:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:47 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:47 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:47 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:47 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:50 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:46:50 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:46:50 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:46:50 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:46:50 +00:00 --- debug: Database Library initialized
2009-12-16 17:46:50 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:50 +00:00 --- debug: Session Library initialized
2009-12-16 17:46:50 +00:00 --- debug: Auth Library loaded
2009-12-16 17:46:50 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:50 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:46:50 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:46:50 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '5'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:50 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:46:50 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:46:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:50 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 5
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:50 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:50 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 5
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:50 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
2009-12-16 17:46:51 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2009-12-16 17:46:51 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2009-12-16 17:46:51 +00:00 --- debug: Session Cookie Driver Initialized
2009-12-16 17:46:51 +00:00 --- debug: MySQL Database Driver Initialized
2009-12-16 17:46:51 +00:00 --- debug: Database Library initialized
2009-12-16 17:46:51 +00:00 --- info: SELECT `users`.*
FROM (`users`)
WHERE `users`.`id` = 3
ORDER BY `users`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:51 +00:00 --- debug: Session Library initialized
2009-12-16 17:46:51 +00:00 --- debug: Auth Library loaded
2009-12-16 17:46:51 +00:00 --- info: SELECT `roles`.*
FROM (`roles`)
WHERE `roles`.`name` = 'admin'
ORDER BY `roles`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:51 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:51 +00:00 --- info: SELECT `role_id` AS `id`
FROM (`roles_users`)
WHERE `roles_users`.`user_id` = 3
2009-12-16 17:46:51 +00:00 --- info: cms needs to choose navigation module
2009-12-16 17:46:51 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `pages`.`id` = '6'
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:51 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:51 +00:00 --- debug: autoloading library frontend resources for cms_nodetitle
2009-12-16 17:46:51 +00:00 --- debug: autoloading frontend resources for cms_nodetitle
2009-12-16 17:46:51 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:51 +00:00 --- info: SELECT `templates`.*
FROM (`templates`)
WHERE `templates`.`id` = 6
ORDER BY `templates`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:51 +00:00 --- info: MY_ORM constructor
2009-12-16 17:46:51 +00:00 --- info: SELECT `content_smalls`.*
FROM (`content_smalls`)
WHERE `page_id` = 6
ORDER BY `content_smalls`.`id` ASC
LIMIT 0, 1
2009-12-16 17:46:51 +00:00 --- info: array (
  'js' => 
  array (
  ),
  'libraryjs' => 
  array (
  ),
  'css' => 
  array (
  ),
  'librarycss' => 
  array (
  ),
)
