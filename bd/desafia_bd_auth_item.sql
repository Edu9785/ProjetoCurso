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
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('accessBackOffice',2,'Acessar Backoffice',NULL,NULL,1763034868,1763034868),('admin',1,NULL,NULL,NULL,1763034868,1763034868),('buyPremium',2,'Comprar versão premium',NULL,NULL,1763034868,1763034868),('chooseCategory',2,'Escolher a categoria do quiz',NULL,NULL,1763034868,1763034868),('chooseDifficulty',2,'Escolher o nível de dificuldade do quiz',NULL,NULL,1763034868,1763034868),('createAdmin',2,'Criar administradores',NULL,NULL,1763034868,1763034868),('createCategory',2,'Criar categorias para quizzes',NULL,NULL,1763034868,1763034868),('createDefaultQuiz',2,'Criar quizzes default (sem internet)',NULL,NULL,1763034868,1763034868),('createDifficulty',2,'Criar dificuldades para quizzes',NULL,NULL,1763034868,1763034868),('createPremium',2,'Criar planos premium',NULL,NULL,1763034868,1763034868),('createQuiz',2,'Criar quizzes',NULL,NULL,1763034868,1763034868),('deleteAccount',2,'Eliminar a própria conta',NULL,NULL,1763034868,1763034868),('deleteAnyUser',2,'Eliminar qualquer utilizador',NULL,NULL,1763034868,1763034868),('deleteCategory',2,'Eliminar categorias de quizzes',NULL,NULL,1763034868,1763034868),('deleteDefaultQuiz',2,'Eliminar quizzes default (sem internet)',NULL,NULL,1763034868,1763034868),('deleteDifficulty',2,'Eliminar dificuldades para quizzes',NULL,NULL,1763034868,1763034868),('deletePremium',2,'Eliminar planos premium',NULL,NULL,1763034868,1763034868),('deleteQuiz',2,'Eliminar os próprios quizzes',NULL,NULL,1763034868,1763034868),('deleteUser',2,'Eliminar utilizadores',NULL,NULL,1763034868,1763034868),('demoteManager',2,'Despromover gestores a utilizadores',NULL,NULL,1763034868,1763034868),('editAccount',2,'Editar os dados da conta',NULL,NULL,1763034868,1763034868),('editAnyUser',2,'Editar qualquer utilizador',NULL,NULL,1763034868,1763034868),('editCategory',2,'Editar categorias de quizzes',NULL,NULL,1763034868,1763034868),('editDefaultQuiz',2,'Editar quizzes default (sem internet)',NULL,NULL,1763034868,1763034868),('editDifficulty',2,'Editar dificuldades para quizzes',NULL,NULL,1763034868,1763034868),('editPremium',2,'Editar planos premium',NULL,NULL,1763034868,1763034868),('editQuiz',2,'Editar os próprios quizzes',NULL,NULL,1763034868,1763034868),('editUser',2,'Editar utilizadores',NULL,NULL,1763034868,1763034868),('manager',1,NULL,NULL,NULL,1763034868,1763034868),('playDefaultQuiz',2,'Jogar quizzes default',NULL,NULL,1763034868,1763034868),('playUserQuiz',2,'Jogar quizzes criados por utilizadores',NULL,NULL,1763034868,1763034868),('promoteUser',2,'Promover utilizadores a gestores',NULL,NULL,1763034868,1763034868),('recoverPassword',2,'Recuperar palavra-passe',NULL,NULL,1763034868,1763034868),('rejectQuiz',2,'Recusar quizzes criados por utilizadores',NULL,NULL,1763034868,1763034868),('searchQuiz',2,'Pesquisar quizzes por nome',NULL,NULL,1763034868,1763034868),('user',1,NULL,NULL,NULL,1763034868,1763034868),('validateQuiz',2,'Validar quizzes criados por utilizadores',NULL,NULL,1763034868,1763034868);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-15 17:37:23
