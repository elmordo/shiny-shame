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
-- Table structure for table `metainfo_microscopes`
--

DROP TABLE IF EXISTS `metainfo_microscopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metainfo_microscopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `microscope_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `internal_name` varchar(16) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `microscope_id` (`microscope_id`),
  CONSTRAINT `metainfo_microscopes_ibfk_1` FOREIGN KEY (`microscope_id`) REFERENCES `microscopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metainfo_microscopes`
--

LOCK TABLES `metainfo_microscopes` WRITE;
/*!40000 ALTER TABLE `metainfo_microscopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `metainfo_microscopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `microscopes`
--

DROP TABLE IF EXISTS `microscopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `microscopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `tag` varchar(32) NOT NULL,
  `comment` text,
  `is_suspended` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `microscopes`
--

LOCK TABLES `microscopes` WRITE;
/*!40000 ALTER TABLE `microscopes` DISABLE KEYS */;
INSERT INTO `microscopes` VALUES (2,'Pecka 2','Terminátor 2','nejakej koment',1);
/*!40000 ALTER TABLE `microscopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL,
  `username` varchar(64) NOT NULL,
  `salt` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'root','Velký Zlý Programátor poc zlý','67c663cfd2850ca36db487ec9642be46e971a26b','aafab6d2ef76af246d5ebf127f1f231004059a6f','admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-12-01 18:48:34
