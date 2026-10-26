/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_clinica
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
-- Table structure for table `consultorio`
--

DROP TABLE IF EXISTS `consultorio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `consultorio` (
  `id_consultorio` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(20) NOT NULL,
  `piso` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_consultorio`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultorio`
--

LOCK TABLES `consultorio` WRITE;
/*!40000 ALTER TABLE `consultorio` DISABLE KEYS */;
INSERT INTO `consultorio` VALUES
(1,'C-101',1),
(2,'C-102',1),
(3,'C-103',1),
(4,'C-201',2),
(5,'C-202',2),
(6,'C-203',2),
(7,'C-301',3),
(8,'C-302',3),
(9,'C-303',3),
(10,'C-401',4),
(11,'C-402',4),
(12,'C-403',4);
/*!40000 ALTER TABLE `consultorio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidad`
--

DROP TABLE IF EXISTS `especialidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `especialidad` (
  `id_especialidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_especialidad`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidad`
--

LOCK TABLES `especialidad` WRITE;
/*!40000 ALTER TABLE `especialidad` DISABLE KEYS */;
INSERT INTO `especialidad` VALUES
(1,'Clínica Médica'),
(2,'Cardiología'),
(3,'Pediatría'),
(4,'Dermatología'),
(5,'Traumatología'),
(6,'Oftalmología'),
(7,'Ginecología'),
(8,'Neurología'),
(9,'Otorrinolaringología'),
(10,'Urología');
/*!40000 ALTER TABLE `especialidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medico`
--

DROP TABLE IF EXISTS `medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `medico` (
  `id_medico` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `matricula` varchar(30) NOT NULL,
  `id_especialidad` int(11) NOT NULL,
  PRIMARY KEY (`id_medico`),
  UNIQUE KEY `matricula` (`matricula`),
  KEY `fk_medico_especialidad` (`id_especialidad`),
  CONSTRAINT `fk_medico_especialidad` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`id_especialidad`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medico`
--

LOCK TABLES `medico` WRITE;
/*!40000 ALTER TABLE `medico` DISABLE KEYS */;
INSERT INTO `medico` VALUES
(1,'Alberto','Suárez','MP-10001',1),
(2,'Elena','Morales','MP-10002',2),
(3,'Jorge','Castro','MP-10003',3),
(4,'Patricia','Herrera','MP-10004',4),
(5,'Raúl','Acosta','MP-10005',5),
(6,'Mónica','Flores','MP-10006',6),
(7,'Sergio','Ríos','MP-10007',7),
(8,'Gabriela','Campos','MP-10008',8),
(9,'Andrés','Navarro','MP-10009',9),
(10,'Cecilia','Vega','MP-10010',10);
/*!40000 ALTER TABLE `medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente` (
  `id_paciente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `obra_social` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_paciente`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES
(1,'María','López','30123456','1985-05-10','11-5555-2001','OSDE'),
(2,'Juan','Pérez','30234567','1990-08-22','11-5555-2002','Swiss Medical'),
(3,'Ana','García','30345678','1978-12-03','11-5555-2003','Galeno'),
(4,'Pedro','Rodríguez','30456789','2000-03-15','11-5555-2004','PAMI'),
(5,'Laura','Martínez','30567890','1995-07-20','11-5555-2005','IOMA'),
(6,'Carlos','Sánchez','30678901','1960-01-30','11-5555-2006','OSDE'),
(7,'Lucía','Fernández','30789012','2010-11-11','11-5555-2007','Swiss Medical'),
(8,'Roberto','Gómez','30890123','1972-09-05','11-5555-2008','Galeno'),
(9,'Carmen','Díaz','30901234','1988-04-18','11-5555-2009','Medifé'),
(10,'Hugo','Torres','31012345','1955-06-25','11-5555-2010','PAMI'),
(11,'Silvia','Ruiz','31123456','1992-02-14','11-5555-2011','OSDE'),
(12,'Miguel','Moreno','31234567','1983-10-08','11-5555-2012','Galeno');
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turno`
--

DROP TABLE IF EXISTS `turno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `turno` (
  `id_turno` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `id_consultorio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'reservado',
  PRIMARY KEY (`id_turno`),
  KEY `fk_turno_paciente` (`id_paciente`),
  KEY `fk_turno_medico` (`id_medico`),
  KEY `fk_turno_consultorio` (`id_consultorio`),
  CONSTRAINT `fk_turno_consultorio` FOREIGN KEY (`id_consultorio`) REFERENCES `consultorio` (`id_consultorio`),
  CONSTRAINT `fk_turno_medico` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`),
  CONSTRAINT `fk_turno_paciente` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`),
  CONSTRAINT `chk_estado_turno` CHECK (`estado` in ('reservado','atendido','cancelado','ausente'))
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turno`
--

LOCK TABLES `turno` WRITE;
/*!40000 ALTER TABLE `turno` DISABLE KEYS */;
INSERT INTO `turno` VALUES
(1,1,1,1,'2024-04-01','08:00:00','atendido'),
(2,2,2,4,'2024-04-01','09:00:00','atendido'),
(3,3,3,5,'2024-04-02','10:00:00','reservado'),
(4,4,4,6,'2024-04-02','11:00:00','reservado'),
(5,5,5,7,'2024-04-03','08:30:00','reservado'),
(6,6,6,8,'2024-04-03','09:30:00','reservado'),
(7,7,3,5,'2024-04-04','10:30:00','atendido'),
(8,8,8,9,'2024-04-04','11:30:00','ausente'),
(9,9,1,1,'2024-04-05','08:00:00','reservado'),
(10,10,7,10,'2024-04-05','09:00:00','reservado'),
(11,11,2,4,'2024-04-06','10:00:00','reservado'),
(12,12,9,11,'2024-04-06','11:00:00','cancelado');
/*!40000 ALTER TABLE `turno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_clinica'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-06 16:29:40
