/*
Navicat MySQL Data Transfer

Source Server         : 1
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ayxyaf

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-08-17 10:35:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for qf_apply
-- ----------------------------
DROP TABLE IF EXISTS `qf_apply`;
CREATE TABLE `qf_apply` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='申请应聘表';

-- ----------------------------
-- Records of qf_apply
-- ----------------------------

-- ----------------------------
-- Table structure for qf_article
-- ----------------------------
DROP TABLE IF EXISTS `qf_article`;
CREATE TABLE `qf_article` (
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
  `title_en` varchar(200) DEFAULT NULL COMMENT '标题英文',
  `upclass` varchar(100) DEFAULT NULL COMMENT '分类所属',
  `is_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶',
  `is_red` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐',
  `link` varchar(250) DEFAULT NULL COMMENT '外部链接',
  `is_open` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `pid` (`pid`),
  KEY `system` (`system`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of qf_article
-- ----------------------------
INSERT INTO `qf_article` VALUES ('1', '0', '公司简介', '', '', '', '', '2014-09-12 11:30:34', '0', '11', '1', '', '', '', '', '', '', '', '', '0', '0', null, '0');
INSERT INTO `qf_article` VALUES ('2', '0', '联系我们', '', '', '', '<p><strong>文峰区新宇金属工艺制品</strong></p><p>联系人：顾经理</p><p>手机：155-1503-0055</p><p>地址：中国 · 河南 · 安阳</p>', '2015-11-18 10:43:44', '0', '0', '1', '', '', '', '', '', '', '', '', '0', '0', null, '0');
INSERT INTO `qf_article` VALUES ('3', '0', '调用公司简介', '', '', '', '<p>调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介调用公司简介</p>', '2015-11-18 10:44:04', '0', '0', '1', '', '', '', '', '', '', '', '', '0', '0', null, '0');
INSERT INTO `qf_article` VALUES ('4', '0', '调用联系我们', '', '', '', '<p>联系人：顾经理</p><p>手机：155-1503-0055</p><p>地址：中国 · 河南 · 安阳</p>', '2015-11-18 10:44:18', '0', '0', '1', '', '', '', '', '', '', '', '', '0', '0', null, '0');
INSERT INTO `qf_article` VALUES ('5', '4', '新闻中心', '', '', '', '', '2016-01-12 08:46:45', '0', '0', '0', '', '', '', '', '', '', null, null, '0', '1', '', '0');
INSERT INTO `qf_article` VALUES ('6', '4', '新闻中心', '', '', '', '', '2016-01-12 08:47:03', '0', '0', '0', '', '', '', '', '', '', null, null, '0', '1', '', '0');
INSERT INTO `qf_article` VALUES ('7', '4', '新闻中心', '', '', '', '', '2016-01-12 08:47:11', '0', '0', '0', '', '', '', '', '', '', null, null, '0', '1', '', '0');
INSERT INTO `qf_article` VALUES ('8', '4', '新闻中心', '', '', '', '', '2016-01-12 08:47:17', '0', '0', '0', '', '', '', '', '', '', null, null, '0', '1', '', '0');
INSERT INTO `qf_article` VALUES ('9', '4', '新闻中心', '', '', '', '', '2016-01-12 08:47:23', '0', '0', '0', '', '', '', '', '', '', null, null, '0', '1', '', '0');
INSERT INTO `qf_article` VALUES ('10', '4', '新闻中心', '', '', '', '', '2016-01-12 08:47:31', '0', '0', '0', '', '', '', '', '', '', null, null, '0', '1', '', '0');
INSERT INTO `qf_article` VALUES ('11', '4', '新闻中心新闻中心新闻中心新闻中心新闻中心新闻中心', '', '', '', '', '2016-01-12 08:47:41', '0', '0', '0', '', '', '', '', '', '', null, null, '0', '1', '', '0');
INSERT INTO `qf_article` VALUES ('12', '0', '商务合作', '', '', '', '', '2017-08-17 09:54:46', '0', '0', '0', '', '', '', '', '', '', '', '', '0', '0', null, '0');

-- ----------------------------
-- Table structure for qf_config
-- ----------------------------
DROP TABLE IF EXISTS `qf_config`;
CREATE TABLE `qf_config` (
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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COMMENT='配置表';

-- ----------------------------
-- Records of qf_config
-- ----------------------------
INSERT INTO `qf_config` VALUES ('1', 'web_url', 'http://www.ayxyaf.com', '网站URL', '', 'text', '1', '0');
INSERT INTO `qf_config` VALUES ('2', 'web_name', '文峰区新宇金属工艺制品', '网站名称', '', 'text', '1', '0');
INSERT INTO `qf_config` VALUES ('3', 'logo', '', '网站logo', '', 'file', '1', '0');
INSERT INTO `qf_config` VALUES ('4', 'web_open', '', '网站开启', '是,否', 'radio', '0', '0');
INSERT INTO `qf_config` VALUES ('5', 'icp_num', '', 'ICP备案', '', 'text', '1', '0');
INSERT INTO `qf_config` VALUES ('6', 'web_keywords', '', '网站关键字', '', 'textarea', '1', '0');
INSERT INTO `qf_config` VALUES ('7', 'web_description', '', '网站描述', '', 'textarea', '1', '0');
INSERT INTO `qf_config` VALUES ('8', 'switch_watermark', '0', '水印开关', '关闭,开启', 'radio', '4', '0');
INSERT INTO `qf_config` VALUES ('9', 'version', '4.00001', '版本号', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('10', 'mobile', '155-1503-0055', '手机号码', '', 'text', '1', '0');
INSERT INTO `qf_config` VALUES ('11', 'email', '', '邮箱', '', 'text', '1', '0');
INSERT INTO `qf_config` VALUES ('12', 'address', '中国 · 河南 · 安阳', '地址', '', 'text', '1', '0');
INSERT INTO `qf_config` VALUES ('13', 'web_watermark', '青峰网络', '文字水印', '', 'text', '4', '0');
INSERT INTO `qf_config` VALUES ('14', 'article_list', '<volist name=\"list\" id=\"vo\">\r\n    <li><a href=\"{$vo.url}\">{$vo.title}</a></li>\r\n</volist>', '文章列表', '', 'textarea', '2', '0');
INSERT INTO `qf_config` VALUES ('15', 'article_img_list', '<volist name=\"list\" id=\"vo\">							\r\n    <li>\r\n        <a href=\"{$vo.url}\"><img src=\"__ROOT__/__UPLOAD__/{$vo.img}\" alt=\"{$vo.title}\"></a>\r\n        <p>\r\n            <a href=\"{$vo.url}\"><strong>{$vo.title}</strong><br>\r\n            {$vo.description}<br>\r\n            {$vo.time}</a>\r\n        </p>\r\n    </li>\r\n</volist>', '图片文章混排', '', 'textarea', '2', '0');
INSERT INTO `qf_config` VALUES ('16', 'img_list', '<volist name=\"list\" id=\"vo\">\r\n<li>\r\n    <a href=\"{$vo.url}\"><img src=\"__ROOT__/__UPLOAD__/{$vo.img}\" alt=\"{$vo.title}\"><br><span>{$vo.title}</span></a>\r\n</li>\r\n</volist>', '图片列表', '', 'textarea', '2', '0');
INSERT INTO `qf_config` VALUES ('17', 'current_theme', 'Default', '模板选择', '', 'text', '4', '0');
INSERT INTO `qf_config` VALUES ('18', 'switch_upgrade', '1', '智能升级', '关闭,开启', 'radio', '0', '0');
INSERT INTO `qf_config` VALUES ('19', 'switch_order', '0', '在线订单开关', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('20', 'switch_introduction', '1', '公司介绍开关', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('21', 'switch_news', '1', '新闻中心开关', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('22', 'switch_contactus', '1', '联系我们开关', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('24', 'switch_message', '1', '在线留言开关', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('25', 'switch_jobs', '1', '在线招聘开关', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('26', 'linkman', '顾经理', '联系人', '', 'text', '1', '0');
INSERT INTO `qf_config` VALUES ('27', 'tel', '', '联系电话', '', 'text', '1', '0');
INSERT INTO `qf_config` VALUES ('28', 'fax', '', '传真', '', 'text', '1', '0');
INSERT INTO `qf_config` VALUES ('29', 'switch_mbaidu', '0', '百度手机搜索专卖', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('30', 'switch_product', '1', '产品展示开关', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('31', 'page_default', '10', '默认分页数', 'number', 'text', '4', '0');
INSERT INTO `qf_config` VALUES ('32', 'page_product', '8', '产品分页数', 'number', 'text', '4', '0');
INSERT INTO `qf_config` VALUES ('33', 'page_jobs', '2', '招聘分页数', 'number', 'text', '4', '0');
INSERT INTO `qf_config` VALUES ('34', 'code_statistics', '', '代码统计', '', 'textarea', '0', '0');
INSERT INTO `qf_config` VALUES ('35', 'baidu_map_x', '113.867976', '百度地图X', '', 'text', '3', '0');
INSERT INTO `qf_config` VALUES ('36', 'baidu_map_y', '35.291272', '百度地图Y', '', 'text', '3', '0');
INSERT INTO `qf_config` VALUES ('37', 'code_head', '', 'head代码', '', 'textarea', '4', '0');
INSERT INTO `qf_config` VALUES ('38', 'code_body', '', 'body代码', '', 'textarea', '4', '0');
INSERT INTO `qf_config` VALUES ('39', 'qfjob', '', '青峰人才', '', 'textarea', '-1', '0');
INSERT INTO `qf_config` VALUES ('40', 'switch_m_pc', '1', '手机显示样式', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('41', 'wx_code', '5ed8b26ea0786d3c', '微信标识', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('42', 'wx_user', '', '关注列表', '', 'text', '0', '0');
INSERT INTO `qf_config` VALUES ('43', 'page_custom', '8', '图片页数', 'number', 'text', '4', '0');
INSERT INTO `qf_config` VALUES ('44', 'other', 'copyright　© 2017　文峰区新宇金属工艺制品　all　rights　reserved', '底部信息', '', 'textarea', '1', '0');
INSERT INTO `qf_config` VALUES ('45', 'web_title', '文峰区新宇金属工艺制品', '公司名称', '', 'text', '1', '0');
INSERT INTO `qf_config` VALUES ('46', 'qq', '', 'QQ', '', 'text', '1', '0');
INSERT INTO `qf_config` VALUES ('47', 'scode', '', '统计代码', '', 'textarea', '1', '0');

-- ----------------------------
-- Table structure for qf_flash
-- ----------------------------
DROP TABLE IF EXISTS `qf_flash`;
CREATE TABLE `qf_flash` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL COMMENT '标题',
  `img` varchar(50) NOT NULL COMMENT '图片',
  `link` varchar(100) NOT NULL DEFAULT '#' COMMENT '链接',
  `order` tinyint(3) NOT NULL COMMENT '顺序',
  `open` char(1) NOT NULL DEFAULT '1' COMMENT '显示开关',
  `pc_m` tinyint(1) NOT NULL DEFAULT '0' COMMENT '手机或PC图片（0为PC，1为手机）',
  `is_home` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='导航轮播图片';

-- ----------------------------
-- Records of qf_flash
-- ----------------------------
INSERT INTO `qf_flash` VALUES ('1', '文峰区新宇金属工艺制品', '5994f8ad09bc9.jpg', '#', '0', '1', '0', '0');

-- ----------------------------
-- Table structure for qf_goods
-- ----------------------------
DROP TABLE IF EXISTS `qf_goods`;
CREATE TABLE `qf_goods` (
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
  `link` varchar(250) DEFAULT NULL COMMENT '外部链接',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Records of qf_goods
-- ----------------------------
INSERT INTO `qf_goods` VALUES ('10', '2', '保安咨询服务', '', '', '', '0.00', '', '2017-07-31 17:08:44', '0', '0', '0', '0', '999', '0', '', '', '', '', '', '', '');
INSERT INTO `qf_goods` VALUES ('9', '2', '保安技防服务', '', '', '', '0.00', '', '2017-07-31 17:08:38', '0', '0', '0', '0', '999', '0', '', '', '', '', '', '', '');
INSERT INTO `qf_goods` VALUES ('8', '2', '保安人防服务', '', '', '', '0.00', '', '2017-07-31 17:08:20', '0', '0', '0', '0', '999', '0', '', '', '', '', '', '', '');
INSERT INTO `qf_goods` VALUES ('11', '2', '保安管理服务', '', '', '', '0.00', '', '2017-07-31 17:08:49', '0', '0', '0', '0', '999', '0', '', '', '', '', '', '', '');
INSERT INTO `qf_goods` VALUES ('12', '2', '特种保安服务', '', '', '', '0.00', '', '2017-07-31 17:08:55', '0', '0', '0', '0', '999', '0', '', '', '', '', '', '', '');
INSERT INTO `qf_goods` VALUES ('13', '2', '停车场管理服务', '', '', '', '0.00', '', '2017-07-31 17:09:01', '0', '0', '0', '0', '999', '0', '', '', '', '', '', '', '');
INSERT INTO `qf_goods` VALUES ('14', '2', '电子报警服务', '', '', '', '0.00', '', '2017-07-31 17:09:07', '0', '0', '0', '0', '999', '0', '', '', '', '', '', '', '');
INSERT INTO `qf_goods` VALUES ('15', '2', '劳务派遣服务', '', '', '', '0.00', '', '2017-07-31 17:09:13', '0', '0', '0', '0', '999', '0', '', '', '', '', '', '', '');

-- ----------------------------
-- Table structure for qf_jobs
-- ----------------------------
DROP TABLE IF EXISTS `qf_jobs`;
CREATE TABLE `qf_jobs` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='企业招聘表';

-- ----------------------------
-- Records of qf_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for qf_log
-- ----------------------------
DROP TABLE IF EXISTS `qf_log`;
CREATE TABLE `qf_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` char(4) NOT NULL COMMENT '操作',
  `user` varchar(30) NOT NULL COMMENT '用户',
  `ip` varchar(20) NOT NULL COMMENT 'ip地址',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  `order` int(11) NOT NULL COMMENT '顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='后台日志表';

-- ----------------------------
-- Records of qf_log
-- ----------------------------
INSERT INTO `qf_log` VALUES ('6', '用户登录', 'ayytglyh', '127.0.0.1', '2016-04-19 10:46:13', '0');
INSERT INTO `qf_log` VALUES ('7', '用户登录', 'aywdba', '0.0.0.0', '2017-07-31 16:57:39', '0');
INSERT INTO `qf_log` VALUES ('8', '用户登录', 'ayxyaf', '0.0.0.0', '2017-08-17 09:48:31', '0');

-- ----------------------------
-- Table structure for qf_message
-- ----------------------------
DROP TABLE IF EXISTS `qf_message`;
CREATE TABLE `qf_message` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言表';

-- ----------------------------
-- Records of qf_message
-- ----------------------------

-- ----------------------------
-- Table structure for qf_order
-- ----------------------------
DROP TABLE IF EXISTS `qf_order`;
CREATE TABLE `qf_order` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of qf_order
-- ----------------------------

-- ----------------------------
-- Table structure for qf_synchro
-- ----------------------------
DROP TABLE IF EXISTS `qf_synchro`;
CREATE TABLE `qf_synchro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT NULL COMMENT '数据类型1新闻，2产品，3分类，4网参，5单页，6自助',
  `obj` smallint(6) NOT NULL COMMENT '数据编号',
  `check` varchar(32) DEFAULT NULL COMMENT '同步版本',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT ' 同步时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qf_synchro
-- ----------------------------

-- ----------------------------
-- Table structure for qf_type
-- ----------------------------
DROP TABLE IF EXISTS `qf_type`;
CREATE TABLE `qf_type` (
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
  `title_en` varchar(200) DEFAULT NULL,
  `upclass` varchar(100) DEFAULT NULL,
  `style` int(11) NOT NULL DEFAULT '0' COMMENT '展示类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of qf_type
-- ----------------------------
INSERT INTO `qf_type` VALUES ('1', '1,', '文章栏目', '0', '0', '0', '', '', '', null, null, null, '0');
INSERT INTO `qf_type` VALUES ('2', '2,', '产品中心', '0', '0', '2', '', '', '', null, null, null, '2');
INSERT INTO `qf_type` VALUES ('3', '3,', '人才招聘', '0', '0', '3', '', '', '', null, null, null, '0');
INSERT INTO `qf_type` VALUES ('4', '1,4,', '新闻动态', '1', '0', '1', '', '', '', '', '', '', '0');
INSERT INTO `qf_type` VALUES ('17', '2,17,', '审讯桌', '2', '1', '2', '', '', '', '', '', '', '2');
INSERT INTO `qf_type` VALUES ('6', '1,6,', '友情链接', '1', '0', '1', '', '', '', null, null, null, '0');
INSERT INTO `qf_type` VALUES ('7', '1,7,', '成功案例', '1', '0', '1', '', '', '', '', '', '', '2');
INSERT INTO `qf_type` VALUES ('16', '2,16,', '审讯椅', '2', '0', '2', '', '', '', '', '', '', '2');
INSERT INTO `qf_type` VALUES ('18', '2,18,', '审讯床', '2', '2', '2', '', '', '', '', '', '', '2');
INSERT INTO `qf_type` VALUES ('19', '2,19,', '醒酒椅', '2', '3', '2', '', '', '', '', '', '', '2');

-- ----------------------------
-- Table structure for qf_user
-- ----------------------------
DROP TABLE IF EXISTS `qf_user`;
CREATE TABLE `qf_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL COMMENT '用户名',
  `password` varchar(100) NOT NULL COMMENT '密码',
  `order` int(11) NOT NULL COMMENT '顺序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of qf_user
-- ----------------------------
INSERT INTO `qf_user` VALUES ('1', 'ayxyaf', 'ayxyaf17817', '0');
