-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: fundaec
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accesorios`
--

DROP TABLE IF EXISTS `accesorios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accesorios` (
  `id_accesorio` int(11) NOT NULL AUTO_INCREMENT,
  `id_inventario` int(11) NOT NULL,
  `nombre_accesorio` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `estado` tinyint(4) NOT NULL COMMENT '1=Activo, 2=Dañado, 3=Baja',
  PRIMARY KEY (`id_accesorio`),
  KEY `fk_accesorios_inventario` (`id_inventario`),
  CONSTRAINT `fk_accesorios_inventario` FOREIGN KEY (`id_inventario`) REFERENCES `inventario` (`id_inventario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesorios`
--

/*!40000 ALTER TABLE `accesorios` DISABLE KEYS */;
INSERT INTO `accesorios` VALUES (1,1,'Cargador','Cargador original HP',1,1),(2,1,'Mouse','Mouse inalámbrico',1,1),(3,2,'Teclado','Teclado estándar USB',5,1),(4,3,'Cable de red','Cable UTP categoría 6',10,1),(5,5,'Soporte','Soporte metálico para cámara',8,1),(6,6,'Batería interna','Batería de reemplazo',3,2);
/*!40000 ALTER TABLE `accesorios` ENABLE KEYS */;

--
-- Table structure for table `categoria_equipo`
--

DROP TABLE IF EXISTS `categoria_equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria_equipo` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_equipo`
--

/*!40000 ALTER TABLE `categoria_equipo` DISABLE KEYS */;
INSERT INTO `categoria_equipo` VALUES (1,'Computadores','Equipos de cómputo de escritorio y portátiles'),(2,'Redes','Equipos de red y comunicaciones'),(3,'Periféricos','Dispositivos de entrada y salida'),(4,'Seguridad','Equipos de seguridad electrónica'),(5,'Energía','Equipos de respaldo y energía');
/*!40000 ALTER TABLE `categoria_equipo` ENABLE KEYS */;

--
-- Table structure for table `especificaciones`
--

