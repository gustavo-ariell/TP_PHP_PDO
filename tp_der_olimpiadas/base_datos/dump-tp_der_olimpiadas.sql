/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_olimpiadas
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
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--

LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;
INSERT INTO `curso` VALUES
(1,'1ro'),
(2,'2do'),
(3,'3ro'),
(4,'4to'),
(5,'5to'),
(6,'6to'),
(7,'7mo'),
(8,'1ro A'),
(9,'2do A'),
(10,'3ro A');
/*!40000 ALTER TABLE `curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disciplina`
--

DROP TABLE IF EXISTS `disciplina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `disciplina` (
  `id_disciplina` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id_disciplina`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disciplina`
--

LOCK TABLES `disciplina` WRITE;
/*!40000 ALTER TABLE `disciplina` DISABLE KEYS */;
INSERT INTO `disciplina` VALUES
(1,'Atletismo','Pruebas de pista y campo'),
(2,'Natación','Pruebas en pileta olímpica'),
(3,'Fútbol','Torneo de fútbol 11'),
(4,'Básquet','Torneo de básquetbol 5x5'),
(5,'Vóley','Torneo de voleibol'),
(6,'Handball','Torneo de handball'),
(7,'Tenis de Mesa','Individual y dobles'),
(8,'Ajedrez','Torneo por sistema suizo'),
(9,'Gimnasia Artística','Rutinas en distintos aparatos'),
(10,'Ciclismo','Pruebas de ruta y contrarreloj'),
(11,'Boxeo','Torneo por categorías de peso'),
(12,'Rugby','Torneo de rugby 7');
/*!40000 ALTER TABLE `disciplina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `division`
--

DROP TABLE IF EXISTS `division`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `division` (
  `id_division` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_division`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `division`
--

LOCK TABLES `division` WRITE;
/*!40000 ALTER TABLE `division` DISABLE KEYS */;
INSERT INTO `division` VALUES
(1,'A'),
(2,'B'),
(3,'C'),
(4,'D'),
(5,'E'),
(6,'1ra'),
(7,'2da'),
(8,'3ra'),
(9,'Única'),
(10,'Especial');
/*!40000 ALTER TABLE `division` ENABLE KEYS */;
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
  `direccion` varchar(200) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `id_division` int(11) DEFAULT NULL,
  `id_localidad` int(11) DEFAULT NULL,
  `id_provincia` int(11) DEFAULT NULL,
  `id_pais` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_estudiante`),
  UNIQUE KEY `dni` (`dni`),
  KEY `fk_estudiante_curso` (`id_curso`),
  KEY `fk_estudiante_division` (`id_division`),
  KEY `fk_estudiante_localidad` (`id_localidad`),
  KEY `fk_estudiante_provincia` (`id_provincia`),
  KEY `fk_estudiante_pais` (`id_pais`),
  CONSTRAINT `fk_estudiante_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`),
  CONSTRAINT `fk_estudiante_division` FOREIGN KEY (`id_division`) REFERENCES `division` (`id_division`),
  CONSTRAINT `fk_estudiante_localidad` FOREIGN KEY (`id_localidad`) REFERENCES `localidad` (`id_localidad`),
  CONSTRAINT `fk_estudiante_pais` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id_pais`),
  CONSTRAINT `fk_estudiante_provincia` FOREIGN KEY (`id_provincia`) REFERENCES `provincia` (`id_provincia`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante`
--

LOCK TABLES `estudiante` WRITE;
/*!40000 ALTER TABLE `estudiante` DISABLE KEYS */;
INSERT INTO `estudiante` VALUES
(1,'Lucía','Gómez','45123456','Calle 10 Nro 123',3,1,1,1,1),
(2,'Mateo','López','45234567','Calle 12 Nro 456',2,2,2,1,1),
(3,'Sofía','Martínez','45345678','Av. San Martín 789',1,1,3,2,1),
(4,'Santiago','Rodríguez','45456789','Belgrano 1010',4,1,4,3,1),
(5,'Camila','Fernández','45567890','Rivadavia 2020',3,2,5,4,1),
(6,'Tomás','García','45678901','Mitre 3030',2,1,6,5,1),
(7,'Valentina','Díaz','45789012','Sarmiento 4040',5,1,1,1,1),
(8,'Benjamín','Pérez','45890123','Urquiza 5050',1,2,3,2,1),
(9,'Emma','Sánchez','45901234','Alsina 6060',4,2,4,3,1),
(10,'Joaquín','Torres','46012345','Moreno 7070',3,1,5,4,1),
(11,'Isabella','Romero','46123456','Lavalle 8080',2,2,1,1,1),
(12,'Nicolás','Álvarez','46234567','Corrientes 9090',1,1,2,1,1);
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
  `id_disciplina` int(11) NOT NULL,
  `fecha_inscripcion` date NOT NULL,
  `anio_participacion` smallint(6) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'pendiente',
  PRIMARY KEY (`id_inscripcion`),
  KEY `fk_inscripcion_estudiante` (`id_estudiante`),
  KEY `fk_inscripcion_disciplina` (`id_disciplina`),
  CONSTRAINT `fk_inscripcion_disciplina` FOREIGN KEY (`id_disciplina`) REFERENCES `disciplina` (`id_disciplina`),
  CONSTRAINT `fk_inscripcion_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`),
  CONSTRAINT `chk_estado_inscripcion` CHECK (`estado` in ('pendiente','confirmada','cancelada'))
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion`
--

LOCK TABLES `inscripcion` WRITE;
/*!40000 ALTER TABLE `inscripcion` DISABLE KEYS */;
INSERT INTO `inscripcion` VALUES
(1,1,1,'2024-02-15',2024,'confirmada'),
(2,2,2,'2024-02-16',2024,'confirmada'),
(3,3,3,'2024-02-17',2024,'pendiente'),
(4,4,4,'2024-02-18',2024,'confirmada'),
(5,5,5,'2024-02-19',2024,'cancelada'),
(6,6,1,'2024-02-20',2024,'confirmada'),
(7,7,8,'2024-02-21',2024,'pendiente'),
(8,8,7,'2024-02-22',2024,'confirmada'),
(9,9,6,'2024-02-23',2024,'confirmada'),
(10,10,9,'2024-02-24',2024,'pendiente'),
(11,11,2,'2024-02-25',2024,'confirmada'),
(12,12,12,'2024-02-26',2024,'confirmada');
/*!40000 ALTER TABLE `inscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `localidad`
--

DROP TABLE IF EXISTS `localidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `localidad` (
  `id_localidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  PRIMARY KEY (`id_localidad`),
  KEY `fk_localidad_provincia` (`id_provincia`),
  CONSTRAINT `fk_localidad_provincia` FOREIGN KEY (`id_provincia`) REFERENCES `provincia` (`id_provincia`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `localidad`
--

LOCK TABLES `localidad` WRITE;
/*!40000 ALTER TABLE `localidad` DISABLE KEYS */;
INSERT INTO `localidad` VALUES
(1,'La Plata',1),
(2,'Mar del Plata',1),
(3,'Córdoba Capital',2),
(4,'Rosario',3),
(5,'Mendoza Capital',4),
(6,'San Miguel de Tucumán',5),
(7,'San Pablo',6),
(8,'Santiago Centro',8),
(9,'Montevideo Centro',10),
(10,'Asunción Centro',11);
/*!40000 ALTER TABLE `localidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pais` (
  `id_pais` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pais`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES
(1,'Argentina'),
(2,'Brasil'),
(3,'Chile'),
(4,'Uruguay'),
(5,'Paraguay'),
(6,'Bolivia'),
(7,'Perú'),
(8,'Colombia'),
(9,'Venezuela'),
(10,'Ecuador');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincia`
--

DROP TABLE IF EXISTS `provincia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `provincia` (
  `id_provincia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `id_pais` int(11) NOT NULL,
  PRIMARY KEY (`id_provincia`),
  KEY `fk_provincia_pais` (`id_pais`),
  CONSTRAINT `fk_provincia_pais` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id_pais`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincia`
--

LOCK TABLES `provincia` WRITE;
/*!40000 ALTER TABLE `provincia` DISABLE KEYS */;
INSERT INTO `provincia` VALUES
(1,'Buenos Aires',1),
(2,'Córdoba',1),
(3,'Santa Fe',1),
(4,'Mendoza',1),
(5,'Tucumán',1),
(6,'São Paulo',2),
(7,'Río de Janeiro',2),
(8,'Santiago',3),
(9,'Valparaíso',3),
(10,'Montevideo',4),
(11,'Asunción',5),
(12,'La Paz',6);
/*!40000 ALTER TABLE `provincia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_olimpiadas'
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
