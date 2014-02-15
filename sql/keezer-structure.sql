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

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `keezer` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `keezer`;

--
-- Table structure for table `Keg`
--

DROP TABLE IF EXISTS `Keg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Keg` (
  `KegID` int(11) NOT NULL,
  `KegName` varchar(30) NOT NULL,
  `Enabled` tinyint(4) NOT NULL,
  `CurrentLevel` float NOT NULL,
  `Capacity` float NOT NULL,
  `PID` int(11) NOT NULL,
  `KegSoundLow` varchar(200) NOT NULL,
  `KegSoundNormal` varchar(200) NOT NULL,
  `KegSoundOut` varchar(200) NOT NULL,
  `LastPour` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
