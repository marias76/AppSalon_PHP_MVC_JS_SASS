-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: appsalon_mvc
-- ------------------------------------------------------
-- Server version	8.4.3

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
-- Table structure for table `citas`
--

DROP TABLE IF EXISTS `citas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `usuarioId` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_citas_usuario` (`usuarioId`),
  CONSTRAINT `fk_citas_usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `citasservicios`
--

DROP TABLE IF EXISTS `citasservicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citasservicios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `citaId` int NOT NULL,
  `servicioId` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_citasservicios_cita` (`citaId`),
  KEY `fk_citasservicios_servicio` (`servicioId`),
  CONSTRAINT `fk_citasservicios_cita` FOREIGN KEY (`citaId`) REFERENCES `citas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_citasservicios_servicio` FOREIGN KEY (`servicioId`) REFERENCES `servicios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `precio` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `apellido` varchar(60) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `token` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'appsalon_mvc'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-02 21:07:58

-- inserción de datos en la tabla servicios
INSERT INTO servicios ( nombre, precio ) VALUES
        ('Corte de Cabello Niño', 60),
        ('Corte de Cabello Hombre', 80),
        ('Corte de Barba', 60),
        ('Peinado Mujer', 80),
        ('Peinado Hombre', 60),
        ('Tinte',300),
        ('Uñas', 400),
        ('Lavado de Cabello', 50),
        ('Tratamiento Capilar', 150);

-- inserción de datos en la tabla reservaciones
 INSERT INTO reservaciones (nombre, apellido, hora, fecha, servicios) VALUES
        ('Juan', 'De la torre', '10:30:00', '2021-06-28', 'Corte de Cabello Adulto, Corte de Barba' ),
        ('Antonio', 'Hernandez', '14:00:00', '2021-07-30', 'Corte de Cabello Niño'),
        ('Pedro', 'Juarez', '20:00:00', '2021-06-25', 'Corte de Cabello Adulto'),
        ('Mireya', 'Perez', '19:00:00', '2021-06-25', 'Peinado Mujer'),
        ('Jose', 'Castillo', '14:00:00', '2021-07-30', 'Peinado Hombre'),
        ('Maria', 'Diaz', '14:30:00', '2021-06-25', 'Tinte'),
        ('Clara', 'Duran', '10:00:00', '2021-07-01', 'Uñas, Tinte, Corte de Cabello Mujer'),
        ('Miriam', 'Ibañez', '09:00:00', '2021-07-01', 'Tinte'),
        ('Samuel', 'Reyes', '10:00:00', '2021-07-02', 'Tratamiento Capilar'),
        ('Joaquin', 'Muñoz', '19:00:00', '2021-06-28', 'Tratamiento Capilar'),
        ('Julia', 'Lopez', '08:00:00', '2021-06-25', 'Tinte'),
        ('Carmen', 'Ruiz', '20:00:00', '2021-07-01', 'Uñas'),
        ('Isaac', 'Sala', '09:00:00', '2021-07-30', 'Corte de Cabello Adulto'),
        ('Ana', 'Preciado', '14:30:00', '2021-06-28', 'Corte de Cabello Mujer'),
        ('Sergio', 'Iglesias', '10:00:00', '2021-07-02', 'Corte de Cabello Adulto'),
        ('Aina', 'Acosta', '14:00:00', '2021-07-30', 'Uñas'),
        ('Carlos', 'Ortiz', '20:00:00', '2021-06-25', 'Corte de Cabello Niño'),
        ('Roberto', 'Serrano', '10:00:00', '2021-07-30', 'Corte de Cabello Niño'),
        ('Carlota', 'Perez', '14:00:00', '2021-07-01', 'Uñas'),
        ('Ana Maria', 'Igleias', '14:00:00', '2021-07-02', 'Uñas, Tinte'),
        ('Jaime', 'Jimenez', '14:00:00', '2021-07-01', 'Corte de Cabello Niño'),
        ('Roberto', 'Torres', '10:00:00', '2021-07-02', 'Corte de Cabello Adulto'),
        ('Juan', 'Cano', '09:00:00', '2021-07-02', 'Corte de Cabello Niño'),
        ('Santiago', 'Hernandez', '19:00:00', '2021-06-28', 'Corte de Cabello Niño'),
        ('Berta', 'Gomez', '09:00:00', '2021-07-01', 'Uñas'),
        ('Miriam', 'Dominguez', '19:00:00', '2021-06-28', 'Corte de Cabello Niño'),
        ('Antonio', 'Castro', '14:30:00', '2021-07-02', 'Corte de Cabello Adulti'),
        ('Hugo', 'Alonso', '09:00:00', '2021-06-28', 'Corte de Barba'),
        ('Victoria', 'Perez', '10:00:00', '2021-07-02', 'Uñas, Tinte'),
        ('Jimena', 'Leon', '10:30:00', '2021-07-30', 'Uñas, Corte de Cabello Mujer'),
        ('Raquel' ,'Peña', '20:30:00', '2021-06-25', 'Corte de Cabello Mujer');
