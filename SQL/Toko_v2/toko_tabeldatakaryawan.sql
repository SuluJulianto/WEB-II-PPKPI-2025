CREATE DATABASE  IF NOT EXISTS `toko` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `toko`;
-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: toko
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tabeldatakaryawan`
--

DROP TABLE IF EXISTS `tabeldatakaryawan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tabeldatakaryawan` (
  `NIP` int NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('Manager','Admin','Staf Gudang') NOT NULL,
  `Avatar` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `Status` enum('online','offline') NOT NULL DEFAULT 'offline',
  `Tgl_Registrasi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Last_Login` datetime DEFAULT NULL,
  `Alamat` tinytext,
  PRIMARY KEY (`NIP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabeldatakaryawan`
--

LOCK TABLES `tabeldatakaryawan` WRITE;
/*!40000 ALTER TABLE `tabeldatakaryawan` DISABLE KEYS */;
INSERT INTO `tabeldatakaryawan` VALUES (101,'Wowo','manager@toko.com','$2y$10$j4kqaePEcFtJkgdiewNovun.xlAVRuLpwtUbbAVWVM1cCt6E1xiO.','Manager','default.jpg','offline','2025-08-13 11:04:04',NULL,NULL),(102,'wido','admin@toko.com','$2y$10$bx/cp7LNsdDvp1OzI02Xv.QMjp6zTdWhZOLWaOpz5EY6cvFhlJHjS','Admin','default.jpg','offline','2025-08-13 11:09:14',NULL,NULL),(103,'Tom','staf@toko.com','$2y$10$u9i5ic2jgQxaYPsik0ekGefs6DShmOW/RtUR4h8v2agde5IZdomKq','Staf Gudang','default.jpg','offline','2025-08-13 11:09:42',NULL,NULL);
/*!40000 ALTER TABLE `tabeldatakaryawan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-13 14:21:17
