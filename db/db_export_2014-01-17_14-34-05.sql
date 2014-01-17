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
  `experiment_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `comment` text,
  `tag` varchar(16) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `access_permisions` varchar(9) NOT NULL DEFAULT 'rwdr--r--',
  PRIMARY KEY (`collection_id`),
  KEY `experiment_id` (`experiment_id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `collections_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `collections_ibfk_5` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE SET NULL,
  CONSTRAINT `collections_ibfk_6` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`experiment_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collections`
--

LOCK TABLES `collections` WRITE;
/*!40000 ALTER TABLE `collections` DISABLE KEYS */;
INSERT INTO `collections` VALUES (5,2,'pc',NULL,'pc',1,NULL,'rwdr--r--'),(6,2,'h',NULL,'h',1,NULL,'rwdr--r--'),(8,2,'My collection',NULL,NULL,1,1,'rwdr--r--');
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
INSERT INTO `collections_have_frames` VALUES (424,5),(425,5),(426,5),(427,5),(428,5),(429,5),(430,5),(431,5),(432,5),(433,5),(434,5),(435,5),(436,5),(437,5),(438,5),(439,5),(440,5),(441,5),(442,5),(443,5),(444,5),(445,5),(446,5),(447,5),(448,5),(449,5),(450,5),(451,5),(452,5),(453,5),(454,5),(455,5),(456,5),(457,5),(458,5),(459,5),(460,5),(461,5),(462,5),(463,5),(464,5),(465,5),(466,5),(467,5),(468,5),(469,5),(470,5),(471,5),(472,5),(473,5),(474,5),(475,5),(476,5),(477,5),(478,5),(479,5),(480,5),(481,5),(482,5),(483,5),(484,5),(485,5),(486,5),(487,5),(488,5),(489,5),(490,5),(491,5),(492,5),(355,6),(356,6),(357,6),(358,6),(359,6),(360,6),(361,6),(362,6),(363,6),(364,6),(365,6),(366,6),(367,6),(368,6),(369,6),(370,6),(371,6),(372,6),(373,6),(374,6),(375,6),(376,6),(377,6),(378,6),(379,6),(380,6),(381,6),(382,6),(383,6),(384,6),(385,6),(386,6),(387,6),(388,6),(389,6),(390,6),(391,6),(392,6),(393,6),(394,6),(395,6),(396,6),(397,6),(398,6),(399,6),(400,6),(401,6),(402,6),(403,6),(404,6),(405,6),(406,6),(407,6),(408,6),(409,6),(410,6),(411,6),(412,6),(413,6),(414,6),(415,6),(416,6),(417,6),(418,6),(419,6),(420,6),(421,6),(422,6),(423,6);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiments`
--

