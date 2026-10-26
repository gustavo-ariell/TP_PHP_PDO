/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_ventas
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
(1,'Libros'),
(2,'Cuadernos'),
(3,'Útiles Escolares'),
(4,'Artísticos'),
(5,'Papelería'),
(6,'Mochilas'),
(7,'Regalos'),
(8,'Tecnología'),
(9,'Juegos Educativos'),
(10,'Revistas');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

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
  `email` varchar(150) DEFAULT NULL,
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
(1,'Laura','García','30123456','11-4444-1001','lgarcia@mail.com'),
(2,'Roberto','Fernández','30234567','11-4444-1002','rfernandez@mail.com'),
(3,'Marcela','López','30345678','11-4444-1003','mlopez@mail.com'),
(4,'Carlos','Ruiz','30456789','11-4444-1004','cruiz@mail.com'),
(5,'Ana','Morales','30567890','11-4444-1005','amorales@mail.com'),
(6,'Diego','Silva','30678901','11-4444-1006','dsilva@mail.com'),
(7,'Patricia','Herrera','30789012','11-4444-1007','pherrera@mail.com'),
(8,'Fernando','Castro','30890123','11-4444-1008','fcastro@mail.com'),
(9,'Silvia','Ortiz','30901234','11-4444-1009','sortiz@mail.com'),
(10,'Hugo','Medina','31012345','11-4444-1010','hmedina@mail.com'),
(11,'Andrea','Vega','31123456','11-4444-1011','avega@mail.com'),
(12,'Raúl','Aguirre','31234567','11-4444-1012','raguirre@mail.com');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_venta`
--

DROP TABLE IF EXISTS `detalle_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_venta` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `fk_detalle_venta` (`id_venta`),
  KEY `fk_detalle_producto` (`id_producto`),
  CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `fk_detalle_venta` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_venta`
--

LOCK TABLES `detalle_venta` WRITE;
/*!40000 ALTER TABLE `detalle_venta` DISABLE KEYS */;
INSERT INTO `detalle_venta` VALUES
(1,1,1,1,5500.00,5500.00),
(2,1,3,2,350.00,700.00),
(3,1,9,1,500.00,500.00),
(4,2,1,1,5500.00,5500.00),
(5,3,6,1,28000.00,28000.00),
(6,3,2,2,1800.00,3600.00),
(7,4,5,1,3500.00,3500.00),
(8,5,7,1,12000.00,12000.00),
(9,6,8,1,4800.00,4800.00),
(10,10,10,1,9500.00,9500.00);
/*!40000 ALTER TABLE `detalle_venta` ENABLE KEYS */;
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
(4,'Transferencia Bancaria'),
(5,'Mercado Pago'),
(6,'Cheque'),
(7,'Cuotas sin interés'),
(8,'Billetera Virtual'),
(9,'Tarjeta Naranja'),
(10,'Cuenta DNI');
/*!40000 ALTER TABLE `forma_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `id_categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `fk_producto_categoria` (`id_categoria`),
  CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES
(1,'El Aleph - Borges','Novela clásica argentina',5500.00,20,1),
(2,'Cuaderno Rivadavia tapa dura','Cuaderno 100 hojas cuadriculado',1800.00,100,2),
(3,'Lápiz Faber Castell HB','Lápiz de grafito',350.00,200,3),
(4,'Set acuarelas 12 colores','Acuarelas marca Faber',4200.00,30,4),
(5,'Resma papel A4','Resma de 500 hojas',3500.00,50,5),
(6,'Mochila Nike','Mochila escolar con laptop',28000.00,15,6),
(7,'Calculadora científica','Casio FX-82',12000.00,25,8),
(8,'Rayuela - Cortázar','Novela literaria',4800.00,18,1),
(9,'Lapicera Pilot azul','Tinta gel punta fina',500.00,150,3),
(10,'Globo terráqueo','Globo decorativo e instructivo',9500.00,10,9),
(11,'Revista Gente','Semanario de actualidad',2200.00,40,10),
(12,'Tijera escolar','Tijera punta roma 18cm',800.00,80,3);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendedor`
--

DROP TABLE IF EXISTS `vendedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendedor` (
  `id_vendedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_vendedor`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendedor`
--

LOCK TABLES `vendedor` WRITE;
/*!40000 ALTER TABLE `vendedor` DISABLE KEYS */;
INSERT INTO `vendedor` VALUES
(1,'Pablo','Martín','35123456','11-3333-1001'),
(2,'Luciana','Pereyra','35234567','11-3333-1002'),
(3,'Gustavo','Acosta','35345678','11-3333-1003'),
(4,'Mariana','Blanco','35456789','11-3333-1004'),
(5,'Federico','Sosa','35567890','11-3333-1005'),
(6,'Carolina','Navarro','35678901','11-3333-1006'),
(7,'Maximiliano','Ríos','35789012','11-3333-1007'),
(8,'Natalia','Flores','35890123','11-3333-1008'),
(9,'Emiliano','Campos','35901234','11-3333-1009'),
(10,'Valeria','Domínguez','36012345','11-3333-1010');
/*!40000 ALTER TABLE `vendedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `id_forma_pago` int(11) NOT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `fk_venta_cliente` (`id_cliente`),
  KEY `fk_venta_vendedor` (`id_vendedor`),
  KEY `fk_venta_formapago` (`id_forma_pago`),
  CONSTRAINT `fk_venta_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `fk_venta_formapago` FOREIGN KEY (`id_forma_pago`) REFERENCES `forma_pago` (`id_forma_pago`),
  CONSTRAINT `fk_venta_vendedor` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id_vendedor`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
INSERT INTO `venta` VALUES
(1,'2024-03-01',1,1,1,7650.00),
(2,'2024-03-02',2,2,2,5500.00),
(3,'2024-03-03',3,3,3,18350.00),
(4,'2024-03-04',4,1,5,3500.00),
(5,'2024-03-05',5,4,1,12500.00),
(6,'2024-03-06',6,5,2,4800.00),
(7,'2024-03-07',7,6,3,28000.00),
(8,'2024-03-08',8,7,4,6150.00),
(9,'2024-03-09',9,8,5,3850.00),
(10,'2024-03-10',10,9,1,9500.00),
(11,'2024-03-11',11,10,2,2700.00),
(12,'2024-03-12',12,1,3,800.00);
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_ventas'
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
