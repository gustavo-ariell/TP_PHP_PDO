/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_comedor
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
  `carrera` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
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
(1,'Lucía','Gómez','42123456','Ingeniería en Sistemas','lgomez@uni.edu.ar'),
(2,'Mateo','López','42234567','Medicina','mlopez@uni.edu.ar'),
(3,'Sofía','Martínez','42345678','Abogacía','smartinez@uni.edu.ar'),
(4,'Santiago','Rodríguez','42456789','Contador Público','srodriguez@uni.edu.ar'),
(5,'Camila','Fernández','42567890','Arquitectura','cfernandez@uni.edu.ar'),
(6,'Tomás','García','42678901','Ingeniería Civil','tgarcia@uni.edu.ar'),
(7,'Valentina','Díaz','42789012','Profesorado de Matemática','vdiaz@uni.edu.ar'),
(8,'Benjamín','Pérez','42890123','Lic. en Sistemas','bperez@uni.edu.ar'),
(9,'Emma','Sánchez','42901234','Enfermería','esanchez@uni.edu.ar'),
(10,'Joaquín','Torres','43012345','Economía','jtorres@uni.edu.ar');
/*!40000 ALTER TABLE `estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forma_pago`
--

DROP TABLE IF EXISTS `forma_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `forma_pago` (
  `id_forma_pago` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  PRIMARY KEY (`id_forma_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forma_pago`
--

LOCK TABLES `forma_pago` WRITE;
/*!40000 ALTER TABLE `forma_pago` DISABLE KEYS */;
INSERT INTO `forma_pago` VALUES
(1,'Efectivo'),
(2,'Tarjeta de Débito'),
(3,'Tarjeta de Crédito'),
(4,'Bono estudiantil'),
(5,'Transferencia'),
(6,'QR'),
(7,'Mercado Pago'),
(8,'Billetera Santa Fe'),
(9,'App Universitaria'),
(10,'Cuponera');
/*!40000 ALTER TABLE `forma_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES
(1,'2024-04-01','Menú del lunes'),
(2,'2024-04-02','Menú del martes'),
(3,'2024-04-03','Menú del miércoles'),
(4,'2024-04-04','Menú del jueves'),
(5,'2024-04-05','Menú del viernes'),
(6,'2024-04-08','Menú del lunes siguiente'),
(7,'2024-04-09','Menú del martes siguiente'),
(8,'2024-04-10','Menú del miércoles siguiente'),
(9,'2024-04-11','Menú del jueves siguiente'),
(10,'2024-04-12','Menú del viernes siguiente');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_plato`
--

DROP TABLE IF EXISTS `menu_plato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_plato` (
  `id_menu` int(11) NOT NULL,
  `id_plato` int(11) NOT NULL,
  PRIMARY KEY (`id_menu`,`id_plato`),
  KEY `fk_menuplato_plato` (`id_plato`),
  CONSTRAINT `fk_menuplato_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`),
  CONSTRAINT `fk_menuplato_plato` FOREIGN KEY (`id_plato`) REFERENCES `plato` (`id_plato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_plato`
--

LOCK TABLES `menu_plato` WRITE;
/*!40000 ALTER TABLE `menu_plato` DISABLE KEYS */;
INSERT INTO `menu_plato` VALUES
(1,1),
(1,3),
(1,8),
(2,2),
(2,4),
(2,9),
(3,1),
(3,5),
(3,10),
(4,6),
(4,7),
(4,11),
(5,5),
(5,7),
(5,8);
/*!40000 ALTER TABLE `menu_plato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plato`
--

DROP TABLE IF EXISTS `plato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `plato` (
  `id_plato` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_plato`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plato`
--

LOCK TABLES `plato` WRITE;
/*!40000 ALTER TABLE `plato` DISABLE KEYS */;
INSERT INTO `plato` VALUES
(1,'Ensalada mixta','Lechuga, tomate y zanahoria','Entrada'),
(2,'Sopa de verduras','Caldo con verduras variadas','Entrada'),
(3,'Milanesa con puré','Milanesa de carne con puré de papas','Principal'),
(4,'Tallarines con tuco','Pasta con salsa de tomate y carne','Principal'),
(5,'Pollo al horno','Pollo con papas y batatas al horno','Principal'),
(6,'Ensalada rusa','Papas, arvejas, zanahoria y mayonesa','Entrada'),
(7,'Guiso de lentejas','Lentejas con carne y verduras','Principal'),
(8,'Flan con dulce','Flan casero con dulce de leche','Postre'),
(9,'Helado','Bocha de helado a elección','Postre'),
(10,'Budín de pan','Budín casero con pasas','Postre'),
(11,'Empanadas','Empanadas de carne al horno','Entrada'),
(12,'Ñoquis con pesto','Ñoquis con salsa pesto','Principal');
/*!40000 ALTER TABLE `plato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `id_estudiante` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'pendiente',
  `id_forma_pago` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `fk_reserva_estudiante` (`id_estudiante`),
  KEY `fk_reserva_menu` (`id_menu`),
  KEY `fk_reserva_formapago` (`id_forma_pago`),
  CONSTRAINT `fk_reserva_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`),
  CONSTRAINT `fk_reserva_formapago` FOREIGN KEY (`id_forma_pago`) REFERENCES `forma_pago` (`id_forma_pago`),
  CONSTRAINT `fk_reserva_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva`
--

LOCK TABLES `reserva` WRITE;
/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` VALUES
(1,1,1,'2024-04-01','confirmada',1),
(2,2,1,'2024-04-01','confirmada',4),
(3,3,2,'2024-04-02','confirmada',2),
(4,4,2,'2024-04-02','pendiente',3),
(5,5,3,'2024-04-03','confirmada',1),
(6,6,3,'2024-04-03','cancelada',5),
(7,7,4,'2024-04-04','confirmada',4),
(8,8,4,'2024-04-04','confirmada',7),
(9,9,5,'2024-04-05','pendiente',1),
(10,10,5,'2024-04-05','confirmada',6),
(11,1,6,'2024-04-08','confirmada',1),
(12,2,7,'2024-04-09','pendiente',4);
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_comedor'
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
