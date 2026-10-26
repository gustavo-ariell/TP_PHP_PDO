/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_capacitacion
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
-- Table structure for table `curso`
--

DROP TABLE IF EXISTS `curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `curso` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `duracion` varchar(50) DEFAULT NULL,
  `modalidad` varchar(50) DEFAULT NULL,
  `id_docente` int(11) NOT NULL,
  PRIMARY KEY (`id_curso`),
  KEY `fk_curso_docente` (`id_docente`),
  CONSTRAINT `fk_curso_docente` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--

LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;
INSERT INTO `curso` VALUES
(1,'Excel Avanzado','Tablas dinámicas y macros','40 horas','Presencial',1),
(2,'Programación Python','Introducción a Python','60 horas','Virtual',2),
(3,'Diseño Gráfico','Photoshop e Illustrator','50 horas','Presencial',3),
(4,'Marketing Digital','Redes sociales y SEO','30 horas','Virtual',4),
(5,'Contabilidad Básica','Principios contables','45 horas','Presencial',5),
(6,'Inglés Intermedio','Conversación y gramática','80 horas','Presencial',6),
(7,'Gestión de Proyectos','Metodologías ágiles','35 horas','Virtual',7),
(8,'Base de Datos','Modelado y SQL','50 horas','Presencial',8),
(9,'Redes Informáticas','Configuración de redes','40 horas','Virtual',9),
(10,'Atención al Cliente','Comunicación efectiva','20 horas','Presencial',10),
(11,'Ciberseguridad','Fundamentos de seguridad','45 horas','Virtual',2),
(12,'Power BI','Visualización de datos','30 horas','Presencial',1);
/*!40000 ALTER TABLE `curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docente`
--

DROP TABLE IF EXISTS `docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `docente` (
  `id_docente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_docente`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docente`
--

LOCK TABLES `docente` WRITE;
/*!40000 ALTER TABLE `docente` DISABLE KEYS */;
INSERT INTO `docente` VALUES
(1,'Roberto','García','20123456','rgarcia@inst.edu.ar','11-7777-1001'),
(2,'Laura','Fernández','20234567','lfernandez@inst.edu.ar','11-7777-1002'),
(3,'Carlos','López','20345678','clopez@inst.edu.ar','11-7777-1003'),
(4,'Ana','Martínez','20456789','amartinez@inst.edu.ar','11-7777-1004'),
(5,'Jorge','Pérez','20567890','jperez@inst.edu.ar','11-7777-1005'),
(6,'Silvia','Rodríguez','20678901','srodriguez@inst.edu.ar','11-7777-1006'),
(7,'Miguel','Sánchez','20789012','msanchez@inst.edu.ar','11-7777-1007'),
(8,'Patricia','Díaz','20890123','pdiaz@inst.edu.ar','11-7777-1008'),
(9,'Fernando','Ruiz','20901234','fruiz@inst.edu.ar','11-7777-1009'),
(10,'Marcela','Herrera','21012345','mherrera@inst.edu.ar','11-7777-1010');
/*!40000 ALTER TABLE `docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante`
--

DROP TABLE IF EXISTS `estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiante` (
  `id_estudiante` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_estudiante`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante`
--

LOCK TABLES `estudiante` WRITE;
/*!40000 ALTER TABLE `estudiante` DISABLE KEYS */;
INSERT INTO `estudiante` VALUES
(1,'Lucía','Gómez','40123456','lgomez@mail.com','11-8888-1001'),
(2,'Mateo','López','40234567','mlopez@mail.com','11-8888-1002'),
(3,'Sofía','Martínez','40345678','smartinez@mail.com','11-8888-1003'),
(4,'Santiago','Rodríguez','40456789','srodriguez@mail.com','11-8888-1004'),
(5,'Camila','Fernández','40567890','cfernandez@mail.com','11-8888-1005'),
(6,'Tomás','García','40678901','tgarcia@mail.com','11-8888-1006'),
(7,'Valentina','Díaz','40789012','vdiaz@mail.com','11-8888-1007'),
(8,'Benjamín','Pérez','40890123','bperez@mail.com','11-8888-1008'),
(9,'Emma','Sánchez','40901234','esanchez@mail.com','11-8888-1009'),
(10,'Joaquín','Torres','41012345','jtorres@mail.com','11-8888-1010');
/*!40000 ALTER TABLE `estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripcion`
--

DROP TABLE IF EXISTS `inscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscripcion` (
  `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT,
  `id_estudiante` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `fecha_inscripcion` date NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'activa',
  `calificacion_final` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`id_inscripcion`),
  KEY `fk_inscripcion_estudiante` (`id_estudiante`),
  KEY `fk_inscripcion_curso` (`id_curso`),
  CONSTRAINT `fk_inscripcion_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`),
  CONSTRAINT `fk_inscripcion_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion`
--

LOCK TABLES `inscripcion` WRITE;
/*!40000 ALTER TABLE `inscripcion` DISABLE KEYS */;
INSERT INTO `inscripcion` VALUES
(1,1,1,'2024-03-01','finalizada',8.50),
(2,1,2,'2024-03-01','activa',NULL),
(3,2,3,'2024-03-05','finalizada',9.00),
(4,3,4,'2024-03-10','activa',NULL),
(5,4,5,'2024-03-12','finalizada',7.25),
(6,5,6,'2024-03-15','activa',NULL),
(7,6,7,'2024-03-18','cancelada',NULL),
(8,7,8,'2024-03-20','activa',NULL),
(9,8,1,'2024-03-22','finalizada',6.75),
(10,9,9,'2024-03-25','activa',NULL),
(11,10,10,'2024-03-28','finalizada',8.00),
(12,2,11,'2024-04-01','activa',NULL);
/*!40000 ALTER TABLE `inscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_capacitacion'
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
