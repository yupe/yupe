USE `yupe_test`;

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
DROP TABLE IF EXISTS `yupe_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yupe_migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_migrations_module` (`module`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `yupe_migrations` WRITE;
/*!40000 ALTER TABLE `yupe_migrations` DISABLE KEYS */;
INSERT INTO `yupe_migrations` VALUES (1,'comment','m000000_000000_comment_base',1379742895);
/*!40000 ALTER TABLE `yupe_migrations` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `yupe_user_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yupe_user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `first_name` varchar(250) DEFAULT NULL,
  `middle_name` varchar(250) DEFAULT NULL,
  `last_name` varchar(250) DEFAULT NULL,
  `nick_name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `birth_date` date DEFAULT NULL,
  `site` varchar(250) NOT NULL DEFAULT '',
  `about` varchar(250) NOT NULL DEFAULT '',
  `location` varchar(250) NOT NULL DEFAULT '',
  `online_status` varchar(250) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL,
  `salt` char(32) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '2',
  `access_level` int(11) NOT NULL DEFAULT '0',
  `last_visit` datetime DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  `registration_ip` varchar(50) NOT NULL,
  `activation_ip` varchar(50) NOT NULL,
  `avatar` varchar(150) DEFAULT NULL,
  `use_gravatar` tinyint(1) NOT NULL DEFAULT '1',
  `activate_key` char(32) NOT NULL,
  `email_confirm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_user_user_nick_name` (`nick_name`),
  UNIQUE KEY `ux_yupe_user_user_email` (`email`),
  KEY `ix_yupe_user_user_status` (`status`),
  KEY `ix_yupe_user_user_email_confirm` (`email_confirm`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `yupe_user_user` WRITE;
/*!40000 ALTER TABLE `yupe_user_user` DISABLE KEYS */;
INSERT INTO `yupe_user_user` VALUES (1,'2013-09-28 22:57:41','2013-09-28 22:57:41','','','','yupe','yupe@localhost',0,NULL,'','','','','','',1,1,'2013-10-02 01:20:05','2013-09-28 22:57:41','127.0.0.1','127.0.0.1',NULL,1,'',1);
/*!40000 ALTER TABLE `yupe_user_user` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `yupe_comment_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yupe_comment_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `model` varchar(100) NOT NULL,
  `model_id` int(11) NOT NULL,
  `url` varchar(150) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `text` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_yupe_comment_comment_status` (`status`),
  KEY `ix_yupe_comment_comment_model_model_id` (`model`,`model_id`),
  KEY `ix_yupe_comment_comment_model` (`model`),
  KEY `ix_yupe_comment_comment_model_id` (`model_id`),
  KEY `ix_yupe_comment_comment_user_id` (`user_id`),
  KEY `ix_yupe_comment_comment_parent_id` (`parent_id`),
  CONSTRAINT `fk_yupe_comment_comment_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `yupe_comment_comment` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_comment_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `yupe_comment_comment` WRITE;
/*!40000 ALTER TABLE `yupe_comment_comment` DISABLE KEYS */;
INSERT INTO `yupe_comment_comment` VALUES (1,NULL,1,'Blog',1,'','2013-10-02 03:55:46','yupe','yupe@localhost','Level-1 Comment-1',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (2,NULL,1,'Blog',1,'','2013-10-02 03:55:51','yupe','yupe@localhost','Level-1 Comment-2',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (3,NULL,1,'Blog',1,'','2013-10-02 03:55:56','yupe','yupe@localhost','Level-1 Comment-3',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (4,2,1,'Blog',1,'','2013-10-02 03:56:05','yupe','yupe@localhost','Level-2 Comment-1',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (5,2,1,'Blog',1,'','2013-10-02 03:56:17','yupe','yupe@localhost','Level-2 Comment-2',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (6,2,1,'Blog',1,'','2013-10-02 03:56:41','yupe','yupe@localhost','Level-2 Comment-3',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (7,5,1,'Blog',1,'','2013-10-02 03:56:59','yupe','yupe@localhost','Level-3 Comment-1',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (8,5,1,'Blog',1,'','2013-10-02 03:57:12','yupe','yupe@localhost','Level-3 Comment-2',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (9,5,1,'Blog',1,'','2013-10-02 03:57:25','yupe','yupe@localhost','Level-3 Comment-3',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (10,8,1,'Blog',1,'','2013-10-02 03:58:29','yupe','yupe@localhost','Level-4 Comment-1',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (11,10,1,'Blog',1,'','2013-10-02 03:58:50','yupe','yupe@localhost','Level-5 Comment-1',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (12,11,1,'Blog',1,'','2013-10-02 03:59:14','yupe','yupe@localhost','Level-6 Comment-1',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (13,12,1,'Blog',1,'','2013-10-02 03:59:28','yupe','yupe@localhost','Level-7 Comment-1',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (14,13,1,'Blog',1,'','2013-10-02 03:59:40','yupe','yupe@localhost','Level-8 Comment-1',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (15,14,1,'Blog',1,'','2013-10-02 03:59:54','yupe','yupe@localhost','Level-9 Comment-1',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (16,15,1,'Blog',1,'','2013-10-02 04:00:05','yupe','yupe@localhost','Level-10 Comment-1',1,'127.0.0.1');
INSERT INTO `yupe_comment_comment` VALUES (17,16,1,'Blog',1,'','2013-10-02 04:00:20','yupe','yupe@localhost','Level-11 Comment-1',1,'127.0.0.1');
/*!40000 ALTER TABLE `yupe_comment_comment` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

