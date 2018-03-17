-- MySQL dump 10.13  Distrib 5.5.53, for Win32 (AMD64)
--
-- Host: localhost    Database: yii2_dev
-- ------------------------------------------------------
-- Server version	5.5.53

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
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(125) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章标题',
  `brief` varchar(225) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章简介',
  `smallimg` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章图片',
  `bigimg` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章海报',
  `favorite` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '喜欢数',
  `collect` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数',
  `visited` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文章类型',
  `isbest` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '精品推荐',
  `isdraft` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '草稿箱',
  `isrecycle` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '回收站',
  `subject_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属专题',
  `content_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '内容ID',
  `created_by` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '作者',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `key_subject_id` (`subject_id`),
  KEY `key_content_id` (`content_id`),
  KEY `key_created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (3,'文章标题123','文章简介123','static/uploaded/article_20180316/cb438858082fed5.jpeg','static/uploaded/article_20180316/3ef5942a4c883b8.jpeg',0,0,0,0,1,0,0,5,3,1,1521183381,1521192250);
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_tag`
--

DROP TABLE IF EXISTS `article_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_tag` (
  `article_id` int(11) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '标签ID',
  KEY `key_article_id` (`article_id`),
  KEY `key_tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_tag`
--

LOCK TABLES `article_tag` WRITE;
/*!40000 ALTER TABLE `article_tag` DISABLE KEYS */;
INSERT INTO `article_tag` VALUES (3,20),(3,3);
/*!40000 ALTER TABLE `article_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('backend','1',1521289881),('backend','4',1521289935),('超级管理员','1',1521262113);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('/*',2,NULL,NULL,NULL,1521265612,1521265612),('/admin/*',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/assignment/*',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/assignment/assign',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/assignment/index',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/assignment/revoke',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/assignment/view',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/default/*',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/default/index',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/menu/*',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/menu/create',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/menu/delete',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/menu/index',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/menu/update',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/menu/view',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/permission/*',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/permission/assign',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/permission/create',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/permission/delete',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/permission/index',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/permission/remove',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/permission/update',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/permission/view',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/role/*',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/role/assign',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/role/create',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/role/delete',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/role/index',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/role/remove',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/role/update',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/role/view',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/route/*',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/route/assign',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/route/create',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/route/index',2,NULL,NULL,NULL,1521267689,1521267689),('/admin/route/refresh',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/route/remove',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/rule/*',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/rule/create',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/rule/delete',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/rule/index',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/rule/update',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/rule/view',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/user/*',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/user/activate',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/user/change-password',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/user/delete',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/user/index',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/user/login',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/user/logout',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/user/request-password-reset',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/user/reset-password',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/user/signup',2,NULL,NULL,NULL,1521267690,1521267690),('/admin/user/view',2,NULL,NULL,NULL,1521267690,1521267690),('/content/*',2,NULL,NULL,NULL,1521264768,1521264768),('/content/article/*',2,NULL,NULL,NULL,1521264768,1521264768),('/content/article/create',2,NULL,NULL,NULL,1521264768,1521264768),('/content/article/delete',2,NULL,NULL,NULL,1521264768,1521264768),('/content/article/index',2,NULL,NULL,NULL,1521264768,1521264768),('/content/article/update',2,NULL,NULL,NULL,1521264768,1521264768),('/content/article/upload',2,NULL,NULL,NULL,1521264768,1521264768),('/content/article/view',2,NULL,NULL,NULL,1521264768,1521264768),('/content/subject/*',2,NULL,NULL,NULL,1521264768,1521264768),('/content/subject/ajax-get-subjects',2,NULL,NULL,NULL,1521264768,1521264768),('/content/subject/create',2,NULL,NULL,NULL,1521264768,1521264768),('/content/subject/delete',2,NULL,NULL,NULL,1521264768,1521264768),('/content/subject/index',2,NULL,NULL,NULL,1521264768,1521264768),('/content/subject/update',2,NULL,NULL,NULL,1521264768,1521264768),('/content/subject/upload',2,NULL,NULL,NULL,1521264768,1521264768),('/content/subject/view',2,NULL,NULL,NULL,1521264768,1521264768),('/content/tag/*',2,NULL,NULL,NULL,1521264768,1521264768),('/content/tag/ajax-get-tags',2,NULL,NULL,NULL,1521264768,1521264768),('/content/tag/create',2,NULL,NULL,NULL,1521264768,1521264768),('/content/tag/delete',2,NULL,NULL,NULL,1521264768,1521264768),('/content/tag/index',2,NULL,NULL,NULL,1521264768,1521264768),('/content/tag/update',2,NULL,NULL,NULL,1521264768,1521264768),('/content/tag/view',2,NULL,NULL,NULL,1521264768,1521264768),('/debug/*',2,NULL,NULL,NULL,1521269695,1521269695),('/debug/default/*',2,NULL,NULL,NULL,1521269695,1521269695),('/debug/default/db-explain',2,NULL,NULL,NULL,1521269695,1521269695),('/debug/default/download-mail',2,NULL,NULL,NULL,1521269695,1521269695),('/debug/default/index',2,NULL,NULL,NULL,1521269695,1521269695),('/debug/default/toolbar',2,NULL,NULL,NULL,1521269695,1521269695),('/debug/default/view',2,NULL,NULL,NULL,1521269695,1521269695),('/debug/user/*',2,NULL,NULL,NULL,1521269695,1521269695),('/debug/user/reset-identity',2,NULL,NULL,NULL,1521269695,1521269695),('/debug/user/set-identity',2,NULL,NULL,NULL,1521269695,1521269695),('/gii/*',2,NULL,NULL,NULL,1521269995,1521269995),('/gii/default/*',2,NULL,NULL,NULL,1521269995,1521269995),('/gii/default/action',2,NULL,NULL,NULL,1521269995,1521269995),('/gii/default/diff',2,NULL,NULL,NULL,1521269995,1521269995),('/gii/default/index',2,NULL,NULL,NULL,1521269995,1521269995),('/gii/default/preview',2,NULL,NULL,NULL,1521269995,1521269995),('/gii/default/view',2,NULL,NULL,NULL,1521269995,1521269995),('/member/*',2,NULL,NULL,NULL,1521274171,1521274171),('/member/user/*',2,NULL,NULL,NULL,1521274171,1521274171),('/member/user/create',2,NULL,NULL,NULL,1521274171,1521274171),('/member/user/delete',2,NULL,NULL,NULL,1521274171,1521274171),('/member/user/index',2,NULL,NULL,NULL,1521274171,1521274171),('/member/user/update',2,NULL,NULL,NULL,1521274171,1521274171),('/member/user/view',2,NULL,NULL,NULL,1521274171,1521274171),('/site/*',2,NULL,NULL,NULL,1521270085,1521270085),('/site/error',2,NULL,NULL,NULL,1521270085,1521270085),('/site/index',2,NULL,NULL,NULL,1521270085,1521270085),('/site/login',2,NULL,NULL,NULL,1521270085,1521270085),('/site/logout',2,NULL,NULL,NULL,1521270085,1521270085),('Admin',2,'admin 超级管理员',NULL,NULL,1521261908,1521265570),('backend',2,'后台登陆权限',NULL,NULL,1521289589,1521289589),('超级管理员',1,'后台超级管理员',NULL,NULL,1521262059,1521262059);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('Admin','/*'),('超级管理员','Admin');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '文章内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content`
--

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` VALUES (3,'文章内容');
/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (15,'专题',16,'/content/subject/index',NULL,NULL),(16,'内容管理',NULL,NULL,11,NULL),(17,'标签',16,'/content/tag/index',NULL,NULL),(18,'文章',16,'/content/article/index',NULL,NULL),(19,'权限管理',NULL,NULL,12,NULL),(22,'角色',19,'/admin/role/index',NULL,NULL),(23,'权限',19,'/admin/permission/index',NULL,NULL),(24,'路由',19,'/admin/route/index',NULL,NULL),(25,'规则',19,'/admin/rule/index',NULL,NULL),(26,'菜单',32,'/admin/menu/index',NULL,NULL),(27,'系统工具',NULL,NULL,18,NULL),(28,'Debug',27,'/debug/default/index',NULL,NULL),(29,'Gii',27,'/gii/default/index',NULL,NULL),(30,'成员管理',NULL,NULL,14,NULL),(31,'用户',30,'/member/user/index',NULL,NULL),(32,'站点设置',NULL,NULL,17,NULL);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1521037386),('m130524_201442_init',1521037387),('m180315_032627_create_subject_table',1521085634),('m180315_032645_create_notice_table',1521085634),('m180315_080102_create_tag_table',1521101279),('m180315_133825_create_article_tag_table',1521122266),('m180315_133849_create_content_table',1521122266),('m180315_133907_create_article_table',1521122268),('m140602_111327_create_menu_table',1521257631),('m160312_050000_create_user',1521257631),('m140506_102106_rbac_init',1521258241),('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1521258241),('m180317_074845_user_add_isvip_column',1521290436);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notice`
--

DROP TABLE IF EXISTS `notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `notice` text COLLATE utf8_unicode_ci NOT NULL COMMENT '布告',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice`
--

LOCK TABLES `notice` WRITE;
/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
INSERT INTO `notice` VALUES (4,'文明上网，理性发言。'),(5,'好好学习，天天向上。'),(6,'啊实打实的');
/*!40000 ALTER TABLE `notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(18) COLLATE utf8_unicode_ci NOT NULL COMMENT '专题名',
  `desc` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `logo` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Logo',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '类型',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `notice_id` int(11) NOT NULL DEFAULT '0' COMMENT '布告',
  `created_by` int(11) NOT NULL DEFAULT '0' COMMENT '创建者',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `key_created_by` (`created_by`),
  KEY `key_created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (4,'php','php是最好的语言','static/uploaded/20180315/69640df219eb2e0.jpg',0,0,4,1,1521114277,1521114277),(5,'Java','最强大的语言','static/uploaded/20180315/a281b6695a1dfd0.jpg',0,0,5,1,1521114420,1521114420),(6,'void','威威威威威威威威威威','static/uploaded/20180316/f47f1d3dfd33fd2.jpeg',0,0,6,1,1521169732,1521169732);
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标签名',
  `subject_id` int(11) NOT NULL DEFAULT '0' COMMENT '布告',
  `created_by` int(11) NOT NULL DEFAULT '0' COMMENT '创建者',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `key_created_by` (`created_by`),
  KEY `key_created_at` (`created_at`),
  KEY `key_subject_id` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'phpcms',4,1,1521114491,1521114491),(2,'dedecms',4,1,1521114520,1521114520),(3,'JavaEE',5,1,1521114573,1521114573),(4,'JavaSE',5,1,1521119422,1521119422),(20,'hh',5,1,1521183381,1521183381),(23,'ecshop',4,1,1521184355,1521184355),(24,'discuz',4,1,1521184355,1521184355);
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `isvip` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'vip',
  `photo` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','Xp2tgeYK2w3r-P_E3l5eLi9x1olpVDW2','$2y$13$2STEiXYhcmSE7dWip0ilyOguZLvsHPCzLvM4zWV2FXWbe3Rq8rDLi','eMBaAhm0W6w83S-ZjCz07e1hnqvQwVof_1521038597','83849929@qq.com',10,0,'',1521038597,1521038597),(4,'wangye','cOZMl62nHZfXqFrI4X354S3XAny_2EmH','$2y$13$ly7ro/X2395/GYfDaqmltedgjCUD8JjuZ3KTwcUDfePLL7bFg0Qve','tca6UfcQZXlYSR3X3NYGLI6jjbd_Y6ND_1521289920','wangye@qq.com',10,0,'',1521289919,1521289919),(5,'wangsha','IOknbn9S-f6paoBNQuZ5UQ3TvOMagMjS','$2y$13$kCtVq7kgFnpvgJMXuJxu4OlxzZBM7iFRZZoRWifNTyXt8bIehVLie','Xb092bkI4q_629ua_qMvYJ_VEnSIbieU_1521290548','wangsha@qq.com',10,0,'',1521290547,1521290547);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-17 22:38:36
