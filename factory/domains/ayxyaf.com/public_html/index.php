<?php
// 网站根目录
define('ROOT', dirname(__FILE__));

// 定义框架路径
define('THINK_PATH','./ThinkPHP/');

// 定义项目名称和路径
define('APP_NAME', 'App');
define('APP_PATH', './App/');

// 调试开关开启
define('APP_DEBUG', true);

// 定义基础常量
define('ARTICLE',1);
define('PRODUCT',2);
define('JOBS',3);
define('NEWS',4);

require(THINK_PATH.'ThinkPHP.php');
?>