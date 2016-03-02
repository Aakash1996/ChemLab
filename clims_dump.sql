-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: clims
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

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
-- Table structure for table `borrowrequest`
--

DROP TABLE IF EXISTS `borrowrequest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `borrowrequest` (
  `reqID` int(11) NOT NULL AUTO_INCREMENT,
  `uID` varchar(32) NOT NULL,
  `cID` varchar(20) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`reqID`),
  KEY `reqID` (`reqID`),
  KEY `uID` (`uID`),
  KEY `cID` (`cID`),
  CONSTRAINT `borrowrequest_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `users` (`id`),
  CONSTRAINT `borrowrequest_ibfk_2` FOREIGN KEY (`cID`) REFERENCES `chemicals` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowrequest`
--

LOCK TABLES `borrowrequest` WRITE;
/*!40000 ALTER TABLE `borrowrequest` DISABLE KEYS */;
/*!40000 ALTER TABLE `borrowrequest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chemicals`
--

DROP TABLE IF EXISTS `chemicals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chemicals` (
  `id` varchar(15) NOT NULL,
  `common_name` varchar(50) NOT NULL,
  `iupac` varchar(75) NOT NULL,
  `bp` float NOT NULL,
  `mp` float NOT NULL,
  `toxic` tinyint(1) NOT NULL,
  `pH` float NOT NULL,
  `state` varchar(15) NOT NULL,
  `limit` float NOT NULL,
  `min` float NOT NULL,
  `supplier` varchar(200) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemicals`
--

LOCK TABLES `chemicals` WRITE;
/*!40000 ALTER TABLE `chemicals` DISABLE KEYS */;
/*!40000 ALTER TABLE `chemicals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupdetails`
--

DROP TABLE IF EXISTS `groupdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupdetails` (
  `gID` int(11) NOT NULL,
  `memID` varchar(20) NOT NULL,
  PRIMARY KEY (`gID`,`memID`),
  KEY `gID` (`gID`),
  KEY `gID_2` (`gID`),
  CONSTRAINT `groupdetails_ibfk_1` FOREIGN KEY (`gID`) REFERENCES `researchgroup` (`gID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupdetails`
--

LOCK TABLES `groupdetails` WRITE;
/*!40000 ALTER TABLE `groupdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `groupdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchaserequest`
--

DROP TABLE IF EXISTS `purchaserequest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchaserequest` (
  `reqID` int(11) NOT NULL AUTO_INCREMENT,
  `uID` varchar(32) NOT NULL,
  `cID` varchar(20) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`reqID`),
  KEY `uID` (`uID`),
  KEY `cID` (`cID`),
  CONSTRAINT `purchaserequest_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `users` (`id`),
  CONSTRAINT `purchaserequest_ibfk_2` FOREIGN KEY (`cID`) REFERENCES `chemicals` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchaserequest`
--

LOCK TABLES `purchaserequest` WRITE;
/*!40000 ALTER TABLE `purchaserequest` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchaserequest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `researchgroup`
--

DROP TABLE IF EXISTS `researchgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `researchgroup` (
  `gID` int(11) NOT NULL,
  `hID` varchar(32) NOT NULL,
  `tlID` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`gID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researchgroup`
--

LOCK TABLES `researchgroup` WRITE;
/*!40000 ALTER TABLE `researchgroup` DISABLE KEYS */;
/*!40000 ALTER TABLE `researchgroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `returnrequest`
--

DROP TABLE IF EXISTS `returnrequest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `returnrequest` (
  `reqID` int(11) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`reqID`),
  KEY `reqID` (`reqID`),
  CONSTRAINT `returnrequest_ibfk_1` FOREIGN KEY (`reqID`) REFERENCES `borrowrequest` (`reqID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `returnrequest`
--

LOCK TABLES `returnrequest` WRITE;
/*!40000 ALTER TABLE `returnrequest` DISABLE KEYS */;
/*!40000 ALTER TABLE `returnrequest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock` (
  `chemID` varchar(15) NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`chemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` varchar(32) NOT NULL,
  `pass` varchar(41) NOT NULL,
  `type` char(1) NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('aakash','*11BD7ECA686310F27791E4176BBFCF0FC55468FF','S','ads'),('abc','*0D3CED9BEC10A777AEC23CCC353A8C08A633045E','S','abc'),('admin','*4ACFE3202A5FF5CF467898FC58AAB1D615029441','A','Batman');
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

-- Dump completed on 2016-03-02 17:47:57
