-- MySQL dump 10.13  Distrib 5.7.9, for osx10.9 (x86_64)
--
-- Host: localhost    Database: aimocms
-- ------------------------------------------------------
-- Server version	5.7.9

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ezs_auth_assignment`
--

DROP TABLE IF EXISTS `ezs_auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `ezs_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `ezs_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_auth_assignment`
--

LOCK TABLES `ezs_auth_assignment` WRITE;
/*!40000 ALTER TABLE `ezs_auth_assignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_auth_category`
--

DROP TABLE IF EXISTS `ezs_auth_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_auth_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='权限定义分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_auth_category`
--

LOCK TABLES `ezs_auth_category` WRITE;
/*!40000 ALTER TABLE `ezs_auth_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_auth_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_auth_item`
--

DROP TABLE IF EXISTS `ezs_auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `ezs_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `ezs_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_auth_item`
--

LOCK TABLES `ezs_auth_item` WRITE;
/*!40000 ALTER TABLE `ezs_auth_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_auth_item_child`
--

DROP TABLE IF EXISTS `ezs_auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `ezs_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ezs_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ezs_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `ezs_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_auth_item_child`
--

LOCK TABLES `ezs_auth_item_child` WRITE;
/*!40000 ALTER TABLE `ezs_auth_item_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_auth_role`
--

DROP TABLE IF EXISTS `ezs_auth_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_auth_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色分类',
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `description` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '角色描述',
  `rules` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '定义rule class',
  `controllers` text COLLATE utf8_unicode_ci COMMENT '允许访问控制器',
  `actions` text COLLATE utf8_unicode_ci COMMENT '允许访问动作ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='权限预定义最小角色';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_auth_role`
--

LOCK TABLES `ezs_auth_role` WRITE;
/*!40000 ALTER TABLE `ezs_auth_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_auth_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_auth_rule`
--

DROP TABLE IF EXISTS `ezs_auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_auth_rule`
--

LOCK TABLES `ezs_auth_rule` WRITE;
/*!40000 ALTER TABLE `ezs_auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_cm`
--

DROP TABLE IF EXISTS `ezs_cm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_cm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `tab` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '表名称',
  `is_inner` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否内置',
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '站点ID',
  `tab_index` tinyint(1) NOT NULL DEFAULT '0' COMMENT '对应索引表',
  `rules` text COLLATE utf8_unicode_ci COMMENT '数据来源',
  `title_field` text COLLATE utf8_unicode_ci COMMENT '标题字段',
  `select_field` text COLLATE utf8_unicode_ci COMMENT '列表字段',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='内容模型表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_cm`
--

LOCK TABLES `ezs_cm` WRITE;
/*!40000 ALTER TABLE `ezs_cm` DISABLE KEYS */;
INSERT INTO `ezs_cm` VALUES (1,'文章模型','article',1,0,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ezs_cm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_cm_article`
--

DROP TABLE IF EXISTS `ezs_cm_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_cm_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `color` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题颜色',
  `author` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `from` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章来源',
  `photo` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `intro` varchar(240) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `content` text COLLATE utf8_unicode_ci COMMENT '详细内容',
  `seo_title` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keyword` varchar(240) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `seo_description` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `tpl_detail` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '详细内容页模板',
  `file_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `slug` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '固定连接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='文章内容表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_cm_article`
--

LOCK TABLES `ezs_cm_article` WRITE;
/*!40000 ALTER TABLE `ezs_cm_article` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_cm_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_cm_field`
--

DROP TABLE IF EXISTS `ezs_cm_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_cm_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cm_id` int(11) NOT NULL DEFAULT '0' COMMENT '内容模型ID',
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '字段名称',
  `label` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '字段说明',
  `hint` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '字段描述',
  `data_type` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '数据类型',
  `length` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '字段长度',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `input` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '表单输入类型',
  `source` text COLLATE utf8_unicode_ci COMMENT '数据来源',
  `is_inner` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否内置',
  PRIMARY KEY (`id`),
  KEY `cmid` (`cm_id`),
  CONSTRAINT `ezs_cm_field` FOREIGN KEY (`cm_id`) REFERENCES `ezs_cm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='内容模型表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_cm_field`
--

LOCK TABLES `ezs_cm_field` WRITE;
/*!40000 ALTER TABLE `ezs_cm_field` DISABLE KEYS */;
INSERT INTO `ezs_cm_field` VALUES (1,1,'title','标题','','string','80',0,'textInput','',1),(2,1,'color','标题颜色','','string','10',0,'textInput','',1),(3,1,'author','作者','','string','45',0,'textInput','',1),(4,1,'from','文章来源','','string','60',0,'textInput','',1),(5,1,'photo','图片','','string','60',0,'textInput','',1),(6,1,'intro','简介','','string','240',0,'textarea','',1),(7,1,'content','详细内容','','text','0',0,'textarea','',1),(8,1,'tpl_detail','详细内容模板','','text','0',0,'textarea','',1),(9,1,'file_name','文件名','','text','0',0,'textarea','',1),(10,1,'slug','固定连接','','text','0',0,'textInput','',1),(11,1,'seo_title','SEO标题','','string','80',0,'textInput','',1),(12,1,'seo_keyword','SEO关键字','','string','240',0,'textInput','',1),(13,1,'seo_description','SEO描述','','string','120',0,'textarea','',1);
/*!40000 ALTER TABLE `ezs_cm_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_cm_honor`
--

DROP TABLE IF EXISTS `ezs_cm_honor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_cm_honor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='自定义模型资质荣誉';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_cm_honor`
--

LOCK TABLES `ezs_cm_honor` WRITE;
/*!40000 ALTER TABLE `ezs_cm_honor` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_cm_honor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_cm_index`
--

DROP TABLE IF EXISTS `ezs_cm_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_cm_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cm_id` int(11) NOT NULL DEFAULT '0' COMMENT '内容模型ID',
  `content_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联内容ID',
  `node_id` int(11) NOT NULL DEFAULT '0' COMMENT '结点分类ID',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父内容ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `top` smallint(6) NOT NULL DEFAULT '0' COMMENT '置顶',
  `pink` smallint(6) NOT NULL DEFAULT '0' COMMENT '精华',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `content` (`cm_id`,`node_id`,`content_id`),
  KEY `sort` (`user_id`,`top`,`pink`,`sort`,`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='内容索引表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_cm_index`
--

LOCK TABLES `ezs_cm_index` WRITE;
/*!40000 ALTER TABLE `ezs_cm_index` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_cm_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_cm_profile`
--

DROP TABLE IF EXISTS `ezs_cm_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_cm_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='自定义模型用户资料';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_cm_profile`
--

LOCK TABLES `ezs_cm_profile` WRITE;
/*!40000 ALTER TABLE `ezs_cm_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_cm_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_domain`
--

DROP TABLE IF EXISTS `ezs_domain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_domain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '站点ID',
  `domain` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '域名',
  `main` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否主域名',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `ezs_domain` FOREIGN KEY (`site_id`) REFERENCES `ezs_site` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='站点域名表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_domain`
--

LOCK TABLES `ezs_domain` WRITE;
/*!40000 ALTER TABLE `ezs_domain` DISABLE KEYS */;
INSERT INTO `ezs_domain` VALUES (1,1,'www.example.com',1),(2,1,'example.com',0);
/*!40000 ALTER TABLE `ezs_domain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_log`
--

DROP TABLE IF EXISTS `ezs_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kind` smallint(6) NOT NULL DEFAULT '0' COMMENT '日志类型',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `data` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '操作内容',
  `ip` int(11) NOT NULL DEFAULT '0' COMMENT '操作IP',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `kind` (`kind`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='操作记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_log`
--

LOCK TABLES `ezs_log` WRITE;
/*!40000 ALTER TABLE `ezs_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_migration`
--

DROP TABLE IF EXISTS `ezs_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_migration`
--

LOCK TABLES `ezs_migration` WRITE;
/*!40000 ALTER TABLE `ezs_migration` DISABLE KEYS */;
INSERT INTO `ezs_migration` VALUES ('m000000_000000_base',1452817816),('m130524_201442_init',1453612208),('m140506_102106_rbac_init',1453612208),('m160113_022635_init_cms',1453612208);
/*!40000 ALTER TABLE `ezs_migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_node`
--

DROP TABLE IF EXISTS `ezs_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '站点ID',
  `cm_id` int(11) NOT NULL DEFAULT '0' COMMENT '内容模型ID',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '结点名称',
  `is_real` tinyint(1) NOT NULL DEFAULT '0' COMMENT '实虚结点',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT '左值',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT '右值',
  `depth` int(11) NOT NULL DEFAULT '0' COMMENT '级点深度',
  `slug` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '英文标识slug',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '结点状态',
  `v_nodes` text COLLATE utf8_unicode_ci COMMENT '虚结点包含结点',
  `workflow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '投稿工作流',
  `tpl_index` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '首页模板',
  `tpl_detail` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '详细内容页模板',
  `seo_title` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keyword` varchar(240) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `seo_description` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='结点分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_node`
--

LOCK TABLES `ezs_node` WRITE;
/*!40000 ALTER TABLE `ezs_node` DISABLE KEYS */;
INSERT INTO `ezs_node` VALUES (1,1,1,'默认站点',1,1,18,0,'',1,NULL,1,'index','','','',''),(2,1,1,'关于我们',1,2,7,1,'first',1,'',1,'','','','',''),(3,1,1,'资质荣誉',1,3,6,2,'honor',1,'',1,'','','','',''),(4,1,1,'产品管理',1,8,13,1,'product',1,'',1,'','','','',''),(5,1,1,'信安设备',1,9,10,2,'anquan',1,'',1,'','','','',''),(6,1,1,'软件产品',1,11,12,2,'soft',1,'',1,'','','','',''),(7,1,1,'联系我们',1,14,17,1,'contact',1,'',1,'','','','',''),(8,1,1,'在线交流',1,15,16,2,'feedback',1,'',1,'','','','',''),(9,1,1,'ISO认证',1,4,5,3,'iso',1,'',1,'','','','','');
/*!40000 ALTER TABLE `ezs_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_setting`
--

DROP TABLE IF EXISTS `ezs_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_setting` (
  `var` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '变量',
  `val` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '变量值',
  `is_inner` tinyint(1) NOT NULL DEFAULT '2' COMMENT '是否内置',
  UNIQUE KEY `var` (`var`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统设置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_setting`
--

LOCK TABLES `ezs_setting` WRITE;
/*!40000 ALTER TABLE `ezs_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_site`
--

DROP TABLE IF EXISTS `ezs_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '站点名称',
  `template` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '模板路径',
  `is_publish` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否独立发布',
  `path` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '发布路径',
  `dsn` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '发布DSN',
  `url` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '站点URL',
  `res_path` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '资源发布路径',
  `res_url` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '资源发布URL',
  `page_404` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '404页面模板',
  `beian` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'ICP备案号',
  `seo_title` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keyword` varchar(240) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `seo_description` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='站点表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_site`
--

LOCK TABLES `ezs_site` WRITE;
/*!40000 ALTER TABLE `ezs_site` DISABLE KEYS */;
INSERT INTO `ezs_site` VALUES (1,'默认站点','default',0,'','','@web',' @frontend/web/static','@web/static/','','','','','');
/*!40000 ALTER TABLE `ezs_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_site_config`
--

DROP TABLE IF EXISTS `ezs_site_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_site_config` (
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '站点ID',
  `var` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '变量',
  `val` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '变量值',
  PRIMARY KEY (`site_id`,`var`),
  CONSTRAINT `ezs_site_config` FOREIGN KEY (`site_id`) REFERENCES `ezs_site` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='站点设置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_site_config`
--

LOCK TABLES `ezs_site_config` WRITE;
/*!40000 ALTER TABLE `ezs_site_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_site_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_user`
--

DROP TABLE IF EXISTS `ezs_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_user`
--

LOCK TABLES `ezs_user` WRITE;
/*!40000 ALTER TABLE `ezs_user` DISABLE KEYS */;
INSERT INTO `ezs_user` VALUES (1,'admin','EkmeWfKlpqsxdN53Jr_VeOgZkmePsuTM','$2y$13$eGk3JW51BFokL1QpXeF.xO7AluEPF8E54WuUMKpXYAygb9DEGGhsC',NULL,'w@vlongbiz.com',10,1453612208,1453612208);
/*!40000 ALTER TABLE `ezs_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_user_admin`
--

DROP TABLE IF EXISTS `ezs_user_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_user_admin` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `site_ids` text COLLATE utf8_unicode_ci COMMENT '管理站点ID',
  `node_ids` text COLLATE utf8_unicode_ci COMMENT '管理结点ID',
  `cm_ids` text COLLATE utf8_unicode_ci COMMENT '管理内容模型ID',
  `allow_ips` text COLLATE utf8_unicode_ci COMMENT '允许登录IP地址',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `ezs_user_admin` FOREIGN KEY (`user_id`) REFERENCES `ezs_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_user_admin`
--

LOCK TABLES `ezs_user_admin` WRITE;
/*!40000 ALTER TABLE `ezs_user_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_user_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_workflow`
--

DROP TABLE IF EXISTS `ezs_workflow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_workflow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '工作流名称',
  `intro` text COLLATE utf8_unicode_ci COMMENT '简介',
  `is_inner` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否内置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_workflow`
--

LOCK TABLES `ezs_workflow` WRITE;
/*!40000 ALTER TABLE `ezs_workflow` DISABLE KEYS */;
INSERT INTO `ezs_workflow` VALUES (1,'投稿既发布','',1),(2,'一级审核','投稿->编辑->审核发布',1);
/*!40000 ALTER TABLE `ezs_workflow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_workflow_log`
--

DROP TABLE IF EXISTS `ezs_workflow_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_workflow_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step_id` int(11) NOT NULL DEFAULT '0' COMMENT '步骤ID',
  `content_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联内容ID',
  `node_id` int(11) NOT NULL DEFAULT '0' COMMENT '结点分类ID',
  `note` varchar(140) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '简介',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_workflow_log`
--

LOCK TABLES `ezs_workflow_log` WRITE;
/*!40000 ALTER TABLE `ezs_workflow_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezs_workflow_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_workflow_state`
--

DROP TABLE IF EXISTS `ezs_workflow_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_workflow_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '步骤名称',
  `val` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态值',
  `is_inner` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否内置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流状态表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_workflow_state`
--

LOCK TABLES `ezs_workflow_state` WRITE;
/*!40000 ALTER TABLE `ezs_workflow_state` DISABLE KEYS */;
INSERT INTO `ezs_workflow_state` VALUES (1,'新增',0,1),(2,'删除',-1,1),(3,'已投搞',1,1),(4,'被驳回',3,1),(5,'已录用',3,1);
/*!40000 ALTER TABLE `ezs_workflow_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezs_workflow_step`
--

DROP TABLE IF EXISTS `ezs_workflow_step`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ezs_workflow_step` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wf_id` int(11) NOT NULL DEFAULT '0' COMMENT '工作流名称',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色ID',
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '工作流操作名称',
  `before_state` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '操作之前值',
  `after_state` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '操作之后值',
  `append_note` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作后是否附加说明',
  `intro` text COLLATE utf8_unicode_ci COMMENT '简介',
  PRIMARY KEY (`id`),
  KEY `ezs_workflow_step` (`wf_id`),
  CONSTRAINT `ezs_workflow_step` FOREIGN KEY (`wf_id`) REFERENCES `ezs_workflow` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_workflow_step`
--

LOCK TABLES `ezs_workflow_step` WRITE;
/*!40000 ALTER TABLE `ezs_workflow_step` DISABLE KEYS */;
INSERT INTO `ezs_workflow_step` VALUES (1,1,0,'投稿自动发布','1','2',0,'');
/*!40000 ALTER TABLE `ezs_workflow_step` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-24 17:00:54
