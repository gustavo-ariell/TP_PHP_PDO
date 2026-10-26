/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_hotel
-- ------------------------------------------------------
-- Server version	10.11.18-MariaDB-0+deb12u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `habitacion`
--

DROP TABLE IF EXISTS `habitacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `habitacion` (
  `id_habitacion` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(10) NOT NULL,
  `piso` int(11) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `precio_noche` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_habitacion`),
  UNIQUE KEY `numero` (`numero`),
  KEY `fk_habitacion_tipo` (`id_tipo`),
  CONSTRAINT `fk_habitacion_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_habitacion` (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `habitacion`
--

LOCK TABLES `habitacion` WRITE;
/*!40000 ALTER TABLE `habitacion` DISABLE KEYS */;
INSERT INTO `habitacion` VALUES
(1,'101',1,1,1,8000.00),
(2,'102',1,1,1,8000.00),
(3,'201',2,2,2,12000.00),
(4,'202',2,2,2,12000.00),
(5,'203',2,3,3,15000.00),
(6,'301',3,2,4,20000.00),
(7,'302',3,2,5,25000.00),
(8,'303',3,2,9,18000.00),
(9,'401',4,4,7,22000.00),
(10,'402',4,2,8,12000.00),
(11,'501',5,2,6,45000.00),
(12,'502',5,2,10,60000.00);
/*!40000 ALTER TABLE `habitacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `huesped`
--

DROP TABLE IF EXISTS `huesped`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `huesped` (
  `id_huesped` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_huesped`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `huesped`
--

LOCK TABLES `huesped` WRITE;
/*!40000 ALTER TABLE `huesped` DISABLE KEYS */;
INSERT INTO `huesped` VALUES
(1,'Carlos','Méndez','25123456','11-6666-1001','cmendez@mail.com'),
(2,'Rosa','Vargas','25234567','11-6666-1002','rvargas@mail.com'),
(3,'Martín','Reyes','25345678','11-6666-1003','mreyes@mail.com'),
(4,'Julia','Ramos','25456789','11-6666-1004','jramos@mail.com'),
(5,'Pablo','Guerrero','25567890','11-6666-1005','pguerrero@mail.com'),
(6,'Isabel','Cruz','25678901','11-6666-1006','icruz@mail.com'),
(7,'Ricardo','Mendoza','25789012','11-6666-1007','rmendoza@mail.com'),
(8,'Adriana','Peña','25890123','11-6666-1008','apena@mail.com'),
(9,'Oscar','Contreras','25901234','11-6666-1009','ocontreras@mail.com'),
(10,'Beatriz','Salazar','26012345','11-6666-1010','bsalazar@mail.com'),
(11,'Luis','Herrera','26123456','11-6666-1011','lherrera@mail.com'),
(12,'Diana','Castillo','26234567','11-6666-1012','dcastillo@mail.com');
/*!40000 ALTER TABLE `huesped` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago`
--

DROP TABLE IF EXISTS `pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL AUTO_INCREMENT,
  `id_reserva` int(11) NOT NULL,
  `fecha_pago` date NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id_pago`),
  KEY `fk_pago_reserva` (`id_reserva`),
  CONSTRAINT `fk_pago_reserva` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago`
--

LOCK TABLES `pago` WRITE;
/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
INSERT INTO `pago` VALUES
(1,1,'2024-05-01',24000.00,'Tarjeta de Crédito'),
(2,1,'2024-05-05',24000.00,'Tarjeta de Crédito'),
(3,2,'2024-05-02',16000.00,'Efectivo'),
(4,3,'2024-05-10',50000.00,'Transferencia'),
(5,4,'2024-05-10',30000.00,'Mercado Pago'),
(6,5,'2024-05-15',44000.00,'Tarjeta de Débito'),
(7,6,'2024-05-18',44000.00,'Tarjeta de Crédito'),
(8,7,'2024-06-01',16000.00,'Efectivo'),
(9,8,'2024-06-05',60000.00,'Transferencia'),
(10,9,'2024-06-10',125000.00,'Tarjeta de Crédito'),
(11,10,'2024-06-20',300000.00,'Transferencia'),
(12,11,'2024-07-01',24000.00,'Efectivo');
/*!40000 ALTER TABLE `pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `id_huesped` int(11) NOT NULL,
  `id_habitacion` int(11) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `cantidad_personas` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'activa',
  PRIMARY KEY (`id_reserva`),
  KEY `fk_reserva_huesped` (`id_huesped`),
  KEY `fk_reserva_habitacion` (`id_habitacion`),
  CONSTRAINT `fk_reserva_habitacion` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`),
  CONSTRAINT `fk_reserva_huesped` FOREIGN KEY (`id_huesped`) REFERENCES `huesped` (`id_huesped`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva`
--

LOCK TABLES `reserva` WRITE;
/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` VALUES
(1,1,3,'2024-05-01','2024-05-05',2,'finalizada'),
(2,2,1,'2024-05-02','2024-05-04',1,'finalizada'),
(3,3,6,'2024-05-10','2024-05-15',2,'activa'),
(4,4,5,'2024-05-10','2024-05-12',3,'activa'),
(5,5,7,'2024-05-15','2024-05-20',2,'activa'),
(6,6,9,'2024-05-18','2024-05-22',4,'confirmada'),
(7,7,2,'2024-06-01','2024-06-03',1,'confirmada'),
(8,8,4,'2024-06-05','2024-06-10',2,'confirmada'),
(9,9,11,'2024-06-10','2024-06-15',2,'confirmada'),
(10,10,12,'2024-06-20','2024-06-25',2,'confirmada'),
(11,11,8,'2024-07-01','2024-07-05',2,'pendiente'),
(12,12,10,'2024-07-10','2024-07-12',1,'pendiente');
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_habitacion`
--

DROP TABLE IF EXISTS `tipo_habitacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_habitacion` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_habitacion`
--

LOCK TABLES `tipo_habitacion` WRITE;
/*!40000 ALTER TABLE `tipo_habitacion` DISABLE KEYS */;
INSERT INTO `tipo_habitacion` VALUES
(1,'Simple','Una cama individual'),
(2,'Doble','Dos camas individuales o una matrimonial'),
(3,'Triple','Tres camas individuales'),
(4,'Suite Junior','Habitación con living pequeño'),
(5,'Suite Ejecutiva','Habitación con living y escritorio'),
(6,'Suite Presidencial','Habitación de lujo con jacuzzi'),
(7,'Familiar','Habitación amplia para familias'),
(8,'Adaptada','Habitación accesible para discapacitados'),
(9,'Doble Superior','Doble con amenities premium'),
(10,'Penthouse','Último piso con vista panorámica');
/*!40000 ALTER TABLE `tipo_habitacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_hotel'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-06 16:29:41
