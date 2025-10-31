-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: desafia_bd
-- ------------------------------------------------------
-- Server version	8.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `jogosworkshop`
--

DROP TABLE IF EXISTS `jogosworkshop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jogosworkshop` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_jogador` int NOT NULL,
  `id_gestor` int NOT NULL,
  `id_dificuldade` int NOT NULL,
  `aprovacao` int NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `id_tempo` int NOT NULL,
  `totalpontosjogo` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jogosworkshop_dificuldade1_idx` (`id_dificuldade`),
  KEY `fk_jogosworkshop_jogador1_idx` (`id_gestor`),
  KEY `fk_jogosworkshop_jogador2_idx` (`id_jogador`),
  KEY `fk_jogosworkshop_tempo1_idx` (`id_tempo`),
  CONSTRAINT `fk_jogosworkshop_dificuldade1` FOREIGN KEY (`id_dificuldade`) REFERENCES `dificuldade` (`id`),
  CONSTRAINT `fk_jogosworkshop_jogador1` FOREIGN KEY (`id_gestor`) REFERENCES `jogador` (`id`),
  CONSTRAINT `fk_jogosworkshop_jogador2` FOREIGN KEY (`id_jogador`) REFERENCES `jogador` (`id`),
  CONSTRAINT `fk_jogosworkshop_tempo1` FOREIGN KEY (`id_tempo`) REFERENCES `tempo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogosworkshop`
--

LOCK TABLES `jogosworkshop` WRITE;
/*!40000 ALTER TABLE `jogosworkshop` DISABLE KEYS */;
/*!40000 ALTER TABLE `jogosworkshop` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-31 10:23:56
