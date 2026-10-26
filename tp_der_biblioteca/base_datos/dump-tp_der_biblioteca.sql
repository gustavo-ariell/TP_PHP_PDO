/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_biblioteca
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
-- Table structure for table `autor`
--

DROP TABLE IF EXISTS `autor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `autor` (
  `id_autor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nacionalidad` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id_autor`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autor`
--

LOCK TABLES `autor` WRITE;
/*!40000 ALTER TABLE `autor` DISABLE KEYS */;
INSERT INTO `autor` VALUES
(1,'Jorge Luis','Borges','Argentina'),
(2,'Julio','Cortázar','Argentina'),
(3,'Gabriel','García Márquez','Colombiana'),
(4,'Mario','Vargas Llosa','Peruana'),
(5,'Pablo','Neruda','Chilena'),
(6,'Isabel','Allende','Chilena'),
(7,'Ernesto','Sábato','Argentina'),
(8,'Adolfo','Bioy Casares','Argentina'),
(9,'Laura','Esquivel','Italiana'),
(10,'Federico','García Lorca','Española');
/*!40000 ALTER TABLE `autor` ENABLE KEYS */;
UNLOCK TABLES;

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
(1,'Novela'),
(2,'Ciencia'),
(3,'Historia'),
(4,'Matemáticas'),
(5,'Literatura Infantil'),
(6,'Geografía'),
(7,'Arte'),
(8,'Tecnología'),
(9,'Filosofía'),
(10,'Biografía');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `editorial`
--

DROP TABLE IF EXISTS `editorial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `editorial` (
  `id_editorial` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_editorial`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editorial`
--

LOCK TABLES `editorial` WRITE;
/*!40000 ALTER TABLE `editorial` DISABLE KEYS */;
INSERT INTO `editorial` VALUES
(1,'Santillana','Av. Corrientes 1234','011-4567-1234'),
(2,'Kapelusz','Av. Santa Fe 5678','011-4567-5678'),
(3,'Estrada','Av. de Mayo 910','011-4567-0910'),
(4,'Aique','Av. Belgrano 1122','011-4567-1122'),
(5,'AZ','Av. Rivadavia 3344','011-4567-3344'),
(6,'Puerto de Palos','Calle Falsa 5566','011-4567-5566'),
(7,'Siglo XXI','Av. Córdoba 7788','011-4567-7788'),
(8,'Planeta','Av. Libertador 9900','011-4567-9900'),
(9,'Sudamericana','Av. Paseo Colón 1010','011-4567-1010'),
(10,'Emecé','Av. Callao 2020','011-4567-2020'),
(11,'Losada','Av. Entre Ríos 3030','011-4567-3030'),
(12,'Huemul','Av. Belgrano 4040','011-4567-4040');
/*!40000 ALTER TABLE `editorial` ENABLE KEYS */;
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
  `curso` varchar(50) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_estudiante`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante`
--

LOCK TABLES `estudiante` WRITE;
/*!40000 ALTER TABLE `estudiante` DISABLE KEYS */;
INSERT INTO `estudiante` VALUES
(1,'Lucía','Gómez','40123456','3ro A','11-5555-1001','lgomez@mail.com'),
(2,'Mateo','López','40234567','2do B','11-5555-1002','mlopez@mail.com'),
(3,'Sofía','Martínez','40345678','1ro A','11-5555-1003','smartinez@mail.com'),
(4,'Santiago','Rodríguez','40456789','3ro B','11-5555-1004','srodriguez@mail.com'),
(5,'Camila','Fernández','40567890','2do A','11-5555-1005','cfernandez@mail.com'),
(6,'Tomás','García','40678901','1ro B','11-5555-1006','tgarcia@mail.com'),
(7,'Valentina','Díaz','40789012','3ro A','11-5555-1007','vdiaz@mail.com'),
(8,'Benjamín','Pérez','40890123','2do B','11-5555-1008','bperez@mail.com'),
(9,'Emma','Sánchez','40901234','1ro A','11-5555-1009','esanchez@mail.com'),
(10,'Joaquín','Torres','41012345','3ro B','11-5555-1010','jtorres@mail.com'),
(11,'Isabella','Romero','41123456','2do A','11-5555-1011','iromero@mail.com'),
(12,'Nicolás','Álvarez','41234567','1ro B','11-5555-1012','nalvarez@mail.com');
/*!40000 ALTER TABLE `estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libro`
--

DROP TABLE IF EXISTS `libro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `libro` (
  `id_libro` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `anio_publicacion` smallint(6) DEFAULT NULL,
  `cantidad_ejemplares` int(11) NOT NULL DEFAULT 1,
  `id_categoria` int(11) DEFAULT NULL,
  `id_editorial` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_libro`),
  UNIQUE KEY `isbn` (`isbn`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_editorial` (`id_editorial`),
  CONSTRAINT `libro_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  CONSTRAINT `libro_ibfk_2` FOREIGN KEY (`id_editorial`) REFERENCES `editorial` (`id_editorial`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libro`
--

LOCK TABLES `libro` WRITE;
/*!40000 ALTER TABLE `libro` DISABLE KEYS */;
INSERT INTO `libro` VALUES
(1,'El Aleph','978-950-01-0001-1',1949,3,1,8),
(2,'Rayuela','978-950-01-0002-2',1963,5,1,9),
(3,'Cien Años de Soledad','978-950-01-0003-3',1967,4,1,8),
(4,'La Casa Verde','978-950-01-0004-4',1966,2,1,10),
(5,'Álgebra de Baldor','978-950-01-0005-5',1978,8,4,2),
(6,'Historia Argentina','978-950-01-0006-6',2005,6,3,1),
(7,'El Túnel','978-950-01-0007-7',1948,3,1,8),
(8,'Ficciones','978-950-01-0008-8',1944,4,1,8),
(9,'Biología Elemental','978-950-01-0009-9',2010,7,2,1),
(10,'Geografía Mundial','978-950-01-0010-0',2015,5,6,3),
(11,'Introducción a la Filosofía','978-950-00-0011-1',2012,3,9,4),
(12,'Don Quijote','978-950-01-0012-2',1605,2,1,6),
(13,'Asi hablaba Zaratustra','978-950-01-9999-0',1895,100,9,5);
/*!40000 ALTER TABLE `libro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libro_autor`
--

DROP TABLE IF EXISTS `libro_autor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `libro_autor` (
  `id_libro` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  PRIMARY KEY (`id_libro`,`id_autor`),
  KEY `id_autor` (`id_autor`),
  CONSTRAINT `libro_autor_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`),
  CONSTRAINT `libro_autor_ibfk_2` FOREIGN KEY (`id_autor`) REFERENCES `autor` (`id_autor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libro_autor`
--

LOCK TABLES `libro_autor` WRITE;
/*!40000 ALTER TABLE `libro_autor` DISABLE KEYS */;
INSERT INTO `libro_autor` VALUES
(1,1),
(2,2),
(3,3),
(4,4),
(5,1),
(7,7),
(8,1),
(8,8),
(11,1),
(12,10);
/*!40000 ALTER TABLE `libro_autor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamo`
--

DROP TABLE IF EXISTS `prestamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestamo` (
  `id_prestamo` int(11) NOT NULL AUTO_INCREMENT,
  `id_libro` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `fecha_prestamo` date NOT NULL,
  `fecha_devolucion_estimada` date DEFAULT NULL,
  `fecha_devolucion_real` date DEFAULT NULL,
  PRIMARY KEY (`id_prestamo`),
  KEY `id_libro` (`id_libro`),
  KEY `id_estudiante` (`id_estudiante`),
  CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`),
  CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamo`
--

LOCK TABLES `prestamo` WRITE;
/*!40000 ALTER TABLE `prestamo` DISABLE KEYS */;
INSERT INTO `prestamo` VALUES
(1,1,1,'2024-03-01','2024-03-15','2024-03-14'),
(2,2,2,'2024-03-05','2024-03-19','2024-03-20'),
(3,3,3,'2024-03-10','2024-03-24',NULL),
(4,5,4,'2024-03-12','2024-03-26','2024-03-25'),
(5,4,5,'2024-03-15','2024-03-29',NULL),
(6,6,6,'2024-04-01','2024-04-15','2024-04-14'),
(7,7,7,'2024-04-05','2024-04-19',NULL),
(8,8,8,'2024-04-10','2024-04-24','2024-04-23'),
(9,9,1,'2024-04-15','2024-04-29',NULL),
(10,10,2,'2024-05-01','2024-05-15','2024-05-14'),
(11,11,9,'2024-05-03','2024-05-17',NULL),
(12,12,10,'2024-05-05','2024-05-19','2024-05-18');
/*!40000 ALTER TABLE `prestamo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_biblioteca'
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
