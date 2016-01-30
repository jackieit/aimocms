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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='结点分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_node`
--

LOCK TABLES `ezs_node` WRITE;
/*!40000 ALTER TABLE `ezs_node` DISABLE KEYS */;
INSERT INTO `ezs_node` VALUES (1,1,1,'默认站点',1,1,4,0,'',1,NULL,1,'index','','','',''),(2,1,2,'资质荣誉',1,2,3,1,'honor',1,'',1,'honor.php','honor-detail.php','','','');
/*!40000 ALTER TABLE `ezs_node` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='内容模型表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_cm`
--

LOCK TABLES `ezs_cm` WRITE;
/*!40000 ALTER TABLE `ezs_cm` DISABLE KEYS */;
INSERT INTO `ezs_cm` VALUES (1,'文章模型','article',1,0,1,NULL,NULL,NULL),(2,'资质荣誉','honor',2,0,1,'','title','title,img,price');
/*!40000 ALTER TABLE `ezs_cm` ENABLE KEYS */;
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
  `options` text COLLATE utf8_unicode_ci COMMENT 'ActiveForm 表单Option',
  PRIMARY KEY (`id`),
  KEY `cmid` (`cm_id`),
  CONSTRAINT `ezs_cm_field` FOREIGN KEY (`cm_id`) REFERENCES `ezs_cm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='内容模型表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_cm_field`
--

LOCK TABLES `ezs_cm_field` WRITE;
/*!40000 ALTER TABLE `ezs_cm_field` DISABLE KEYS */;
INSERT INTO `ezs_cm_field` VALUES (1,1,'title','标题','','string','80',0,'textInput','',1,NULL),(2,1,'color','标题颜色','','string','10',0,'textInput','',1,NULL),(3,1,'author','作者','','string','45',0,'textInput','',1,NULL),(4,1,'from','文章来源','','string','60',0,'textInput','',1,NULL),(5,1,'photo','图片','','string','60',0,'textInput','',1,NULL),(6,1,'intro','简介','','string','240',0,'textarea','',1,NULL),(7,1,'content','详细内容','','text','0',0,'textarea','',1,NULL),(8,1,'tpl_detail','详细内容模板','','text','0',0,'textarea','',1,NULL),(9,1,'file_name','文件名','','text','0',0,'textarea','',1,NULL),(10,1,'slug','固定连接','','text','0',0,'textInput','',1,NULL),(11,1,'seo_title','SEO标题','','string','80',0,'textInput','',1,NULL),(12,1,'seo_keyword','SEO关键字','','string','240',0,'textInput','',1,NULL),(13,1,'seo_description','SEO描述','','string','120',0,'textarea','',1,NULL),(14,2,'title','标题','请输入荣誉名称','string','80',0,'textInput','',2,''),(15,2,'getdate','获取时间','请输入何时何地获取此荣誉','date','',0,'datePicker','',2,''),(16,2,'kind','荣誉类型','请输入荣誉属于何种类型','smallInteger','',0,'dropDownList','1=>本地荣誉\r\n2=>山东荣誉\r\n3=>全国荣誉',2,''),(17,2,'intro','简介','','text','',0,'textarea','',2,'[\'rows\'=>2]'),(18,2,'detail','详情','','text','',0,'richEditor','',2,'\'rows\'=>20'),(19,2,'photo','图片','','string','80',0,'fileInput','',2,''),(20,2,'field','字段类型测试','','smallInteger','',0,'radioList','select name,label from {{%cm_field}} where cm_id=1',2,'');
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
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `getdate` date DEFAULT NULL COMMENT '获取时间',
  `kind` smallint(6) NOT NULL DEFAULT '0' COMMENT '荣誉类型',
  `intro` text COLLATE utf8_unicode_ci COMMENT '简介',
  `detail` text COLLATE utf8_unicode_ci COMMENT '详情',
  `photo` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `field` smallint(6) NOT NULL DEFAULT '0' COMMENT '字段类型测试',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='自定义模型资质荣誉';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ezs_cm_honor`
--

LOCK TABLES `ezs_cm_honor` WRITE;
/*!40000 ALTER TABLE `ezs_cm_honor` DISABLE KEYS */;
INSERT INTO `ezs_cm_honor` VALUES (1,'',NULL,0,NULL,NULL,'',0);
/*!40000 ALTER TABLE `ezs_cm_honor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-30 11:50:26