LOCK TABLES `experiments` WRITE;
/*!40000 ALTER TABLE `experiments` DISABLE KEYS */;
INSERT INTO `experiments` VALUES (1,1,NULL,'Experiment no. 1',NULL,'2013-12-14 10:16:21',NULL,NULL,NULL,'rwdr--r--'),(2,1,2,'Experiment no. 1',NULL,'2013-12-14 10:16:50',NULL,NULL,NULL,'rwdr--r--');
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
  `experiment_id` int(11) NOT NULL,
  `ord` int(11) NOT NULL,
  `comment` text,
  `format` varchar(12) NOT NULL,
  `tag` varchar(5) NOT NULL,
  `size` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `taken_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`frame_id`),
  UNIQUE KEY `experiment_id` (`experiment_id`,`ord`,`tag`),
  KEY `experiment_id_2` (`experiment_id`),
  CONSTRAINT `frames_ibfk_1` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`experiment_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=493 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frames`
--

LOCK TABLES `frames` WRITE;
/*!40000 ALTER TABLE `frames` DISABLE KEYS */;
INSERT INTO `frames` VALUES (355,2,128,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:34:02','2014-01-14 10:25:28'),(356,2,107,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:13:02','2014-01-14 10:25:29'),(357,2,133,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:39:02','2014-01-14 10:25:30'),(358,2,136,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:42:02','2014-01-14 10:25:30'),(359,2,112,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:18:02','2014-01-14 10:25:30'),(360,2,115,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:21:02','2014-01-14 10:25:31'),(361,2,94,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:00:02','2014-01-14 10:25:32'),(362,2,120,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:26:02','2014-01-14 10:25:32'),(363,2,138,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:44:02','2014-01-14 10:25:33'),(364,2,122,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:28:02','2014-01-14 10:25:33'),(365,2,90,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 10:56:02','2014-01-14 10:25:33'),(366,2,125,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:31:02','2014-01-14 10:25:33'),(367,2,151,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:57:02','2014-01-14 10:25:34'),(368,2,155,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 12:01:03','2014-01-14 10:25:34'),(369,2,130,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:36:02','2014-01-14 10:25:34'),(370,2,109,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:15:02','2014-01-14 10:25:34'),(371,2,143,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:49:03','2014-01-14 10:25:34'),(372,2,117,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:23:02','2014-01-14 10:25:35'),(373,2,146,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:52:03','2014-01-14 10:25:35'),(374,2,96,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:02:02','2014-01-14 10:25:36'),(375,2,101,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:07:02','2014-01-14 10:25:36'),(376,2,104,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:10:02','2014-01-14 10:25:36'),(377,2,119,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:25:02','2014-01-14 10:25:37'),(378,2,92,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 10:58:02','2014-01-14 10:25:37'),(379,2,153,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:59:03','2014-01-14 10:25:37'),(380,2,127,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:33:02','2014-01-14 10:25:37'),(381,2,103,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:09:02','2014-01-14 10:25:37'),(382,2,106,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:12:02','2014-01-14 10:25:38'),(383,2,132,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:38:02','2014-01-14 10:25:38'),(384,2,157,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 12:03:03','2014-01-14 10:25:38'),(385,2,135,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:41:02','2014-01-14 10:25:38'),(386,2,89,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 10:55:02','2014-01-14 10:25:38'),(387,2,114,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:20:02','2014-01-14 10:25:39'),(388,2,140,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:46:02','2014-01-14 10:25:39'),(389,2,111,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:17:02','2014-01-14 10:25:39'),(390,2,148,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:54:03','2014-01-14 10:25:39'),(391,2,98,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:04:02','2014-01-14 10:25:39'),(392,2,142,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:48:02','2014-01-14 10:25:40'),(393,2,154,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 12:00:03','2014-01-14 10:25:40'),(394,2,129,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:35:02','2014-01-14 10:25:40'),(395,2,108,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:14:02','2014-01-14 10:25:40'),(396,2,137,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:43:03','2014-01-14 10:25:40'),(397,2,113,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:19:02','2014-01-14 10:25:41'),(398,2,116,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:22:02','2014-01-14 10:25:41'),(399,2,145,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:51:03','2014-01-14 10:25:41'),(400,2,95,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:01:02','2014-01-14 10:25:41'),(401,2,121,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:27:02','2014-01-14 10:25:41'),(402,2,124,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:30:02','2014-01-14 10:25:42'),(403,2,100,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:06:02','2014-01-14 10:25:42'),(404,2,150,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:56:03','2014-01-14 10:25:42'),(405,2,139,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:45:02','2014-01-14 10:25:42'),(406,2,118,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:24:02','2014-01-14 10:25:43'),(407,2,156,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 12:02:02','2014-01-14 10:25:43'),(408,2,91,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 10:57:02','2014-01-14 10:25:43'),(409,2,123,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:29:02','2014-01-14 10:25:43'),(410,2,126,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:32:02','2014-01-14 10:25:43'),(411,2,131,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:37:02','2014-01-14 10:25:43'),(412,2,110,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:16:02','2014-01-14 10:25:44'),(413,2,134,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:40:02','2014-01-14 10:25:44'),(414,2,93,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 10:59:02','2014-01-14 10:25:44'),(415,2,97,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:03:02','2014-01-14 10:25:44'),(416,2,147,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:53:03','2014-01-14 10:25:45'),(417,2,152,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:58:03','2014-01-14 10:25:45'),(418,2,102,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:08:02','2014-01-14 10:25:45'),(419,2,105,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:11:02','2014-01-14 10:25:46'),(420,2,141,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:47:02','2014-01-14 10:25:46'),(421,2,144,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:50:02','2014-01-14 10:25:46'),(422,2,99,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:05:02','2014-01-14 10:25:47'),(423,2,149,NULL,'tiff','h',2865014,1376,1038,'2013-03-11 11:55:03','2014-01-14 10:25:47'),(424,2,118,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:24:02','2014-01-14 10:25:47'),(425,2,97,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:03:02','2014-01-14 10:25:47'),(426,2,147,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:53:03','2014-01-14 10:25:47'),(427,2,123,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:29:02','2014-01-14 10:25:47'),(428,2,152,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:58:03','2014-01-14 10:25:47'),(429,2,126,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:32:02','2014-01-14 10:25:47'),(430,2,102,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:08:02','2014-01-14 10:25:48'),(431,2,105,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:11:02','2014-01-14 10:25:48'),(432,2,110,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:16:02','2014-01-14 10:25:48'),(433,2,93,NULL,'tiff','pc',521810,416,312,'2013-03-11 10:59:02','2014-01-14 10:25:48'),(434,2,128,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:34:02','2014-01-14 10:25:48'),(435,2,133,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:39:02','2014-01-14 10:25:48'),(436,2,136,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:42:02','2014-01-14 10:25:48'),(437,2,112,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:18:02','2014-01-14 10:25:48'),(438,2,115,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:21:02','2014-01-14 10:25:48'),(439,2,141,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:47:02','2014-01-14 10:25:48'),(440,2,120,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:26:02','2014-01-14 10:25:48'),(441,2,99,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:05:02','2014-01-14 10:25:48'),(442,2,149,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:55:03','2014-01-14 10:25:49'),(443,2,144,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:50:02','2014-01-14 10:25:49'),(444,2,107,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:13:02','2014-01-14 10:25:49'),(445,2,90,NULL,'tiff','pc',521810,416,312,'2013-03-11 10:56:02','2014-01-14 10:25:49'),(446,2,94,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:00:02','2014-01-14 10:25:49'),(447,2,151,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:57:02','2014-01-14 10:25:49'),(448,2,109,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:15:02','2014-01-14 10:25:49'),(449,2,138,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:44:02','2014-01-14 10:25:49'),(450,2,143,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:49:03','2014-01-14 10:25:49'),(451,2,117,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:23:02','2014-01-14 10:25:49'),(452,2,146,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:52:03','2014-01-14 10:25:50'),(453,2,122,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:28:02','2014-01-14 10:25:50'),(454,2,125,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:31:02','2014-01-14 10:25:50'),(455,2,101,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:07:02','2014-01-14 10:25:50'),(456,2,104,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:10:02','2014-01-14 10:25:50'),(457,2,130,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:36:02','2014-01-14 10:25:50'),(458,2,155,NULL,'tiff','pc',521810,416,312,'2013-03-11 12:01:03','2014-01-14 10:25:50'),(459,2,96,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:02:02','2014-01-14 10:25:50'),(460,2,92,NULL,'tiff','pc',521810,416,312,'2013-03-11 10:58:02','2014-01-14 10:25:50'),(461,2,127,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:33:02','2014-01-14 10:25:50'),(462,2,157,NULL,'tiff','pc',521810,416,312,'2013-03-11 12:03:03','2014-01-14 10:25:51'),(463,2,132,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:38:02','2014-01-14 10:25:51'),(464,2,135,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:41:02','2014-01-14 10:25:51'),(465,2,140,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:46:02','2014-01-14 10:25:51'),(466,2,119,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:25:02','2014-01-14 10:25:51'),(467,2,98,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:04:02','2014-01-14 10:25:51'),(468,2,148,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:54:03','2014-01-14 10:25:51'),(469,2,153,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:59:03','2014-01-14 10:25:51'),(470,2,103,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:09:02','2014-01-14 10:25:51'),(471,2,106,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:12:02','2014-01-14 10:25:51'),(472,2,111,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:17:02','2014-01-14 10:25:51'),(473,2,89,NULL,'tiff','pc',521810,416,312,'2013-03-11 10:55:02','2014-01-14 10:25:51'),(474,2,114,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:20:02','2014-01-14 10:25:52'),(475,2,129,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:35:02','2014-01-14 10:25:52'),(476,2,108,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:14:02','2014-01-14 10:25:52'),(477,2,113,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:19:02','2014-01-14 10:25:52'),(478,2,116,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:22:02','2014-01-14 10:25:52'),(479,2,142,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:48:02','2014-01-14 10:25:52'),(480,2,121,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:27:02','2014-01-14 10:25:52'),(481,2,150,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:56:03','2014-01-14 10:25:52'),(482,2,124,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:30:02','2014-01-14 10:25:52'),(483,2,100,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:06:02','2014-01-14 10:25:52'),(484,2,154,NULL,'tiff','pc',521810,416,312,'2013-03-11 12:00:03','2014-01-14 10:25:52'),(485,2,139,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:45:02','2014-01-14 10:25:53'),(486,2,137,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:43:03','2014-01-14 10:25:53'),(487,2,156,NULL,'tiff','pc',521810,416,312,'2013-03-11 12:02:02','2014-01-14 10:25:53'),(488,2,91,NULL,'tiff','pc',521810,416,312,'2013-03-11 10:57:02','2014-01-14 10:25:53'),(489,2,95,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:01:02','2014-01-14 10:25:53'),(490,2,145,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:51:03','2014-01-14 10:25:53'),(491,2,131,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:37:02','2014-01-14 10:25:53'),(492,2,134,NULL,'tiff','pc',521810,416,312,'2013-03-11 11:40:02','2014-01-14 10:25:53');
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
-- Table structure for table `metainfo_microscopes`
--

DROP TABLE IF EXISTS `metainfo_microscopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metainfo_microscopes` (
  `metainfo_microscope_id` int(11) NOT NULL AUTO_INCREMENT,
  `microscope_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `internal_name` varchar(16) NOT NULL,
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
INSERT INTO `microscopes` VALUES (2,'Pecka 2','Terminator 2','nejakej koment',0);
/*!40000 ALTER TABLE `microscopes` ENABLE KEYS */;
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

-- Dump completed on 2014-01-17 14:34:05
