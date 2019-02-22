-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1:3306
-- 生成日期: 2014 年 10 月 08 日 06:59
-- 服务器版本: 5.1.28
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 表的结构 `qf_apply`
--

CREATE TABLE IF NOT EXISTS `qf_apply` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '应聘时间',
  `a_id` int(11) NOT NULL COMMENT '应聘岗位',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `sex` enum('男','女') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '性别',
  `height` varchar(20) NOT NULL COMMENT '身高',
  `addr_now` varchar(200) DEFAULT NULL COMMENT '家庭地址',
  `idcard` varchar(30) NOT NULL COMMENT '身份证号',
  `birthday` date DEFAULT NULL COMMENT '出生日期',
  `subject` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `graduate_date` varchar(30) NOT NULL COMMENT '毕业时间',
  `graduate_school` varchar(50) NOT NULL COMMENT '毕业院校',
  `work_experience` text COMMENT '工作经历',
  `expect_salary` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(50) DEFAULT NULL COMMENT '电话',
  `mobile` varchar(30) DEFAULT NULL COMMENT '手机',
  `email` varchar(50) NOT NULL COMMENT '电子邮件',
  `note` text COMMENT '备注',
  `order` int(11) NOT NULL COMMENT '顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='申请应聘表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `qf_apply`
--


-- --------------------------------------------------------

--
-- 表的结构 `qf_article`
--

CREATE TABLE IF NOT EXISTS `qf_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `pid` int(11) NOT NULL COMMENT '类别ID',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `keywords` varchar(150) NOT NULL COMMENT '关键词',
  `description` varchar(250) NOT NULL COMMENT '描述',
  `img` varchar(200) NOT NULL COMMENT '图片集合',
  `content` text COMMENT '内容',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间',
  `order` int(11) NOT NULL COMMENT '顺序',
  `click` int(11) NOT NULL COMMENT '点击',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '系统内置',
  `img1` varchar(200) NOT NULL COMMENT '图片1',
  `img2` varchar(200) NOT NULL COMMENT '图片2',
  `img3` varchar(200) NOT NULL COMMENT '图片3',
  `img4` varchar(200) NOT NULL COMMENT '图片4',
  `img5` varchar(200) NOT NULL COMMENT '图片5',
  `img6` varchar(200) NOT NULL COMMENT '图片6',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `pid` (`pid`),
  KEY `system` (`system`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `qf_article`
--

INSERT INTO `qf_article` (`id`, `pid`, `title`, `keywords`, `description`, `img`, `content`, `time`, `order`, `click`, `system`, `img1`, `img2`, `img3`, `img4`, `img5`, `img6`) VALUES
(1, 0, '公司简介', '', '', '', '公司简介', '2014-09-12 11:30:34', 0, 11, 1, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qf_config`
--

