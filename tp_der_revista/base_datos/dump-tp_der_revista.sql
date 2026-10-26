/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tp_der_revista
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
-- Table structure for table `articulo`
--

DROP TABLE IF EXISTS `articulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `articulo` (
  `id_articulo` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(300) NOT NULL,
  `resumen` text DEFAULT NULL,
  `palabras_clave` varchar(300) DEFAULT NULL,
  `fecha_envio` date NOT NULL,
  `archivo_principal` varchar(255) DEFAULT NULL,
  `id_seccion` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_articulo`),
  KEY `fk_articulo_seccion` (`id_seccion`),
  KEY `fk_articulo_estado` (`id_estado`),
  CONSTRAINT `fk_articulo_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado_articulo` (`id_estado`),
  CONSTRAINT `fk_articulo_seccion` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulo`
--

LOCK TABLES `articulo` WRITE;
/*!40000 ALTER TABLE `articulo` DISABLE KEYS */;
INSERT INTO `articulo` VALUES
(1,'Redes neuronales aplicadas','Análisis de redes neuronales','IA, redes, deep learning','2024-01-15','paper01.pdf',3,3),
(2,'Biodiversidad en humedales','Estudio de fauna acuática','ecología, humedales, fauna','2024-01-20','paper02.pdf',2,2),
(3,'Impacto del cambio climático','Efectos en la Patagonia','clima, Patagonia, impacto','2024-02-01','paper03.pdf',10,3),
(4,'Filosofía de la tecnología','Reflexión ética sobre IA','ética, tecnología, filosofía','2024-02-10','paper04.pdf',5,2),
(5,'Educación virtual post-pandemia','Análisis de resultados','educación, virtual, pandemia','2024-02-20','paper05.pdf',6,5),
(6,'Algoritmos de ordenamiento','Comparativa de eficiencia','algoritmos, complejidad, sorting','2024-03-01','paper06.pdf',1,1),
(7,'Derecho digital','Marco legal de la era digital','derecho, digital, privacidad','2024-03-10','paper07.pdf',8,2),
(8,'Machine learning en salud','Diagnóstico asistido por IA','ML, salud, diagnóstico','2024-03-15','paper08.pdf',7,3),
(9,'Arte generativo','Creación artística con algoritmos','arte, algoritmos, generativo','2024-03-20','paper09.pdf',9,1),
(10,'Economía circular','Modelos de sustentabilidad','economía, circular, reciclaje','2024-04-01','paper10.pdf',4,2);
/*!40000 ALTER TABLE `articulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulo_autor`
--

DROP TABLE IF EXISTS `articulo_autor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `articulo_autor` (
  `id_articulo` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  PRIMARY KEY (`id_articulo`,`id_autor`),
  KEY `fk_artautor_autor` (`id_autor`),
  CONSTRAINT `fk_artautor_articulo` FOREIGN KEY (`id_articulo`) REFERENCES `articulo` (`id_articulo`),
  CONSTRAINT `fk_artautor_autor` FOREIGN KEY (`id_autor`) REFERENCES `autor` (`id_autor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulo_autor`
--

LOCK TABLES `articulo_autor` WRITE;
/*!40000 ALTER TABLE `articulo_autor` DISABLE KEYS */;
INSERT INTO `articulo_autor` VALUES
(1,1),
(1,3),
(2,6),
(2,9),
(3,10),
(4,5),
(5,4),
(6,3),
(7,4),
(8,1),
(8,6),
(9,7);
/*!40000 ALTER TABLE `articulo_autor` ENABLE KEYS */;
UNLOCK TABLES;

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
  `email` varchar(150) DEFAULT NULL,
  `institucion` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_autor`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autor`
--

LOCK TABLES `autor` WRITE;
/*!40000 ALTER TABLE `autor` DISABLE KEYS */;
INSERT INTO `autor` VALUES
(1,'Dr. Roberto','García','rgarcia@uni.edu.ar','Universidad Nacional'),
(2,'Dra. Laura','Fernández','lfernandez@uni.edu.ar','Universidad Tecnológica'),
(3,'Ing. Carlos','López','clopez@uni.edu.ar','Instituto Tecnológico'),
(4,'Dra. Ana','Martínez','amartinez@uni.edu.ar','Universidad Nacional'),
(5,'Dr. Jorge','Pérez','jperez@uni.edu.ar','Universidad Privada'),
(6,'Lic. Silvia','Rodríguez','srodriguez@uni.edu.ar','CONICET'),
(7,'Dr. Miguel','Sánchez','msanchez@uni.edu.ar','Universidad Tecnológica'),
(8,'Dra. Patricia','Díaz','pdiaz@uni.edu.ar','Universidad Nacional'),
(9,'Dr. Fernando','Ruiz','fruiz@uni.edu.ar','CONICET'),
(10,'Ing. Marcela','Herrera','mherrera@uni.edu.ar','Instituto Tecnológico');
/*!40000 ALTER TABLE `autor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_articulo`
--

DROP TABLE IF EXISTS `estado_articulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_articulo` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_articulo`
--

LOCK TABLES `estado_articulo` WRITE;
/*!40000 ALTER TABLE `estado_articulo` DISABLE KEYS */;
INSERT INTO `estado_articulo` VALUES
(1,'Enviado'),
(2,'En revisión'),
(3,'Aceptado'),
(4,'Rechazado'),
(5,'Publicado'),
(6,'Correcciones solicitadas'),
(7,'Reenviado'),
(8,'En evaluación'),
(9,'Aceptado con cambios'),
(10,'Archivado');
/*!40000 ALTER TABLE `estado_articulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluacion`
--

DROP TABLE IF EXISTS `evaluacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluacion` (
  `id_evaluacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_articulo` int(11) NOT NULL,
  `id_evaluador` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `dictamen` varchar(50) NOT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id_evaluacion`),
  KEY `fk_evaluacion_articulo` (`id_articulo`),
  KEY `fk_evaluacion_evaluador` (`id_evaluador`),
  CONSTRAINT `fk_evaluacion_articulo` FOREIGN KEY (`id_articulo`) REFERENCES `articulo` (`id_articulo`),
  CONSTRAINT `fk_evaluacion_evaluador` FOREIGN KEY (`id_evaluador`) REFERENCES `evaluador` (`id_evaluador`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluacion`
--

LOCK TABLES `evaluacion` WRITE;
/*!40000 ALTER TABLE `evaluacion` DISABLE KEYS */;
INSERT INTO `evaluacion` VALUES
(1,1,1,'2024-02-01','aprobado','Excelente trabajo, aprobado sin cambios'),
(2,1,11,'2024-02-03','aprobado','Muy buen nivel de investigación'),
(3,2,2,'2024-02-15','correcciones','Revisar metodología de muestreo'),
(4,2,10,'2024-02-18','correcciones','Ampliar marco teórico'),
(5,3,10,'2024-02-20','aprobado','Trabajo sólido y bien documentado'),
(6,4,5,'2024-03-01','correcciones','Profundizar análisis ético'),
(7,5,6,'2024-03-05','aprobado','Resultados convincentes'),
(8,7,8,'2024-03-25','correcciones','Actualizar marco legal vigente'),
(9,8,1,'2024-04-01','aprobado','Innovador y relevante'),
(10,8,7,'2024-04-03','aprobado','Aplicación clínica prometedora');
/*!40000 ALTER TABLE `evaluacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluador`
--

DROP TABLE IF EXISTS `evaluador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluador` (
  `id_evaluador` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `especialidad` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_evaluador`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluador`
--

LOCK TABLES `evaluador` WRITE;
/*!40000 ALTER TABLE `evaluador` DISABLE KEYS */;
INSERT INTO `evaluador` VALUES
(1,'Dr. Oscar','Contreras','ocontreras@uni.edu.ar','Inteligencia Artificial'),
(2,'Dra. Beatriz','Salazar','bsalazar@uni.edu.ar','Bioquímica'),
(3,'Dr. Luis','Acosta','lacosta@uni.edu.ar','Matemática Pura'),
(4,'Dra. Carmen','Ramos','cramos@uni.edu.ar','Sociología'),
(5,'Dr. Ricardo','Mendoza','rmendoza@uni.edu.ar','Filosofía'),
(6,'Dra. Adriana','Peña','apena@uni.edu.ar','Pedagogía'),
(7,'Dr. Hugo','Guerrero','hguerrero@uni.edu.ar','Medicina'),
(8,'Dra. Julia','Vargas','jvargas@uni.edu.ar','Derecho Penal'),
(9,'Dr. Martín','Reyes','mreyes@uni.edu.ar','Artes Visuales'),
(10,'Dra. Rosa','Cruz','rcruz@uni.edu.ar','Ecología'),
(11,'Dr. Pablo','Morales','pmorales@uni.edu.ar','Ingeniería de Software'),
(12,'Dra. Isabel','Torres','itorres@uni.edu.ar','Historia');
/*!40000 ALTER TABLE `evaluador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seccion`
--

DROP TABLE IF EXISTS `seccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `seccion` (
  `id_seccion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id_seccion`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seccion`
--

LOCK TABLES `seccion` WRITE;
/*!40000 ALTER TABLE `seccion` DISABLE KEYS */;
INSERT INTO `seccion` VALUES
(1,'Ciencias Exactas','Matemática, física, química'),
(2,'Ciencias Naturales','Biología, geología, ecología'),
(3,'Tecnología','Informática, ingeniería, electrónica'),
(4,'Ciencias Sociales','Sociología, política, economía'),
(5,'Humanidades','Filosofía, historia, literatura'),
(6,'Educación','Pedagogía, didáctica, psicología educativa'),
(7,'Salud','Medicina, enfermería, nutrición'),
(8,'Derecho','Derecho penal, civil, comercial'),
(9,'Arte y Cultura','Artes visuales, música, cine'),
(10,'Medio Ambiente','Sustentabilidad, cambio climático');
/*!40000 ALTER TABLE `seccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tp_der_revista'
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
