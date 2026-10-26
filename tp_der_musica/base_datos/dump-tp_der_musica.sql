/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_musica
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
  `id_instrumento` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `dia` varchar(20) NOT NULL,
  `horario` time NOT NULL,
  `cupo_maximo` int(11) NOT NULL,
  PRIMARY KEY (`id_curso`),
  KEY `fk_curso_instrumento` (`id_instrumento`),
  KEY `fk_curso_docente` (`id_docente`),
  CONSTRAINT `fk_curso_docente` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`),
  CONSTRAINT `fk_curso_instrumento` FOREIGN KEY (`id_instrumento`) REFERENCES `instrumento` (`id_instrumento`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--

LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;
INSERT INTO `curso` VALUES
(1,1,1,'Lunes','08:00:00',10),
(2,2,2,'Martes','09:00:00',5),
(3,3,3,'Miércoles','10:00:00',8),
(4,4,4,'Jueves','08:30:00',6),
(5,5,5,'Viernes','09:00:00',8),
(6,6,6,'Lunes','14:00:00',6),
(7,7,7,'Martes','15:00:00',8),
(8,8,8,'Miércoles','16:00:00',6),
(9,10,10,'Jueves','10:00:00',12),
(10,1,11,'Viernes','14:00:00',10);
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
  `id_instrumento` int(11) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_docente`),
  KEY `fk_docente_instrumento` (`id_instrumento`),
  CONSTRAINT `fk_docente_instrumento` FOREIGN KEY (`id_instrumento`) REFERENCES `instrumento` (`id_instrumento`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docente`
--

LOCK TABLES `docente` WRITE;
/*!40000 ALTER TABLE `docente` DISABLE KEYS */;
INSERT INTO `docente` VALUES
(1,'Roberto','García',1,'rgarcia@musica.edu.ar'),
(2,'Laura','Fernández',2,'lfernandez@musica.edu.ar'),
(3,'Carlos','López',3,'clopez@musica.edu.ar'),
(4,'Ana','Martínez',4,'amartinez@musica.edu.ar'),
(5,'Jorge','Pérez',5,'jperez@musica.edu.ar'),
(6,'Silvia','Rodríguez',6,'srodriguez@musica.edu.ar'),
(7,'Miguel','Sánchez',7,'msanchez@musica.edu.ar'),
(8,'Patricia','Díaz',8,'pdiaz@musica.edu.ar'),
(9,'Fernando','Ruiz',9,'fruiz@musica.edu.ar'),
(10,'Marcela','Herrera',10,'mherrera@musica.edu.ar'),
(11,'Oscar','Contreras',1,'ocontreras@musica.edu.ar'),
(12,'Beatriz','Salazar',2,'bsalazar@musica.edu.ar');
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
  `edad` int(11) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_estudiante`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante`
--

LOCK TABLES `estudiante` WRITE;
/*!40000 ALTER TABLE `estudiante` DISABLE KEYS */;
INSERT INTO `estudiante` VALUES
(1,'Lucía','Gómez','45123456',15,'11-3333-1001'),
(2,'Mateo','López','45234567',17,'11-3333-1002'),
(3,'Sofía','Martínez','45345678',14,'11-3333-1003'),
(4,'Santiago','Rodríguez','45456789',16,'11-3333-1004'),
(5,'Camila','Fernández','45567890',18,'11-3333-1005'),
(6,'Tomás','García','45678901',13,'11-3333-1006'),
(7,'Valentina','Díaz','45789012',15,'11-3333-1007'),
(8,'Benjamín','Pérez','45890123',20,'11-3333-1008'),
(9,'Emma','Sánchez','45901234',16,'11-3333-1009'),
(10,'Joaquín','Torres','46012345',14,'11-3333-1010');
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
  PRIMARY KEY (`id_inscripcion`),
  KEY `fk_inscripcion_estudiante` (`id_estudiante`),
  KEY `fk_inscripcion_curso` (`id_curso`),
  CONSTRAINT `fk_inscripcion_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`),
  CONSTRAINT `fk_inscripcion_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion`
--

LOCK TABLES `inscripcion` WRITE;
/*!40000 ALTER TABLE `inscripcion` DISABLE KEYS */;
INSERT INTO `inscripcion` VALUES
(1,1,1,'2024-03-01'),
(2,1,2,'2024-03-01'),
(3,2,3,'2024-03-05'),
(4,3,4,'2024-03-06'),
(5,4,5,'2024-03-07'),
(6,5,6,'2024-03-08'),
(7,6,7,'2024-03-09'),
(8,7,8,'2024-03-10'),
(9,8,9,'2024-03-11'),
(10,9,10,'2024-03-12'),
(11,10,1,'2024-03-13'),
(12,3,2,'2024-03-14');
/*!40000 ALTER TABLE `inscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instrumento`
--

DROP TABLE IF EXISTS `instrumento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `instrumento` (
  `id_instrumento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  PRIMARY KEY (`id_instrumento`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instrumento`
--

LOCK TABLES `instrumento` WRITE;
/*!40000 ALTER TABLE `instrumento` DISABLE KEYS */;
INSERT INTO `instrumento` VALUES
(1,'Guitarra'),
(2,'Piano'),
(3,'Violín'),
(4,'Batería'),
(5,'Bajo'),
(6,'Saxofón'),
(7,'Flauta traversa'),
(8,'Trompeta'),
(9,'Acordeón'),
(10,'Canto');
/*!40000 ALTER TABLE `instrumento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_musica'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-06 16:29:42
