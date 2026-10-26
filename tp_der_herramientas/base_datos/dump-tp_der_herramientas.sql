/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_herramientas
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
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES
(1,'Eléctricas'),
(2,'Manuales'),
(3,'Medición'),
(4,'Corte'),
(5,'Fijación'),
(6,'Soldadura'),
(7,'Jardín'),
(8,'Pintura'),
(9,'Plomería'),
(10,'Electricidad');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_prestamo`
--

DROP TABLE IF EXISTS `detalle_prestamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_prestamo` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_prestamo` int(11) NOT NULL,
  `id_herramienta` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `fk_detprestamo_prestamo` (`id_prestamo`),
  KEY `fk_detprestamo_herramienta` (`id_herramienta`),
  CONSTRAINT `fk_detprestamo_herramienta` FOREIGN KEY (`id_herramienta`) REFERENCES `herramienta` (`id_herramienta`),
  CONSTRAINT `fk_detprestamo_prestamo` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamo` (`id_prestamo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_prestamo`
--

LOCK TABLES `detalle_prestamo` WRITE;
/*!40000 ALTER TABLE `detalle_prestamo` DISABLE KEYS */;
INSERT INTO `detalle_prestamo` VALUES
(1,1,1),
(2,1,2),
(3,2,4),
(4,3,3),
(5,3,5),
(6,4,6),
(7,5,8),
(8,6,9),
(9,6,10),
(10,7,11),
(11,8,12),
(12,9,1);
/*!40000 ALTER TABLE `detalle_prestamo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `herramienta`
--

DROP TABLE IF EXISTS `herramienta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `herramienta` (
  `id_herramienta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `codigo_interno` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'disponible',
  `id_categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_herramienta`),
  UNIQUE KEY `codigo_interno` (`codigo_interno`),
  KEY `fk_herramienta_categoria` (`id_categoria`),
  CONSTRAINT `fk_herramienta_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `herramienta`
--

LOCK TABLES `herramienta` WRITE;
/*!40000 ALTER TABLE `herramienta` DISABLE KEYS */;
INSERT INTO `herramienta` VALUES
(1,'Taladro eléctrico','Taladro 500W con percutor','HER-001','disponible',1),
(2,'Martillo','Martillo de carpintero 500g','HER-002','disponible',2),
(3,'Metro de carpintero','Metro plegable 2m','HER-003','disponible',3),
(4,'Sierra circular','Sierra circular 1800W','HER-004','prestada',4),
(5,'Llave inglesa','Llave ajustable 12\"','HER-005','disponible',5),
(6,'Soldador eléctrico','Soldador de arco 200A','HER-006','disponible',6),
(7,'Desmalezadora','Desmalezadora a nafta','HER-007','en reparacion',7),
(8,'Pistola de pintura','Pistola HVLP 600ml','HER-008','disponible',8),
(9,'Destornillador set','Set 12 destornilladores','HER-009','disponible',2),
(10,'Pinza amperimétrica','Pinza medidora 400A','HER-010','disponible',3),
(11,'Amoladora angular','Amoladora 115mm 850W','HER-011','disponible',1),
(12,'Nivel láser','Nivel láser autonivelante','HER-012','disponible',3);
/*!40000 ALTER TABLE `herramienta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `tipo_persona` varchar(30) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_persona`),
  UNIQUE KEY `dni` (`dni`),
  CONSTRAINT `chk_tipo_persona` CHECK (`tipo_persona` in ('docente','estudiante','personal_administrativo'))
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES
(1,'Roberto','García','20123456','docente','11-4444-1001','rgarcia@inst.edu.ar'),
(2,'Laura','Fernández','20234567','docente','11-4444-1002','lfernandez@inst.edu.ar'),
(3,'Mateo','López','40123456','estudiante','11-4444-1003','mlopez@inst.edu.ar'),
(4,'Sofía','Martínez','40234567','estudiante','11-4444-1004','smartinez@inst.edu.ar'),
(5,'Carlos','Ruiz','30123456','personal_administrativo','11-4444-1005','cruiz@inst.edu.ar'),
(6,'Ana','Morales','30234567','personal_administrativo','11-4444-1006','amorales@inst.edu.ar'),
(7,'Jorge','Pérez','20345678','docente','11-4444-1007','jperez@inst.edu.ar'),
(8,'Lucía','Gómez','40345678','estudiante','11-4444-1008','lgomez@inst.edu.ar'),
(9,'Diego','Silva','30345678','personal_administrativo','11-4444-1009','dsilva@inst.edu.ar'),
(10,'Camila','Fernández','40456789','estudiante','11-4444-1010','cfernandez@inst.edu.ar');
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamo`
--

DROP TABLE IF EXISTS `prestamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestamo` (
  `id_prestamo` int(11) NOT NULL AUTO_INCREMENT,
  `id_persona` int(11) NOT NULL,
  `fecha_prestamo` date NOT NULL,
  `fecha_devolucion_estimada` date DEFAULT NULL,
  `fecha_devolucion_real` date DEFAULT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'activo',
  PRIMARY KEY (`id_prestamo`),
  KEY `fk_prestamo_persona` (`id_persona`),
  CONSTRAINT `fk_prestamo_persona` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamo`
--

LOCK TABLES `prestamo` WRITE;
/*!40000 ALTER TABLE `prestamo` DISABLE KEYS */;
INSERT INTO `prestamo` VALUES
(1,1,'2024-04-01','2024-04-08','2024-04-07','devuelto'),
(2,3,'2024-04-02','2024-04-09',NULL,'activo'),
(3,5,'2024-04-03','2024-04-10','2024-04-10','devuelto'),
(4,2,'2024-04-05','2024-04-12',NULL,'activo'),
(5,4,'2024-04-08','2024-04-15',NULL,'activo'),
(6,6,'2024-04-10','2024-04-17','2024-04-18','devuelto'),
(7,7,'2024-04-12','2024-04-19',NULL,'activo'),
(8,8,'2024-04-15','2024-04-22',NULL,'activo'),
(9,9,'2024-04-18','2024-04-15',NULL,'vencido'),
(10,10,'2024-04-20','2024-04-27',NULL,'activo');
/*!40000 ALTER TABLE `prestamo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_herramientas'
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
