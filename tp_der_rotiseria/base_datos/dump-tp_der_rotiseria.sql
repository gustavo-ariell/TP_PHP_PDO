/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_rotiseria
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
(1,'Pastas'),
(2,'Carnes'),
(3,'Ensaladas'),
(4,'Sopas'),
(5,'Pizzas'),
(6,'Empanadas'),
(7,'Postres'),
(8,'Bebidas'),
(9,'Tartas'),
(10,'Sandwiches');
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
  `direccion` varchar(200) DEFAULT NULL,
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
(1,'María','López','30123456','11-2222-1001','Av. Siempre Viva 123'),
(2,'Juan','García','30234567','11-2222-1002','Calle Falsa 456'),
(3,'Ana','Pérez','30345678','11-2222-1003','Belgrano 789'),
(4,'Pedro','Martínez','30456789','11-2222-1004','Mitre 1010'),
(5,'Lucía','Rodríguez','30567890','11-2222-1005','Rivadavia 2020'),
(6,'Carlos','Sánchez','30678901','11-2222-1006','San Martín 3030'),
(7,'Laura','Fernández','30789012','11-2222-1007','Sarmiento 4040'),
(8,'Diego','Gómez','30890123','11-2222-1008','Urquiza 5050'),
(9,'Sofía','Díaz','30901234','11-2222-1009','Alsina 6060'),
(10,'Miguel','Torres','31012345','11-2222-1010','Moreno 7070'),
(11,'Carmen','Ruiz','31123456','11-2222-1011','Lavalle 8080'),
(12,'Roberto','Herrera','31234567','11-2222-1012','Corrientes 9090');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_pedido`
--

DROP TABLE IF EXISTS `detalle_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `fk_detallepedido_pedido` (`id_pedido`),
  KEY `fk_detallepedido_producto` (`id_producto`),
  CONSTRAINT `fk_detallepedido_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  CONSTRAINT `fk_detallepedido_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_pedido`
--

LOCK TABLES `detalle_pedido` WRITE;
/*!40000 ALTER TABLE `detalle_pedido` DISABLE KEYS */;
INSERT INTO `detalle_pedido` VALUES
(1,1,1,2,3500.00,7000.00),
(2,1,8,1,1200.00,1200.00),
(3,2,2,1,4200.00,4200.00),
(4,3,5,1,3800.00,3800.00),
(5,3,6,1,3600.00,3600.00),
(6,4,3,2,2800.00,5600.00),
(7,5,11,1,3500.00,3500.00),
(8,6,2,1,4200.00,4200.00),
(9,6,7,2,1800.00,3600.00),
(10,8,9,3,2500.00,7500.00),
(11,10,1,1,3500.00,3500.00),
(12,10,12,1,2200.00,2200.00);
/*!40000 ALTER TABLE `detalle_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forma_entrega`
--

DROP TABLE IF EXISTS `forma_entrega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `forma_entrega` (
  `id_forma_entrega` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  PRIMARY KEY (`id_forma_entrega`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forma_entrega`
--

LOCK TABLES `forma_entrega` WRITE;
/*!40000 ALTER TABLE `forma_entrega` DISABLE KEYS */;
INSERT INTO `forma_entrega` VALUES
(1,'Retiro en local'),
(2,'Envío a domicilio');
/*!40000 ALTER TABLE `forma_entrega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'pendiente',
  `id_forma_entrega` int(11) NOT NULL,
  `direccion_entrega` varchar(200) DEFAULT NULL,
  `id_repartidor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `fk_pedido_cliente` (`id_cliente`),
  KEY `fk_pedido_formaentrega` (`id_forma_entrega`),
  KEY `fk_pedido_repartidor` (`id_repartidor`),
  CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `fk_pedido_formaentrega` FOREIGN KEY (`id_forma_entrega`) REFERENCES `forma_entrega` (`id_forma_entrega`),
  CONSTRAINT `fk_pedido_repartidor` FOREIGN KEY (`id_repartidor`) REFERENCES `repartidor` (`id_repartidor`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` VALUES
(1,1,'2024-05-01','12:30:00','entregado',2,'Av. Siempre Viva 123',1),
(2,2,'2024-05-01','13:00:00','entregado',1,NULL,NULL),
(3,3,'2024-05-02','20:00:00','entregado',2,'Belgrano 789',2),
(4,4,'2024-05-03','12:15:00','en camino',2,'Mitre 1010',3),
(5,5,'2024-05-03','13:30:00','en preparacion',1,NULL,NULL),
(6,6,'2024-05-04','20:30:00','pendiente',2,'San Martín 3030',4),
(7,7,'2024-05-04','21:00:00','pendiente',1,NULL,NULL),
(8,8,'2024-05-05','12:00:00','entregado',2,'Urquiza 5050',5),
(9,9,'2024-05-05','13:45:00','cancelado',1,NULL,NULL),
(10,10,'2024-05-06','20:00:00','pendiente',2,'Moreno 7070',6),
(11,11,'2024-05-07','12:30:00','pendiente',2,'Lavalle 8080',7),
(12,12,'2024-05-07','13:00:00','pendiente',1,'Catamarca 1950',6);
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
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
(1,'Ñoquis bolognesa','Ñoquis caseros con salsa bolognesa',3500.00,1),
(2,'Milanesa napolitana','Milanesa con jamón, queso y salsa',4200.00,2),
(3,'Ensalada Caesar','Lechuga, pollo, croutons y aderezo',2800.00,3),
(4,'Sopa de verduras','Caldo casero con verduras',2000.00,4),
(5,'Pizza muzzarella','Pizza grande de muzzarella',3800.00,5),
(6,'Empanadas x6','Docena media de carne cortada a cuchillo',3600.00,6),
(7,'Flan con dulce','Flan casero con dulce de leche y crema',1800.00,7),
(8,'Limonada 1L','Limonada natural con menta',1200.00,8),
(9,'Tarta de jamón y queso','Tarta casera individual',2500.00,9),
(10,'Sándwich de bondiola','Bondiola desmenuzada con coleslaw',3200.00,10),
(11,'Ravioles ricota','Ravioles de ricota con salsa rosa',3500.00,1),
(12,'Tiramisú','Postre italiano clásico',2200.00,7);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repartidor`
--

DROP TABLE IF EXISTS `repartidor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `repartidor` (
  `id_repartidor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_repartidor`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repartidor`
--

LOCK TABLES `repartidor` WRITE;
/*!40000 ALTER TABLE `repartidor` DISABLE KEYS */;
INSERT INTO `repartidor` VALUES
(1,'Pablo','Acosta','11-2222-2001'),
(2,'Lucas','Mendoza','11-2222-2002'),
(3,'Gonzalo','Ríos','11-2222-2003'),
(4,'Agustín','Campos','11-2222-2004'),
(5,'Facundo','Vega','11-2222-2005'),
(6,'Nicolás','Sosa','11-2222-2006'),
(7,'Matías','Blanco','11-2222-2007'),
(8,'Emiliano','Flores','11-2222-2008'),
(9,'Federico','Navarro','11-2222-2009'),
(10,'Ignacio','Morales','11-2222-2010');
/*!40000 ALTER TABLE `repartidor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_rotiseria'
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
