/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_inventario
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
(1,'Electrónica'),
(2,'Ferretería'),
(3,'Limpieza'),
(4,'Oficina'),
(5,'Alimentos'),
(6,'Bebidas'),
(7,'Ropa'),
(8,'Calzado'),
(9,'Hogar'),
(10,'Jardín');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimiento_stock`
--

DROP TABLE IF EXISTS `movimiento_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `movimiento_stock` (
  `id_movimiento` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `motivo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_movimiento`),
  KEY `fk_movimiento_producto` (`id_producto`),
  CONSTRAINT `fk_movimiento_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `chk_tipo_movimiento` CHECK (`tipo` in ('entrada','salida'))
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento_stock`
--

LOCK TABLES `movimiento_stock` WRITE;
/*!40000 ALTER TABLE `movimiento_stock` DISABLE KEYS */;
INSERT INTO `movimiento_stock` VALUES
(1,1,'entrada','2024-03-01',20,'Compra a proveedor'),
(2,2,'entrada','2024-03-02',15,'Pedido mensual'),
(3,3,'salida','2024-03-03',5,'Uso interno'),
(4,4,'entrada','2024-03-04',100,'Reposición de stock'),
(5,5,'salida','2024-03-05',20,'Venta a distribuidor'),
(6,6,'entrada','2024-03-06',50,'Compra mayorista'),
(7,7,'salida','2024-03-07',10,'Venta minorista'),
(8,8,'entrada','2024-03-08',10,'Pedido especial'),
(9,9,'salida','2024-03-09',3,'Devolución de cliente'),
(10,10,'entrada','2024-03-10',25,'Reposición trimestral'),
(11,11,'entrada','2024-03-11',5,'Stock bajo mínimo'),
(12,12,'salida','2024-03-12',2,'Venta corporativa');
/*!40000 ALTER TABLE `movimiento_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock_actual` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 0,
  `id_categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  UNIQUE KEY `codigo` (`codigo`),
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
(1,'ELEC-001','Monitor LED 24\"','Monitor Full HD 24 pulgadas',85000.00,15,5,1),
(2,'FERR-001','Taladro eléctrico','Taladro 500W con brocas',25000.00,20,5,2),
(3,'LIMP-001','Detergente 5L','Detergente multiuso concentrado',3500.00,50,10,3),
(4,'OFIC-001','Resma A4 500h','Resma papel blanco A4',3500.00,100,20,4),
(5,'ALIM-001','Aceite 1L','Aceite de girasol',2200.00,200,30,5),
(6,'BEB-001','Agua mineral 6x500ml','Pack de 6 botellas',1800.00,80,15,6),
(7,'ROPA-001','Remera algodón','Remera 100% algodón talle único',5500.00,60,10,7),
(8,'CALZ-001','Zapato de seguridad','Zapato con puntera acero',18000.00,25,5,8),
(9,'HOGR-001','Juego de sábanas','Sábanas 2 plazas 300 hilos',12000.00,30,8,9),
(10,'JARD-001','Fertilizante 2kg','Fertilizante universal',4500.00,40,10,10),
(11,'ELEC-002','Teclado USB','Teclado con teclado numérico',8500.00,3,10,1),
(12,'FERR-002','Caja de herramientas','Caja metálica con 120 piezas',35000.00,12,3,2);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_proveedor`
--

DROP TABLE IF EXISTS `producto_proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_proveedor` (
  `id_producto` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`,`id_proveedor`),
  KEY `fk_prodprov_proveedor` (`id_proveedor`),
  CONSTRAINT `fk_prodprov_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `fk_prodprov_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_proveedor`
--

LOCK TABLES `producto_proveedor` WRITE;
/*!40000 ALTER TABLE `producto_proveedor` DISABLE KEYS */;
INSERT INTO `producto_proveedor` VALUES
(1,1),
(1,11),
(2,2),
(3,3),
(4,4),
(5,5),
(6,6),
(7,7),
(8,8),
(9,9);
/*!40000 ALTER TABLE `producto_proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES
(1,'Electro Mayorista','Juan Pérez','11-1111-1001','ventas@electro.com','Av. Industrial 100'),
(2,'FerreSur','María López','11-1111-1002','info@ferresur.com','Av. San Martín 200'),
(3,'LimpieYa','Carlos Ruiz','11-1111-1003','pedidos@limpieya.com','Calle 30 Nro 300'),
(4,'Papelería Total','Ana García','11-1111-1004','ventas@ptotal.com','Av. Belgrano 400'),
(5,'Distribuidora Norte','Pedro Martín','11-1111-1005','dnorte@dist.com','Ruta 9 Km 50'),
(6,'Bebidas del Sur','Laura Sánchez','11-1111-1006','info@bebidassur.com','Av. Costanera 600'),
(7,'Textil Argentina','Jorge Torres','11-1111-1007','ventas@textil.com','Av. Corrientes 700'),
(8,'Calzado Industrial','Silvia Díaz','11-1111-1008','pedidos@calzado.com','Av. Rivadavia 800'),
(9,'HogarMax','Roberto Flores','11-1111-1009','ventas@hogarmax.com','Av. Libertador 900'),
(10,'VerdeJardín','Marta Ruiz','11-1111-1010','info@verdejardin.com','Calle Rural 1000'),
(11,'TecnoPlus','Diego Herrera','11-1111-1011','ventas@tecnoplus.com','Av. Córdoba 1100'),
(12,'MegaDistribuidor','Fernando Castro','11-1111-1012','info@megadist.com','Autopista Sur Km 20');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_inventario'
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