CREATE TABLE IF NOT EXISTS `qf_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `options` varchar(255) NOT NULL,
  `type` enum('text','textarea','checkbox','select','file','radio','xheditor') NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '1' COMMENT '配置组,0系统设置,1网站设置,2智能标签配置 青峰人才：0开启 -1关闭',
  `order` int(11) NOT NULL COMMENT '顺序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='配置表' AUTO_INCREMENT=41 ;

--
-- 导出表中的数据 `qf_config`
--

INSERT INTO `qf_config` (`id`, `key`, `value`, `name`, `options`, `type`, `group_id`, `order`) VALUES
(1, 'web_url', '', '网站URL', '', 'text', 1, 0),
(2, 'web_name', '', '网站名称', '', 'text', 1, 0),
(3, 'logo', '', '网站logo', '', 'file', 1, 0),
(4, 'web_open', '', '网站开启', '是,否', 'radio', 0, 0),
(5, 'icp_num', '', 'ICP备案', '', 'text', 1, 0),
(6, 'web_keywords', '', '网站关键字', '', 'textarea', 1, 0),
(7, 'web_description', '', '网站描述', '', 'textarea', 1, 0),
(8, 'switch_watermark', '0', '水印开关', '关闭,开启', 'radio', 4, 0),
(9, 'version', '4.00001', '版本号', '', 'text', 0, 0),
(10, 'mobile', '', '手机号码', '', 'text', 1, 0),
(11, 'email', '', '邮箱', '', 'text', 1, 0),
(12, 'address', '', '地址', '', 'text', 1, 0),
(13, 'web_watermark', '青峰网络', '文字水印', '', 'text', 4, 0),
(14, 'article_list', '<volist name="list" id="vo">\r\n    <li><a href="{$vo.url}">{$vo.title}</a></li>\r\n</volist>', '文章列表', '', 'textarea', 2, 0),
(15, 'article_img_list', '<volist name="list" id="vo">							\r\n    <li>\r\n        <a href="{$vo.url}"><img src="__ROOT__/__UPLOAD__/{$vo.img}" alt="{$vo.title}"></a>\r\n        <p>\r\n            <a href="{$vo.url}"><strong>{$vo.title}</strong><br>\r\n            {$vo.description}<br>\r\n            {$vo.time}</a>\r\n        </p>\r\n    </li>\r\n</volist>', '图片文章混排', '', 'textarea', 2, 0),
(16, 'img_list', '<volist name="list" id="vo">\r\n<li>\r\n    <a href="{$vo.url}"><img src="__ROOT__/__UPLOAD__/{$vo.img}" alt="{$vo.title}"><br><span>{$vo.title}</span></a>\r\n</li>\r\n</volist>', '图片列表', '', 'textarea', 2, 0),
(17, 'current_theme', 'Default', '模板选择', '', 'text', 4, 0),
(18, 'switch_upgrade', '1', '智能升级', '关闭,开启', 'radio', 0, 0),
(19, 'switch_order', '1', '在线订单开关', '', 'text', 0, 0),
(20, 'switch_introduction', '1', '公司介绍开关', '', 'text', 0, 0),
(21, 'switch_news', '1', '新闻中心开关', '', 'text', 0, 0),
(22, 'switch_contactus', '1', '联系我们开关', '', 'text', 0, 0),
(24, 'switch_message', '1', '在线留言开关', '', 'text', 0, 0),
(25, 'switch_jobs', '1', '在线招聘开关', '', 'text', 0, 0),
(26, 'linkman', '', '联系人', '', 'text', 1, 0),
(27, 'tel', '', '联系电话', '', 'text', 1, 0),
(28, 'fax', '', '传真', '', 'text', 1, 0),
(29, 'switch_mbaidu', '0', '百度手机搜索专卖', '', 'text', 0, 0),
(30, 'switch_product', '1', '产品展示开关', '', 'text', 0, 0),
(31, 'page_default', '10', '默认分页数', 'number', 'text', 4, 0),
(32, 'page_product', '9', '产品分页数', 'number', 'text', 4, 0),
(33, 'page_jobs', '2', '招聘分页数', 'number', 'text', 4, 0),
(34, 'code_statistics', '', '代码统计', '', 'textarea', 0, 0),
(35, 'baidu_map_x', '113.867976', '百度地图X', '', 'text', 3, 0),
(36, 'baidu_map_y', '35.291272', '百度地图Y', '', 'text', 3, 0),
(37, 'code_head', '', 'head代码', '', 'textarea', 4, 0),
(38, 'code_body', '', 'body代码', '', 'textarea', 4, 0),
(39, 'qfjob', '', '青峰人才', '', 'textarea', -1, 0),
(40, 'switch_m_pc', '1', '手机显示样式', '', 'text', 0, 0),
(41, 'wx_code', '', '微信标识', '', 'text', 0, 0),
(42, 'wx_user', '', '关注列表', '', 'text', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `qf_flash`
--

CREATE TABLE IF NOT EXISTS `qf_flash` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL COMMENT '标题',
  `img` varchar(50) NOT NULL COMMENT '图片',
  `link` varchar(100) NOT NULL DEFAULT '#' COMMENT '链接',
  `order` tinyint(3) NOT NULL COMMENT '顺序',
  `open` char(1) NOT NULL DEFAULT '1' COMMENT '显示开关',
  `pc_m` tinyint(1) NOT NULL DEFAULT '0' COMMENT '手机或PC图片（0为PC，1为手机）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='导航轮播图片' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `qf_flash`
--


-- --------------------------------------------------------

--
-- 表的结构 `qf_goods`
--

CREATE TABLE IF NOT EXISTS `qf_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `pid` int(11) NOT NULL COMMENT '类别ID',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `keywords` varchar(150) NOT NULL COMMENT '关键词',
  `description` varchar(250) NOT NULL COMMENT '描述',
  `img` varchar(200) NOT NULL COMMENT '图片集合',
  `price` decimal(10,2) NOT NULL COMMENT '商品价格',
  `content` text COMMENT '内容',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间',
  `is_hot` tinyint(1) NOT NULL COMMENT '是否热销',
  `is_best` tinyint(1) NOT NULL COMMENT '是否促销',
  `is_new` tinyint(1) NOT NULL COMMENT '是否新品',
  `is_delete` tinyint(1) NOT NULL COMMENT '是否下架',
  `order` int(11) NOT NULL COMMENT '顺序',
  `click` int(11) NOT NULL COMMENT '点击',
  `img1` varchar(200) NOT NULL COMMENT '图片1',
  `img2` varchar(200) NOT NULL COMMENT '图片2',
  `img3` varchar(200) NOT NULL COMMENT '图片3',
  `img4` varchar(200) NOT NULL COMMENT '图片4',
  `img5` varchar(200) NOT NULL COMMENT '图片5',
  `img6` varchar(200) NOT NULL COMMENT '图片6',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `qf_goods`
