-- MySQL dump 10.13  Distrib 8.0.22, for Linux (x86_64)
--
-- Host: localhost    Database: fotolife
-- ------------------------------------------------------
-- Server version	8.0.22-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `birthday` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (7,'CAROLINA CAZARES SUAREZ','7731517418','carosua@gmail.com',NULL),(8,'EL GORDO RAMON','5587032778','ramon@gmail.com',NULL),(9,'CAROLINA CAZARES SUAREZ','7731517418','carosua@gmail.com',NULL),(10,'MARTHA ARCIA PEREZ','5534195933','ceronarciad@gmail.com',NULL);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting`
--

DROP TABLE IF EXISTS `meeting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'key',
  `title` varchar(100) NOT NULL DEFAULT 'Reunión',
  `description` text NOT NULL,
  `start` date NOT NULL,
  `time_init` time NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `user_id_log` int NOT NULL DEFAULT '100',
  `location` text,
  `id_customer` int NOT NULL,
  `id_service` int NOT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meeting_customer_FK` (`id_customer`),
  KEY `meeting_service_FK` (`id_service`),
  CONSTRAINT `meeting_customer_FK` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`),
  CONSTRAINT `meeting_service_FK` FOREIGN KEY (`id_service`) REFERENCES `services` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting`
--

LOCK TABLES `meeting` WRITE;
/*!40000 ALTER TABLE `meeting` DISABLE KEYS */;
INSERT INTO `meeting` VALUES (15,'BAUTIZO ALAN','El bautismo (romanización: bapto o baptizo, significado: «lavar» o «sumergir») es un rito de adopción y admisión al cristianismo casi invariablemente asociado con el uso de agua.\r\n\r\nPara distintas Iglesias cristianas tales como la católica, ortodoxa, anglicana y algunas protestantes, entre otras, el bautismo se considera un sacramento.\r\n\r\nPara los anabaptistas y el fundamentalismo cristiano, por su parte, es considerado una «ordenanza de Cristo».','2020-11-21','13:00:00',-1,100,'',7,3,NULL,NULL),(16,'BODA ALEXIS Y TANIA','SE CELEBRA BODA DE ALEXIS VEGA Y TANIA ALDAPE TRAS SU CEPARACION','2020-11-28','16:30:00',-1,100,'Avenida Morelos 84, Santa María Tlayacampa, 54110 Tlalnepantla de Baz, EDOMEX, México',8,3,'19.57196','-99.18508'),(17,'CUMPLEAÑOS LUCIA','SE FESTEJA LOS 97 AÑOS DE LUCIA ROSILES','2020-12-26','14:00:00',1,100,'Villagrán, GTO, México',9,3,'20.51137','-100.99544'),(18,'BAUTIZO ALAN','SE CELEBRA EL BAUTIZO DEL NIÑO ALAN','2021-01-02','13:00:00',1,100,'Avenida Morelos 46, Santa María Tlayacampa, 54110 Tlalnepantla de Baz, EDOMEX, México',10,3,'19.57087','-99.18713');
/*!40000 ALTER TABLE `meeting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,0) NOT NULL,
  `date_payment` datetime NOT NULL,
  `id_ticket` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_FK` (`id_ticket`),
  CONSTRAINT `payment_FK` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (23,500,'2020-11-30 00:00:00',3),(24,150,'2020-11-30 00:00:00',3),(25,900,'2020-11-30 00:00:00',3),(26,3000,'2020-12-01 00:00:00',4),(27,500,'2020-12-01 00:00:00',4),(28,3000,'2020-12-01 00:00:00',5),(29,5000,'2020-12-01 00:00:00',5),(30,1000,'2020-12-01 00:00:00',5);
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `price` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'FOTO','TEXT',25),(2,'FOTO GRANDE','FOTO MAS GRANDE QUE LA NORMAL',900),(3,'FOTO GRANDE PREMIUM','FOTO MAS GRANDE CON  MARCO TERMIANDO EN MADERA CON POLIESTER Y MICA PROTECTORA CONTRA AGUA Y POLVO',1500);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `working_time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (2,'PAQUETE 1','DESCRIPCION\r\nEJEMPLO\r\nETC\r\nTODOS LOS DATOS VAN AQUI \r\nDETALLE\r\nFIN',150,'08:00:00'),(3,'PAQUETE 2','DESCRIPCION ALTERNATIVA\r\nAQUI VAN UNAS CUANTAS COSAS\r\nNO PASA NADA\r\nTODO SIGUE TRANQUI\r\n',9000,'09:00:00');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket` (
  `id` int NOT NULL AUTO_INCREMENT,
  `total` decimal(10,0) NOT NULL,
  `date_ticket` datetime NOT NULL,
  `id_meeting` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_FK` (`id_meeting`),
  CONSTRAINT `ticket_FK` FOREIGN KEY (`id_meeting`) REFERENCES `meeting` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` VALUES (2,9000,'2020-11-19 00:00:00',15),(3,9000,'2020-11-26 00:00:00',16),(4,9000,'2020-12-01 00:00:00',17),(5,9000,'2020-12-01 00:00:00',18);
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_detail`
--

DROP TABLE IF EXISTS `ticket_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,0) NOT NULL,
  `date_ticket` datetime NOT NULL,
  `id_ticket` int NOT NULL,
  `id_product` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_detail_FK` (`id_ticket`),
  KEY `ticket_detail_FK_1` (`id_product`),
  CONSTRAINT `ticket_detail_FK` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id`),
  CONSTRAINT `ticket_detail_FK_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_detail`
--

LOCK TABLES `ticket_detail` WRITE;
/*!40000 ALTER TABLE `ticket_detail` DISABLE KEYS */;
INSERT INTO `ticket_detail` VALUES (1,9000,'2020-11-19 00:00:00',2,NULL),(2,9000,'2020-11-26 00:00:00',3,NULL),(3,9000,'2020-12-01 00:00:00',4,NULL),(4,9000,'2020-12-01 00:00:00',5,NULL);
/*!40000 ALTER TABLE `ticket_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'fotolife'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-12 19:40:04
