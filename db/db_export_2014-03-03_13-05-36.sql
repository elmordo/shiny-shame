-- MySQL dump 10.14  Distrib 5.5.33-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: micropic
-- ------------------------------------------------------
-- Server version	5.5.33-MariaDB

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
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collections` (
  `collection_id` int(11) NOT NULL AUTO_INCREMENT,
  `serie_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `comment` text,
  `comment_html` text,
  `tag` varchar(16) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `access_permisions` varchar(9) NOT NULL DEFAULT 'rwdr--r--',
  PRIMARY KEY (`collection_id`),
  KEY `experiment_id` (`serie_id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `collections_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `collections_ibfk_5` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE SET NULL,
  CONSTRAINT `collections_ibfk_6` FOREIGN KEY (`serie_id`) REFERENCES `series` (`serie_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collections`
--

LOCK TABLES `collections` WRITE;
/*!40000 ALTER TABLE `collections` DISABLE KEYS */;
INSERT INTO `collections` VALUES (1,1,'pc',NULL,NULL,'pc',1,NULL,'rwdr--r--'),(2,1,'h',NULL,NULL,'h',1,NULL,'rwdr--r--'),(3,1,'h',NULL,NULL,'h',1,NULL,'rwdr--r--');
/*!40000 ALTER TABLE `collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collections_have_frames`
--

DROP TABLE IF EXISTS `collections_have_frames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collections_have_frames` (
  `frame_id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  PRIMARY KEY (`collection_id`,`frame_id`),
  KEY `frame_id` (`frame_id`),
  CONSTRAINT `collections_have_frames_ibfk_1` FOREIGN KEY (`frame_id`) REFERENCES `frames` (`frame_id`) ON DELETE CASCADE,
  CONSTRAINT `collections_have_frames_ibfk_2` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`collection_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collections_have_frames`
--

LOCK TABLES `collections_have_frames` WRITE;
/*!40000 ALTER TABLE `collections_have_frames` DISABLE KEYS */;
INSERT INTO `collections_have_frames` VALUES (2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(30,3),(31,3),(32,3),(33,3),(34,3),(35,3),(36,3),(37,3),(38,3),(39,3),(40,3),(41,3),(42,3),(43,3),(44,3),(45,3),(46,3),(47,3),(48,3),(49,3),(50,3),(51,3),(52,3),(53,3),(54,3),(55,3),(56,3),(57,3),(58,3),(59,3),(60,3),(61,3),(62,3),(63,3),(64,3),(65,3),(66,3),(67,3),(68,3),(69,3),(70,3),(71,3),(72,3),(73,3),(74,3),(75,3),(76,3),(77,3),(78,3),(79,3),(80,3),(81,3),(82,3),(83,3),(84,3),(85,3),(86,3),(87,3),(88,3),(89,3),(90,3),(91,3),(92,3),(93,3),(94,3),(95,3),(96,3),(97,3),(98,3);
/*!40000 ALTER TABLE `collections_have_frames` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiments`
--

DROP TABLE IF EXISTS `experiments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiments` (
  `experiment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `microscope_id` int(11) DEFAULT NULL,
  `name` varchar(128) NOT NULL,
  `comment` text,
  `comment_html` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `begins` datetime DEFAULT NULL,
  `ends` datetime DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `access_permisions` varchar(9) NOT NULL DEFAULT 'rwdr--r--',
  PRIMARY KEY (`experiment_id`),
  KEY `microscope_id` (`microscope_id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `experiments_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `experiments_ibfk_5` FOREIGN KEY (`microscope_id`) REFERENCES `microscopes` (`microscope_id`),
  CONSTRAINT `experiments_ibfk_6` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiments`
--

LOCK TABLES `experiments` WRITE;
/*!40000 ALTER TABLE `experiments` DISABLE KEYS */;
INSERT INTO `experiments` VALUES (1,1,NULL,'Experiment no. 1','h1. ble ble ble','<p><h1>ble ble ble</h1></p>','2013-12-14 10:16:21',NULL,NULL,NULL,'rwdr--r--'),(2,1,2,'Experiment no. 1',NULL,NULL,'2013-12-14 10:16:50',NULL,NULL,NULL,'rwdr--r--'),(3,1,2,'Pokus c. 2','h1. nadpis\r\n\r\nneco *tucne*','<p><h1>nadpis</h1></p><p>neco <strong>tucne</strong></p>','2014-01-28 13:55:40','2013-01-02 12:23:41',NULL,1,'rwdrwdr--');
/*!40000 ALTER TABLE `experiments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `frames`
--

DROP TABLE IF EXISTS `frames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `frames` (
  `frame_id` int(11) NOT NULL AUTO_INCREMENT,
  `serie_id` int(11) NOT NULL,
  `ord` int(11) NOT NULL,
  `comment` text,
  `comment_html` text,
  `format` varchar(12) NOT NULL,
  `tag` varchar(5) NOT NULL,
  `size` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `taken_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`frame_id`),
  UNIQUE KEY `experiment_id` (`serie_id`,`ord`,`tag`),
  KEY `experiment_id_2` (`serie_id`),
  CONSTRAINT `frames_ibfk_1` FOREIGN KEY (`serie_id`) REFERENCES `series` (`serie_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frames`
--

LOCK TABLES `frames` WRITE;
/*!40000 ALTER TABLE `frames` DISABLE KEYS */;
INSERT INTO `frames` VALUES (2,1,147,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:53:03','2014-02-19 21:48:19'),(3,1,152,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:58:03','2014-02-19 21:48:19'),(4,1,141,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:47:02','2014-02-19 21:48:19'),(5,1,149,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:55:03','2014-02-19 21:48:19'),(6,1,144,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:50:02','2014-02-19 21:48:19'),(7,1,151,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:57:02','2014-02-19 21:48:19'),(8,1,138,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:44:02','2014-02-19 21:48:19'),(9,1,143,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:49:03','2014-02-19 21:48:19'),(10,1,146,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:52:03','2014-02-19 21:48:19'),(11,1,155,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 12:01:03','2014-02-19 21:48:19'),(12,1,157,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 12:03:03','2014-02-19 21:48:19'),(13,1,140,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:46:02','2014-02-19 21:48:20'),(14,1,148,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:54:03','2014-02-19 21:48:20'),(15,1,153,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:59:03','2014-02-19 21:48:20'),(16,1,142,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:48:02','2014-02-19 21:48:20'),(17,1,150,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:56:03','2014-02-19 21:48:20'),(18,1,154,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 12:00:03','2014-02-19 21:48:20'),(19,1,139,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:45:02','2014-02-19 21:48:20'),(20,1,156,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 12:02:02','2014-02-19 21:48:20'),(21,1,145,NULL,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:51:03','2014-02-19 21:48:20'),(30,1,89,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 10:55:02','2014-02-24 21:36:36'),(31,1,90,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 10:56:02','2014-02-24 21:36:38'),(32,1,91,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 10:57:02','2014-02-24 21:36:41'),(33,1,92,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 10:58:02','2014-02-24 21:36:44'),(34,1,93,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 10:59:02','2014-02-24 21:36:49'),(35,1,94,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:00:02','2014-02-24 21:36:52'),(36,1,95,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:01:02','2014-02-24 21:36:55'),(37,1,96,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:02:02','2014-02-24 21:36:59'),(38,1,97,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:03:02','2014-02-24 21:37:05'),(39,1,98,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:04:02','2014-02-24 21:37:06'),(40,1,99,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:05:02','2014-02-24 21:37:10'),(41,1,100,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:06:02','2014-02-24 21:37:14'),(42,1,101,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:07:02','2014-02-24 21:37:17'),(43,1,102,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:08:02','2014-02-24 21:37:21'),(44,1,103,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:09:02','2014-02-24 21:37:24'),(45,1,124,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:30:02','2014-02-24 21:37:28'),(46,1,125,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:31:02','2014-02-24 21:37:31'),(47,1,126,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:32:02','2014-02-24 21:37:35'),(48,1,127,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:33:02','2014-02-24 21:37:40'),(49,1,128,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:34:02','2014-02-24 21:37:44'),(50,1,129,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:35:02','2014-02-24 21:37:47'),(51,1,130,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:36:02','2014-02-24 21:37:51'),(52,1,131,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:37:02','2014-02-24 21:37:57'),(53,1,132,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:38:02','2014-02-24 21:38:00'),(54,1,133,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:39:02','2014-02-24 21:38:04'),(55,1,134,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:40:02','2014-02-24 21:38:11'),(56,1,135,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:41:02','2014-02-24 21:38:13'),(57,1,136,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:42:02','2014-02-24 21:38:18'),(58,1,137,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:43:03','2014-02-24 21:38:22'),(59,1,138,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:44:02','2014-02-24 21:38:27'),(60,1,139,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:45:02','2014-02-24 21:38:35'),(61,1,140,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:46:02','2014-02-24 21:38:37'),(62,1,141,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:47:02','2014-02-24 21:38:41'),(63,1,142,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:48:02','2014-02-24 21:38:47'),(64,1,144,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:50:02','2014-02-24 21:38:52'),(65,1,145,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:51:03','2014-02-24 21:38:56'),(66,1,146,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:52:03','2014-02-24 21:39:05'),(67,1,147,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:53:03','2014-02-24 21:39:07'),(68,1,148,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:54:03','2014-02-24 21:39:11'),(69,1,149,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:55:03','2014-02-24 21:39:23'),(70,1,150,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:56:03','2014-02-24 21:39:25'),(71,1,151,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:57:02','2014-02-24 21:39:31'),(72,1,152,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:58:03','2014-02-24 21:39:44'),(73,1,153,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:59:03','2014-02-24 21:39:46'),(74,1,154,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 12:00:03','2014-02-24 21:40:00'),(75,1,155,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 12:01:03','2014-02-24 21:40:02'),(76,1,156,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 12:02:02','2014-02-24 21:40:07'),(77,1,157,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 12:03:03','2014-02-24 21:40:14'),(78,1,105,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:11:02','2014-02-24 21:40:19'),(79,1,106,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:12:02','2014-02-24 21:40:26'),(80,1,107,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:13:02','2014-02-24 21:40:37'),(81,1,108,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:14:02','2014-02-24 21:40:38'),(82,1,109,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:15:02','2014-02-24 21:40:44'),(83,1,110,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:16:02','2014-02-24 21:40:55'),(84,1,111,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:17:02','2014-02-24 21:40:57'),(85,1,112,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:18:02','2014-02-24 21:41:03'),(86,1,113,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:19:02','2014-02-24 21:41:08'),(87,1,114,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:20:02','2014-02-24 21:41:20'),(88,1,115,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:21:02','2014-02-24 21:41:22'),(89,1,116,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:22:02','2014-02-24 21:41:39'),(90,1,117,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:23:02','2014-02-24 21:41:41'),(91,1,118,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:24:02','2014-02-24 21:41:46'),(92,1,119,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:25:02','2014-02-24 21:41:54'),(93,1,120,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:26:02','2014-02-24 21:42:05'),(94,1,121,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:27:02','2014-02-24 21:42:07'),(95,1,122,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:28:02','2014-02-24 21:42:18'),(96,1,104,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:10:02','2014-02-24 21:42:20'),(97,1,123,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:29:02','2014-02-24 21:42:26'),(98,1,143,NULL,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:49:03','2014-02-24 21:42:33');
/*!40000 ALTER TABLE `frames` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'hello',1),(2,'kitty',0);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metainfo_biological`
--

DROP TABLE IF EXISTS `metainfo_biological`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metainfo_biological` (
  `metainfo_biological_id` int(11) NOT NULL AUTO_INCREMENT,
  `experiment_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `internal_name` varchar(16) DEFAULT NULL,
  `value` text NOT NULL,
  `is_constant` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`metainfo_biological_id`),
  KEY `microscope_id` (`experiment_id`),
  CONSTRAINT `metainfo_biological_ibfk_1` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`experiment_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metainfo_biological`
--

LOCK TABLES `metainfo_biological` WRITE;
/*!40000 ALTER TABLE `metainfo_biological` DISABLE KEYS */;
INSERT INTO `metainfo_biological` VALUES (1,2,'test','test','20',0),(2,2,'test2','test2','50',0),(3,3,'velikost bunky',NULL,'5',0);
/*!40000 ALTER TABLE `metainfo_biological` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metainfo_microscopes`
--

DROP TABLE IF EXISTS `metainfo_microscopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metainfo_microscopes` (
  `metainfo_microscope_id` int(11) NOT NULL AUTO_INCREMENT,
  `microscope_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `internal_name` varchar(16) DEFAULT NULL,
  `value` text NOT NULL,
  `is_constant` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`metainfo_microscope_id`),
  KEY `microscope_id` (`microscope_id`),
  CONSTRAINT `metainfo_microscopes_ibfk_1` FOREIGN KEY (`microscope_id`) REFERENCES `microscopes` (`microscope_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metainfo_microscopes`
--

LOCK TABLES `metainfo_microscopes` WRITE;
/*!40000 ALTER TABLE `metainfo_microscopes` DISABLE KEYS */;
INSERT INTO `metainfo_microscopes` VALUES (1,2,'Focus','focus 2','1',1),(2,2,'Resulution','res','512',0);
/*!40000 ALTER TABLE `metainfo_microscopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metainfo_technical`
--

DROP TABLE IF EXISTS `metainfo_technical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metainfo_technical` (
  `metainfo_technical_id` int(11) NOT NULL AUTO_INCREMENT,
  `experiment_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `internal_name` varchar(16) DEFAULT NULL,
  `value` text NOT NULL,
  `is_constant` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`metainfo_technical_id`),
  KEY `microscope_id` (`experiment_id`),
  CONSTRAINT `metainfo_technical_ibfk_1` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`experiment_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metainfo_technical`
--

LOCK TABLES `metainfo_technical` WRITE;
/*!40000 ALTER TABLE `metainfo_technical` DISABLE KEYS */;
INSERT INTO `metainfo_technical` VALUES (1,3,'Focus','focus 2','1',1),(2,3,'Resulution','res','512',0);
/*!40000 ALTER TABLE `metainfo_technical` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `microscopes`
--

DROP TABLE IF EXISTS `microscopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `microscopes` (
  `microscope_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `tag` varchar(32) NOT NULL,
  `comment` text,
  `comment_html` text,
  `is_suspended` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`microscope_id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `microscopes`
--

LOCK TABLES `microscopes` WRITE;
/*!40000 ALTER TABLE `microscopes` DISABLE KEYS */;
INSERT INTO `microscopes` VALUES (2,'Pecka 2','Terminator 2','h2. nejakej koment\r\n\r\n# polozka 1\r\n# polozka 2\r\n\r\n* tecka\r\n* carka','<p><h2>nejakej koment</h2></p><p><ol style=\"list-style-type: decimal\"><li>polozka 1</li><li>polozka 2</li></ol></p><p><ul><li>tecka</li><li>carka</li></ul></p>',0);
/*!40000 ALTER TABLE `microscopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `samples`
--

DROP TABLE IF EXISTS `samples`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `samples` (
  `sample_id` int(11) NOT NULL AUTO_INCREMENT,
  `experiment_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` text,
  `comment_html` text,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `access_permisions` varchar(9) DEFAULT 'rwdr--r--',
  PRIMARY KEY (`sample_id`),
  KEY `experiment_id` (`experiment_id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `samples_ibfk_1` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`experiment_id`) ON DELETE CASCADE,
  CONSTRAINT `samples_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `samples_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `samples`
--

LOCK TABLES `samples` WRITE;
/*!40000 ALTER TABLE `samples` DISABLE KEYS */;
INSERT INTO `samples` VALUES (5,3,'test','hokus pokus','<p>hokus pokus</p>',1,1,'rwdrwdrwd');
/*!40000 ALTER TABLE `samples` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `series`
--

DROP TABLE IF EXISTS `series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `series` (
  `serie_id` int(11) NOT NULL AUTO_INCREMENT,
  `sample_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` text,
  `comment_html` text,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `access_permisions` varchar(9) DEFAULT 'rwdr--r--',
  PRIMARY KEY (`serie_id`),
  KEY `sample_id` (`sample_id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `series_ibfk_1` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`sample_id`) ON DELETE CASCADE,
  CONSTRAINT `series_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `series_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `series`
--

LOCK TABLES `series` WRITE;
/*!40000 ALTER TABLE `series` DISABLE KEYS */;
INSERT INTO `series` VALUES (1,5,'Serie no 1',NULL,NULL,NULL,NULL,1,NULL,'rwdr--r--');
/*!40000 ALTER TABLE `series` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL,
  `username` varchar(64) NOT NULL,
  `salt` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role` varchar(8) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'root','Great Evil Creator Of All Filth','67c663cfd2850ca36db487ec9642be46e971a26b','aafab6d2ef76af246d5ebf127f1f231004059a6f','admin'),(2,'operator','Some operator','895deb20933dca652bec6752d2ef3f534e2de6ae','0d9b888110ebdd060cda7771b9e541a80e04a988','operator');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_have_groups`
--

DROP TABLE IF EXISTS `users_have_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_have_groups` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `users_have_groups_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `users_have_groups_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_have_groups`
--

LOCK TABLES `users_have_groups` WRITE;
/*!40000 ALTER TABLE `users_have_groups` DISABLE KEYS */;
INSERT INTO `users_have_groups` VALUES (1,1),(2,2);
/*!40000 ALTER TABLE `users_have_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-03 13:05:36
