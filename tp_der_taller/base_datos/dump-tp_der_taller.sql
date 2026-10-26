/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_taller
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
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES
(1,'Mario','López','25123456','11-9999-1001'),
(2,'Jorge','García','25234567','11-9999-1002'),
(3,'Elena','Pérez','25345678','11-9999-1003'),
(4,'Roberto','Martínez','25456789','11-9999-1004'),
(5,'Carmen','Rodríguez','25567890','11-9999-1005'),
(6,'Diego','Sánchez','25678901','11-9999-1006'),
(7,'Ana','Fernández','25789012','11-9999-1007'),
(8,'Hugo','Gómez','25890123','11-9999-1008'),
(9,'Laura','Díaz','25901234','11-9999-1009'),
(10,'Pedro','Torres','26012345','11-9999-1010'),
(11,'Silvia','Ruiz','26123456','11-9999-1011'),
(12,'Fernando','Morales','26234567','11-9999-1012');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mecanico`
--

DROP TABLE IF EXISTS `mecanico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mecanico` (
  `id_mecanico` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_mecanico`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mecanico`
--

LOCK TABLES `mecanico` WRITE;
/*!40000 ALTER TABLE `mecanico` DISABLE KEYS */;
INSERT INTO `mecanico` VALUES
(1,'Carlos','Herrera','30123456','Motor'),
(2,'Luis','Acosta','30234567','Frenos'),
(3,'Jorge','Mendoza','30345678','Electricidad'),
(4,'Pedro','Ríos','30456789','Suspensión'),
(5,'Martín','Campos','30567890','Alineación'),
(6,'Sergio','Flores','30678901','Transmisión'),
(7,'Raúl','Vega','30789012','Pintura'),
(8,'Gustavo','Navarro','30890123','Diagnóstico'),
(9,'Oscar','Sosa','30901234','Aire Acondicionado'),
(10,'Andrés','Blanco','31012345','Eléctrica'),
(11,'Rubén','Castro','31123456','Inyección'),
(12,'Nicolás','Morales','31234567','Tren delantero');
/*!40000 ALTER TABLE `mecanico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reparacion`
--

DROP TABLE IF EXISTS `reparacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reparacion` (
  `id_reparacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_vehiculo` int(11) NOT NULL,
  `id_mecanico` int(11) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'en proceso',
  PRIMARY KEY (`id_reparacion`),
  KEY `fk_reparacion_vehiculo` (`id_vehiculo`),
  KEY `fk_reparacion_mecanico` (`id_mecanico`),
  CONSTRAINT `fk_reparacion_mecanico` FOREIGN KEY (`id_mecanico`) REFERENCES `mecanico` (`id_mecanico`),
  CONSTRAINT `fk_reparacion_vehiculo` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reparacion`
--

