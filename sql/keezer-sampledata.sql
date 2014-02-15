-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (armv7l)
--
-- Host: localhost    Database: keezer
-- ------------------------------------------------------
-- Server version	5.5.35-0+wheezy1

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
-- Current Database: `keezer`
--

USE `keezer`;

--
-- Dumping data for table `Keg`
--

LOCK TABLES `Keg` WRITE;
/*!40000 ALTER TABLE `Keg` DISABLE KEYS */;
INSERT INTO `Keg` VALUES (1,'Empty',1,18.8,18.8,0,'subdir/LowSound.ogg','subdir/NormalSound.ogg','subdir/OutSound.ogg',0.0),(2,'Empty',1,18.8,18.8,0,'subdir/LowSound.ogg','subdir/NormalSound.ogg','subdir/OutSound.ogg',0.0),(3,'Empty',1,18.8,18.8,0,'subdir/LowSound.ogg','subdir/NormalSound.ogg','subdir/OutSound.ogg',0.0);
/*!40000 ALTER TABLE `Keg` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-15 21:14:16