DROP TABLE IF EXISTS `especificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `especificaciones` (
  `id_especificacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_inventario` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`id_especificacion`),
  KEY `fk_especificaciones_inventario` (`id_inventario`),
  CONSTRAINT `fk_especificaciones_inventario` FOREIGN KEY (`id_inventario`) REFERENCES `inventario` (`id_inventario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especificaciones`
--

/*!40000 ALTER TABLE `especificaciones` DISABLE KEYS */;
INSERT INTO `especificaciones` VALUES (1,1,'Procesador Intel Core i7 11th Gen'),(2,1,'RAM 16GB DDR4'),(3,1,'Disco SSD 512GB'),(4,2,'Procesador Intel Core i5'),(5,2,'RAM 8GB'),(6,3,'Soporte VLAN y QoS'),(7,3,'Administrable'),(8,4,'Firewall integrado'),(9,4,'VPN soportada'),(10,6,'Autonomía aproximada 45 minutos');
/*!40000 ALTER TABLE `especificaciones` ENABLE KEYS */;

--
-- Table structure for table `historial_inventario`
--

DROP TABLE IF EXISTS `historial_inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_inventario` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `id_inventario` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `accion` varchar(100) NOT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_historial`),
  KEY `fk_historial_inventario` (`id_inventario`),
  CONSTRAINT `fk_historial_inventario` FOREIGN KEY (`id_inventario`) REFERENCES `inventario` (`id_inventario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_inventario`
--

/*!40000 ALTER TABLE `historial_inventario` DISABLE KEYS */;
INSERT INTO `historial_inventario` VALUES (1,1,'2025-12-16 01:51:25','Registro','Equipo nuevo asignado a desarrollo'),(2,2,'2025-12-16 01:51:25','Asignación','Equipos asignados a personal administrativo'),(3,3,'2025-12-16 01:51:25','Instalación','Switch instalado en sala de sistemas'),(4,6,'2025-12-16 01:51:25','Mantenimiento','Cambio de baterías'),(5,5,'2025-12-16 01:51:25','Inspección','Revisión de cámaras de seguridad');
/*!40000 ALTER TABLE `historial_inventario` ENABLE KEYS */;

--
-- Table structure for table `inventario`
--

DROP TABLE IF EXISTS `inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_inventario` varchar(150) NOT NULL,
  `codigo_inventario` varchar(50) NOT NULL,
  `serial` varchar(100) DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `estado` tinyint(4) NOT NULL COMMENT '1=Activo, 2=Mantenimiento, 3=Baja',
  `fecha_incorporacion` date NOT NULL,
  `fecha_baja` date DEFAULT NULL,
  `valor_unitario` decimal(12,2) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_ubicacion` int(11) NOT NULL,
  PRIMARY KEY (`id_inventario`),
  UNIQUE KEY `codigo_inventario` (`codigo_inventario`),
  UNIQUE KEY `serial` (`serial`),
  KEY `idx_inventario_categoria` (`id_categoria`),
  KEY `idx_inventario_ubicacion` (`id_ubicacion`),
  KEY `idx_inventario_estado` (`estado`),
  CONSTRAINT `fk_inventario_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_equipo` (`id_categoria`),
  CONSTRAINT `fk_inventario_ubicacion` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicacion` (`id_ubicacion`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario`
--

/*!40000 ALTER TABLE `inventario` DISABLE KEYS */;
INSERT INTO `inventario` VALUES (1,'Laptop Desarrollo','INV-001','SN-HP-001','HP','ProBook 450',1,1,'2024-01-15',NULL,3500000.00,1,1),(2,'PC Administrativo','INV-002','SN-DELL-002','Dell','Optiplex 3080',5,1,'2023-11-10',NULL,2800000.00,1,1),(3,'Switch 24 Puertos','INV-003','SN-CISCO-003','Cisco','SG250',2,1,'2023-05-20',NULL,4200000.00,2,2),(4,'Router Principal','INV-004','SN-MK-004','MikroTik','RB4011',1,1,'2024-02-01',NULL,2100000.00,2,2),(5,'Cámara Seguridad','INV-005','SN-HIK-005','Hikvision','DS-2CD',8,1,'2023-09-12',NULL,650000.00,4,4),(6,'UPS Oficina','INV-006','SN-APC-006','APC','Back-UPS 1500',3,2,'2022-08-30',NULL,1800000.00,5,3);
/*!40000 ALTER TABLE `inventario` ENABLE KEYS */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(100) NOT NULL,
  `descripcion_rol` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1 COMMENT '1=activo, 0=inactivo',
  `fecha_registro_rol` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_rol`),
  KEY `idx_nombre` (`nombre_rol`),
  KEY `idx_activo` (`activo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Administrador del sistema',1,'2025-12-16 06:51:00'),(2,'usuario','Usuario del sistema',1,'2025-12-16 06:51:00'),(3,'secretaria','Secretaria',1,'2025-12-16 06:51:00');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

--
-- Table structure for table `ubicacion`
--

DROP TABLE IF EXISTS `ubicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ubicacion` (
  `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_ubicacion` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_ubicacion`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ubicacion`
--

/*!40000 ALTER TABLE `ubicacion` DISABLE KEYS */;
INSERT INTO `ubicacion` VALUES (1,'Oficina Principal','Sede administrativa central'),(2,'Sala de Sistemas','Área de servidores y redes'),(3,'Bodega','Almacenamiento de equipos'),(4,'Recepción','Área de atención al público'),(5,'Sucursal Norte','Oficina secundaria');
/*!40000 ALTER TABLE `ubicacion` ENABLE KEYS */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(100) NOT NULL,
  `apellido_usuario` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono_usuario` varchar(20) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1 COMMENT '1=activo, 0=inactivo',
  `id_rol` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultimo_acceso` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`),
  KEY `idx_activo` (`activo`),
  KEY `idx_id_rol` (`id_rol`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

--
-- Dumping routines for database 'fundaec'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-16  1:52:16