LOCK TABLES `reparacion` WRITE;
/*!40000 ALTER TABLE `reparacion` DISABLE KEYS */;
INSERT INTO `reparacion` VALUES
(1,1,1,'2024-04-01','2024-04-02','Cambio de aceite programado','finalizada'),
(2,2,2,'2024-04-03','2024-04-05','Frenos gastados','finalizada'),
(3,3,3,'2024-04-05',NULL,'Falla eléctrica en luces','en proceso'),
(4,4,5,'2024-04-08','2024-04-08','Alineación y balanceo','finalizada'),
(5,5,8,'2024-04-10','2024-04-10','Diagnóstico general','finalizada'),
(6,6,1,'2024-04-12',NULL,'Aceite y filtro vencidos','en proceso'),
(7,7,9,'2024-04-15','2024-04-16','A/C no enfría','finalizada'),
(8,8,4,'2024-04-18',NULL,'Suspensión ruidosa','en proceso'),
(9,9,6,'2024-04-20','2024-04-22','Caja de cambios con ruido','finalizada'),
(10,10,11,'2024-04-22',NULL,'Motor con fallas','en proceso'),
(11,1,10,'2024-04-25','2024-04-26','Batería descargada','finalizada'),
(12,2,5,'2024-04-28',NULL,'Ruedas desalineadas','en proceso');
/*!40000 ALTER TABLE `reparacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reparacion_servicio`
--

DROP TABLE IF EXISTS `reparacion_servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reparacion_servicio` (
  `id_reparacion` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT 1,
  `precio_aplicado` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_reparacion`,`id_servicio`),
  KEY `fk_repserv_servicio` (`id_servicio`),
  CONSTRAINT `fk_repserv_reparacion` FOREIGN KEY (`id_reparacion`) REFERENCES `reparacion` (`id_reparacion`),
  CONSTRAINT `fk_repserv_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reparacion_servicio`
--

LOCK TABLES `reparacion_servicio` WRITE;
/*!40000 ALTER TABLE `reparacion_servicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `reparacion_servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicio`
--

DROP TABLE IF EXISTS `servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio`
--

LOCK TABLES `servicio` WRITE;
/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
INSERT INTO `servicio` VALUES
(1,'Cambio de aceite','Aceite y filtro nuevos',8500.00),
(2,'Alineación','Alineación de las 4 ruedas',5000.00),
(3,'Balanceo','Balanceo de ruedas',3500.00),
(4,'Cambio de frenos','Pastillas y discos',15000.00),
(5,'Diagnóstico computarizado','Escaneo electrónico',4000.00),
(6,'Cambio de correa','Correa de distribución',25000.00),
(7,'Recarga A/C','Recarga de aire acondicionado',10000.00),
(8,'Cambio de batería','Batería nueva e instalación',18000.00),
(9,'Cambio de amortiguadores','Amortiguadores delanteros',30000.00),
(10,'Lavado de inyectores','Limpieza de inyectores',12000.00);
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_vehiculo`
--

DROP TABLE IF EXISTS `tipo_vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_vehiculo` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_vehiculo`
--

LOCK TABLES `tipo_vehiculo` WRITE;
/*!40000 ALTER TABLE `tipo_vehiculo` DISABLE KEYS */;
INSERT INTO `tipo_vehiculo` VALUES
(1,'Automóvil'),
(2,'Camioneta'),
(3,'Moto'),
(4,'Utilitario'),
(5,'SUV'),
(6,'Pickup'),
(7,'Furgón'),
(8,'Coupe'),
(9,'Convertible'),
(10,'Eléctrico');
/*!40000 ALTER TABLE `tipo_vehiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiculo` (
  `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT,
  `patente` varchar(20) NOT NULL,
  `marca` varchar(80) NOT NULL,
  `modelo` varchar(80) NOT NULL,
  `anio` smallint(6) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  PRIMARY KEY (`id_vehiculo`),
  UNIQUE KEY `patente` (`patente`),
  KEY `fk_vehiculo_tipo` (`id_tipo`),
  KEY `fk_vehiculo_cliente` (`id_cliente`),
  CONSTRAINT `fk_vehiculo_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `fk_vehiculo_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_vehiculo` (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiculo`
--

LOCK TABLES `vehiculo` WRITE;
/*!40000 ALTER TABLE `vehiculo` DISABLE KEYS */;
INSERT INTO `vehiculo` VALUES
(1,'AB 123 CD','Toyota','Corolla',2020,1,1),
(2,'AC 234 DE','Ford','Ranger',2022,6,2),
(3,'AD 345 EF','Honda','CBR 600',2019,3,3),
(4,'AE 456 FG','Volkswagen','Gol',2018,1,4),
(5,'AF 567 GH','Chevrolet','Tracker',2023,5,5),
(6,'AG 678 HI','Fiat','Cronos',2021,1,6),
(7,'AH 789 IJ','Renault','Kangoo',2020,4,7),
(8,'AI 890 JK','Ford','EcoSport',2019,5,8),
(9,'AJ 901 KL','Toyota','Hilux',2022,6,9),
(10,'AK 012 LM','Citroën','C3',2021,1,10);
/*!40000 ALTER TABLE `vehiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_taller'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-06 16:29:43
