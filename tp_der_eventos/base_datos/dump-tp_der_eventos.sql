/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_eventos
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
-- Table structure for table `asistente`
--

DROP TABLE IF EXISTS `asistente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `asistente` (
  `id_asistente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `institucion` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_asistente`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistente`
--

LOCK TABLES `asistente` WRITE;
/*!40000 ALTER TABLE `asistente` DISABLE KEYS */;
INSERT INTO `asistente` VALUES
(1,'Lucía','Gómez','40123456','lgomez@mail.com','Universidad Nacional'),
(2,'Mateo','López','40234567','mlopez@mail.com','Universidad Tecnológica'),
(3,'Sofía','Martínez','40345678','smartinez@mail.com','Instituto Técnico'),
(4,'Santiago','Rodríguez','40456789','srodriguez@mail.com','Universidad Nacional'),
(5,'Camila','Fernández','40567890','cfernandez@mail.com','Universidad Privada'),
(6,'Tomás','García','40678901','tgarcia@mail.com','Instituto Técnico'),
(7,'Valentina','Díaz','40789012','vdiaz@mail.com','Universidad Tecnológica'),
(8,'Benjamín','Pérez','40890123','bperez@mail.com','Universidad Nacional'),
(9,'Emma','Sánchez','40901234','esanchez@mail.com','Universidad Privada'),
(10,'Joaquín','Torres','41012345','jtorres@mail.com','Instituto Técnico');
/*!40000 ALTER TABLE `asistente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` date NOT NULL,
  `horario` time NOT NULL,
  `lugar` varchar(150) DEFAULT NULL,
  `id_tipo` int(11) NOT NULL,
  PRIMARY KEY (`id_evento`),
  KEY `fk_evento_tipo` (`id_tipo`),
  CONSTRAINT `fk_evento_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_evento` (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES
(1,'IA en Educación','Charla sobre inteligencia artificial','2024-05-10','10:00:00','Aula Magna',1),
(2,'Jornada de Puertas Abiertas','Recorrido por la facultad','2024-05-15','09:00:00','Campus Central',2),
(3,'Congreso de Sistemas','Tercer congreso regional','2024-06-01','08:30:00','Centro de Convenciones',3),
(4,'Taller de Python','Práctica intensiva de Python','2024-06-05','14:00:00','Lab. de Informática',4),
(5,'Seminario de Redes','Últimas tendencias en redes','2024-06-10','11:00:00','Aula 201',5),
(6,'Mesa Redonda: Ética en IA','Debate sobre ética tecnológica','2024-06-15','16:00:00','Aula Magna',6),
(7,'Conferencia de Ciberseguridad','Expertos en seguridad','2024-06-20','10:00:00','Auditorio',7),
(8,'Simposio de Investigación','Presentación de papers','2024-07-01','09:00:00','Sala de Conferencias',8),
(9,'Coloquio de Matemática','Debate sobre nuevas teorías','2024-07-10','15:00:00','Aula 301',9),
(10,'Foro Estudiantil','Espacio de debate libre','2024-07-15','12:00:00','Patio Central',10);
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento_expositor`
--

DROP TABLE IF EXISTS `evento_expositor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `evento_expositor` (
  `id_evento` int(11) NOT NULL,
  `id_expositor` int(11) NOT NULL,
  PRIMARY KEY (`id_evento`,`id_expositor`),
  KEY `fk_eventoexp_expositor` (`id_expositor`),
  CONSTRAINT `fk_eventoexp_evento` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id_evento`),
  CONSTRAINT `fk_eventoexp_expositor` FOREIGN KEY (`id_expositor`) REFERENCES `expositor` (`id_expositor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento_expositor`
--

LOCK TABLES `evento_expositor` WRITE;
/*!40000 ALTER TABLE `evento_expositor` DISABLE KEYS */;
INSERT INTO `evento_expositor` VALUES
(1,1),
(1,2),
(2,11),
(3,1),
(3,4),
(3,5),
(4,6),
(5,3),
(6,2),
(7,4),
(8,9),
(10,10);
/*!40000 ALTER TABLE `evento_expositor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expositor`
--

DROP TABLE IF EXISTS `expositor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `expositor` (
  `id_expositor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `tema_exposicion` varchar(200) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_expositor`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expositor`
--

LOCK TABLES `expositor` WRITE;
/*!40000 ALTER TABLE `expositor` DISABLE KEYS */;
INSERT INTO `expositor` VALUES
(1,'Dr. Roberto','García','Machine Learning aplicado','rgarcia@uni.edu.ar'),
(2,'Dra. Laura','Fernández','Ética en tecnología','lfernandez@uni.edu.ar'),
(3,'Ing. Carlos','López','Redes 5G','clopez@uni.edu.ar'),
(4,'Dra. Ana','Martínez','Ciberseguridad empresarial','amartinez@uni.edu.ar'),
(5,'Dr. Jorge','Pérez','Big Data y análisis','jperez@uni.edu.ar'),
(6,'Ing. Silvia','Rodríguez','Python para ciencia de datos','srodriguez@uni.edu.ar'),
(7,'Dr. Miguel','Sánchez','Blockchain y criptomonedas','msanchez@uni.edu.ar'),
(8,'Dra. Patricia','Díaz','IoT en la industria','pdiaz@uni.edu.ar'),
(9,'Dr. Fernando','Ruiz','Computación cuántica','fruiz@uni.edu.ar'),
(10,'Ing. Marcela','Herrera','Desarrollo ágil','mherrera@uni.edu.ar'),
(11,'Dr. Oscar','Contreras','Historia de la computación','ocontreras@uni.edu.ar'),
(12,'Dra. Beatriz','Salazar','Matemática discreta','bsalazar@uni.edu.ar');
/*!40000 ALTER TABLE `expositor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripcion_evento`
--

DROP TABLE IF EXISTS `inscripcion_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscripcion_evento` (
  `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT,
  `id_asistente` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `fecha_inscripcion` date NOT NULL,
  PRIMARY KEY (`id_inscripcion`),
  KEY `fk_inscripcion_asistente` (`id_asistente`),
  KEY `fk_inscripcion_evento` (`id_evento`),
  CONSTRAINT `fk_inscripcion_asistente` FOREIGN KEY (`id_asistente`) REFERENCES `asistente` (`id_asistente`),
  CONSTRAINT `fk_inscripcion_evento` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion_evento`
--

LOCK TABLES `inscripcion_evento` WRITE;
/*!40000 ALTER TABLE `inscripcion_evento` DISABLE KEYS */;
INSERT INTO `inscripcion_evento` VALUES
(1,1,1,'2024-04-01'),
(2,2,1,'2024-04-02'),
(3,3,2,'2024-04-05'),
(4,4,3,'2024-04-10'),
(5,5,3,'2024-04-12'),
(6,6,4,'2024-04-15'),
(7,7,5,'2024-04-18'),
(8,8,6,'2024-04-20'),
(9,9,7,'2024-04-22'),
(10,10,8,'2024-04-25'),
(11,1,3,'2024-04-11'),
(12,2,4,'2024-04-16');
/*!40000 ALTER TABLE `inscripcion_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_evento`
--

DROP TABLE IF EXISTS `tipo_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_evento` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_evento`
--

LOCK TABLES `tipo_evento` WRITE;
/*!40000 ALTER TABLE `tipo_evento` DISABLE KEYS */;
INSERT INTO `tipo_evento` VALUES
(1,'Charla'),
(2,'Jornada'),
(3,'Congreso'),
(4,'Taller'),
(5,'Seminario'),
(6,'Mesa Redonda'),
(7,'Conferencia'),
(8,'Simposio'),
(9,'Coloquio'),
(10,'Foro');
/*!40000 ALTER TABLE `tipo_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_eventos'
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
