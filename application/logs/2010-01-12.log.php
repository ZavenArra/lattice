<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-01-12 17:36:35 +00:00 --- info: Attempting to route slug
2010-01-12 17:36:35 +00:00 --- info: checking rsegment homepage
2010-01-12 17:36:35 +00:00 --- debug: MySQL Database Driver Initialized
2010-01-12 17:36:35 +00:00 --- debug: Database Library initialized
2010-01-12 17:36:35 +00:00 --- info: MY_ORM constructor
2010-01-12 17:36:35 +00:00 --- info: SELECT `pages`.*
FROM (`pages`)
WHERE `slug` = 'homepage'
AND activity IS NULL
AND `published` = 1
ORDER BY `pages`.`id` ASC
LIMIT 0, 1
2010-01-12 17:36:35 +00:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-01-12 17:36:35 +00:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-01-12 17:36:35 +00:00 --- debug: autoloading library frontend resources for publicpage
2010-01-12 17:36:35 +00:00 --- debug: autoloading frontend resources for publicpage
2010-01-12 17:36:36 +00:00 --- debug: Loading module: publicheader
2010-01-12 17:36:36 +00:00 --- debug: No Controller, just Loading View: publicheader
2010-01-12 17:36:36 +00:00 --- debug: Loading module: publicfooter
2010-01-12 17:36:36 +00:00 --- debug: No Controller, just Loading View: publicfooter
2010-01-12 17:36:36 +00:00 --- debug: autoloading library frontend resources for cms_frontend_core
2010-01-12 17:36:36 +00:00 --- debug: autoloading frontend resources for cms_frontend_core
2010-01-12 17:36:36 +00:00 --- debug: autoloading library frontend resources for 404
2010-01-12 17:36:36 +00:00 --- debug: autoloading frontend resources for 404
2010-01-12 17:36:36 +00:00 --- debug: autoloading library frontend resources for error
