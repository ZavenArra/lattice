<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	E_KOHANA             => array( 1, '框架错误',   '请根据下面的相关错误查阅 Kohana 文档。'),
	E_PAGE_NOT_FOUND     => array( 1, '页面不存在',    '请求页面不存在。或许它被转移，删除或存档。'),
	E_DATABASE_ERROR     => array( 1, '数据库错误',    '数据库在执行程序时出现错误。请从下面的错误信息检查数据库错误。'),
	E_RECOVERABLE_ERROR  => array( 1, '可回收错误', '发生错误在加载此页面时。如果这个问题仍然存在，请联系网站管理员。'),
	E_ERROR              => array( 1, '致命错误',       ''),
	E_USER_ERROR         => array( 1, '致命错误',       ''),
	E_PARSE              => array( 1, '语法错误',      ''),
	E_WARNING            => array( 1, '警告消息',   ''),
	E_USER_WARNING       => array( 1, '警告消息',   ''),
	E_STRICT             => array( 2, '严格（标准）模式错误', ''),
	E_NOTICE             => array( 2, '运行信息',   ''),
);