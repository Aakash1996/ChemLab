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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowrequest`
--

LOCK TABLES `borrowrequest` WRITE;
/*!40000 ALTER TABLE `borrowrequest` DISABLE KEYS */;
INSERT INTO `borrowrequest` VALUES (29,'aakash','1',0.03,'2016-04-28','21:09:35',-2),(30,'aakash','1',0.17,'2016-04-28','21:09:40',-2),(31,'aakash','1',4.2,'2016-04-28','21:14:04',-2),(32,'aakash','1',2,'2016-04-28','21:14:10',-2),(33,'aakash','1',2,'2016-04-28','21:19:11',-2),(34,'aakash','1',2,'2016-04-28','21:22:20',-2),(35,'aakash','1',2.27,'2016-04-28','21:23:35',-2),(36,'aakash','1',1,'2016-04-28','21:25:31',-2);
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
INSERT INTO `chemicals` VALUES ('1','','',0,2,0,0,'',500,100,'',0);
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
  UNIQUE KEY `memID` (`memID`),
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
INSERT INTO `groupdetails` VALUES (1,'aad'),(1,'aakash'),(1,'aakashhanda'),(1,'aditya');
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
  `gID` int(11) NOT NULL AUTO_INCREMENT,
  `hID` varchar(32) NOT NULL,
  `tlID` varchar(32) NOT NULL,
  `budget` int(15) DEFAULT NULL,
  PRIMARY KEY (`gID`),
  UNIQUE KEY `hID` (`hID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researchgroup`
--

LOCK TABLES `researchgroup` WRITE;
/*!40000 ALTER TABLE `researchgroup` DISABLE KEYS */;
INSERT INTO `researchgroup` VALUES (1,'adi','g1h',52435),(2,'aak','sdas',5000),(3,'rh2','',NULL),(4,'rh4','th4',NULL),(5,'dadas','',NULL);
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
  `state` int(11) DEFAULT NULL,
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
INSERT INTO `returnrequest` VALUES (29,0.01,'2016-04-28','21:10:48',0),(30,0.16,'2016-04-28','21:10:55',0),(31,3,'2016-04-28','21:15:52',0),(32,1.7,'2016-04-28','21:18:30',0),(33,1,'2016-04-28','21:19:52',0),(34,1.5,'2016-04-28','21:22:42',0),(35,2.27,'2016-04-28','21:24:58',0),(36,0.5,'2016-04-28','21:26:13',0);
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
  `gID` int(11) DEFAULT NULL,
  KEY `gID` (`gID`),
  CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`gID`) REFERENCES `researchgroup` (`gID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
INSERT INTO `stock` VALUES ('1',1.77,1);
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
INSERT INTO `users` VALUES ('aad','*C764F5C758611EA05A5AF07FB3FCF0F216E7AB0A','S',''),('aak','*B244407D50B04B3145DA19CC8E3CCC2B2083DCF3','R','aakash'),('aakash','*11BD7ECA686310F27791E4176BBFCF0FC55468FF','S','ads'),('aakashhanda','*B244407D50B04B3145DA19CC8E3CCC2B2083DCF3','S',''),('abc','*0D3CED9BEC10A777AEC23CCC353A8C08A633045E','S','abc'),('adi','*62F4A939227ABDD2176E3B797686948FFACB0506','R','Aditya'),('aditya','*52B83BFB14D48D684C04299AF87E675090FA9ACB','S','aditya'),('admin','*4ACFE3202A5FF5CF467898FC58AAB1D615029441','A','Batman'),('admin2','*0E6FD44C7B722784DAE6E67EF8C06FB1ACB3E0A6','A','ad2'),('dadas','*C6AEF960DF10A7E2F7D6D303C1FCAC528F19F08E','R','dadas'),('g1h','*FC79C5A47BA60980291F592A8D786CB2E85CFB8C','T','g1h'),('han','*CFAC39769D64FE781449139F5AF667662ACA2A36','T','Handa'),('rh2','*EB1D149A2CE9DFFA7C523B6FF91CFC6534FC463C','R','rh2'),('rh3','*B8A0117B7DE9A963E7E1DA5DDBFFEDEE55074BE7','A','rh3'),('rh4','*3E6E73BDE6475AD9760BB76D8B11943030AA769A','R','rh4'),('sdad','*F6DD0C0AC75395CB5BFC12C46B8880CD156B4799','S','asd'),('sdas','*F6DD0C0AC75395CB5BFC12C46B8880CD156B4799','T','asd'),('th4','*7F293689D6611498E08F4DA7A92F01D5F58F6155','T','th4'),('xyz','*39C549BDECFBA8AFC3CE6B948C9359A0ECE08DE2','S','Jon');
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

-- Dump completed on 2016-04-29  0:33:49