--


-- --------------------------------------------------------

--
-- 表的结构 `qf_jobs`
--

CREATE TABLE IF NOT EXISTS `qf_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job` varchar(80) NOT NULL COMMENT '岗位名称',
  `keywords` varchar(150) NOT NULL,
  `description` varchar(250) NOT NULL,
  `salary` varchar(50) NOT NULL COMMENT '薪资范围',
  `pid` int(11) NOT NULL COMMENT '类别号',
  `request` text NOT NULL COMMENT '要求',
  `num` smallint(6) NOT NULL COMMENT '数量',
  `order` int(11) NOT NULL COMMENT '顺序',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `end_time` date NOT NULL COMMENT '截止日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='企业招聘表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `qf_jobs`
--


-- --------------------------------------------------------

--
-- 表的结构 `qf_log`
--

CREATE TABLE IF NOT EXISTS `qf_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` char(4) NOT NULL COMMENT '操作',
  `user` varchar(30) NOT NULL COMMENT '用户',
  `ip` varchar(20) NOT NULL COMMENT 'ip地址',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  `order` int(11) NOT NULL COMMENT '顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台日志表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `qf_log`
--


-- --------------------------------------------------------

--
-- 表的结构 `qf_message`
--

CREATE TABLE IF NOT EXISTS `qf_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `tel` varchar(30) NOT NULL COMMENT '电话',
  `add` varchar(100) DEFAULT NULL COMMENT '地址',
  `email` varchar(80) DEFAULT NULL COMMENT '电子邮件',
  `content` text NOT NULL COMMENT '留言内容',
  `ip` char(20) NOT NULL COMMENT 'ip地址',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '留言时间',
  `reply` text,
  `is_show` smallint(2) NOT NULL DEFAULT '0' COMMENT '留言是否显示',
  `is_mobile` smallint(2) NOT NULL DEFAULT '0' COMMENT '是否手机留言1手机 0网站',
  `order` int(11) NOT NULL COMMENT '顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `qf_message`
--


-- --------------------------------------------------------

--
-- 表的结构 `qf_order`
--

CREATE TABLE IF NOT EXISTS `qf_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `tel` varchar(30) NOT NULL COMMENT '电话',
  `add` varchar(80) NOT NULL COMMENT '地址',
  `cp_id` char(6) NOT NULL COMMENT '预定产品',
  `num` int(5) NOT NULL COMMENT '预定数量',
  `email` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '预定时间',
  `notes` text COMMENT '备注',
  `is_mobile` smallint(2) NOT NULL COMMENT '是否手机留言1手机 0网站',
  `order` int(11) NOT NULL COMMENT '顺序',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `qf_order`
--


-- --------------------------------------------------------

--
-- 表的结构 `qf_type`
--

CREATE TABLE IF NOT EXISTS `qf_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(100) NOT NULL COMMENT '层次代码',
  `name` varchar(50) NOT NULL COMMENT '类别名称',
  `parent` varchar(20) NOT NULL COMMENT '父亲ID',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '顺序',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `keywords` varchar(150) NOT NULL COMMENT '关键词',
  `description` varchar(250) NOT NULL COMMENT '描述',
  `img` varchar(200) NOT NULL COMMENT '图片',
  `content` text COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='分类表' AUTO_INCREMENT=7 ;

--
-- 导出表中的数据 `qf_type`
--

INSERT INTO `qf_type` (`id`, `code`, `name`, `parent`, `order`, `type`, `keywords`, `description`, `img`) VALUES
(1, '1,', '文章栏目', '0', 0, 0, '', '', ''),
(2, '2,', '产品中心', '0', 0, 2, '', '', ''),
(3, '3,', '人才招聘', '0', 0, 3, '', '', ''),
(4, '1,4,', '新闻中心', '1', 0, 1, '', '', ''),
(5, '1,5,', '资质荣誉', '1', 0, 1, '', '', ''),
(6, '1,6,', '友情链接', '1', 0, 1, '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qf_user`
--

CREATE TABLE IF NOT EXISTS `qf_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL COMMENT '用户名',
  `password` varchar(100) NOT NULL COMMENT '密码',
  `order` int(11) NOT NULL COMMENT '顺序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=1 ;

--
-- 表的结构 `qf_synchro`
--
CREATE TABLE `qf_synchro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT NULL COMMENT '数据类型1新闻，2产品，3分类，4网参，5单页，6自助',
  `obj` smallint(6) NOT NULL COMMENT '数据编号',
  `check` varchar(32) DEFAULT NULL COMMENT '同步版本',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT ' 同步时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;