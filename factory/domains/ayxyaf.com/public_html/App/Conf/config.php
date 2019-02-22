<?php
return array(
    'APP_GROUP_LIST'            =>  'Home,Admin,Install',
    'DEFAULT_GROUP'             =>  'Home',
    'URL_CASE_INSENSITIVE'      =>   true,
	'UPLOAD_DIR'				=>  'Uploads/',
    'URL_MODEL'                 =>  2, 
    'DB_TYPE'                   =>  'mysql',
    'DB_HOST'                   =>  'localhost',
    'DB_NAME'                   =>  'ayxyaf_qf',
    'DB_USER'                   =>  'ayxyaf_qf',
    'DB_PWD'                    =>  'ayxyafqf123',
    'DB_PORT'                   =>  '3306',
    'DB_PREFIX'                 =>  'qf_',
	'TMPL_PARSE_STRING'         => array(
        '__UPLOAD__' => 'Uploads', // 增加新的上传路径替换规则
    ),
	//默认错误跳转对应的模板文件
	'TMPL_ACTION_ERROR'   => 'Public:jump',
	//默认成功跳转对应的模板文件
	'TMPL_ACTION_SUCCESS' => 'Public:jump',
	'URL_ROUTER_ON'       =>  true, //开启路由
	'URL_ROUTE_RULES'     =>  array(   //路由规则        
		'/^news\/(\d+)_(\d+)$/'    =>  'news/news_info?id=:2',
		'/^news\/(\d+)$/'          =>  'news/news_type?type=:1',		
		'/^product\/(\d+)_(\d+)$/' =>  'product/product_info?id=:2',
		'/^product\/(\d+)$/'       =>  'product/product_type?type=:1',		
		'/^jobs\/(\d+)$/'          =>  'jobs/jobs_info?id=:1',
		'/^custom\/(\d+)_(\d+)$/'       =>  'custom/custom_info?id=:2',
		'/^custom\/(\d+)$/' =>  'custom/custom_type?type=:1',
		'/^article\/(\d+)$/'          =>  'article/index?id=:1',	        
		'/^jobs\/(\d+)$/'          =>  'jobs/jobs_info?id=:1',
	),
	'LOAD_EXT_CONFIG' => 'api',
	'LOG_RECORD'      => false, // 默认不记录日志
);
?>