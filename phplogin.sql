-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: localhost    Database: phplogin
-- ------------------------------------------------------
-- Server version	8.0.33-0ubuntu0.22.04.2

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
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8mb4_hungarian_ci NOT NULL,
  `body` text COLLATE utf8mb4_hungarian_ci NOT NULL,
  `author` text COLLATE utf8mb4_hungarian_ci NOT NULL,
  `created_at` text COLLATE utf8mb4_hungarian_ci NOT NULL,
  `edited` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (27,'szia borsószem','','bupa','2023-05-29 14:18:24',0),(28,'Kedves Naplóm!','A mai napon láttam egy kacsát. Megettem. Finom volt. :)\r\nÜdvözlettel: Cunk','hatizsak2','2023-05-29 14:19:17',0),(29,'Szia Pite kapitány','én jobban','hatizsak2','2023-05-29 14:20:13',0),(30,'','én sokkal jobban 😡😡😡','bupa','2023-05-29 14:22:17',0);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` text COLLATE utf8mb4_hungarian_ci NOT NULL,
  `password` text COLLATE utf8mb4_hungarian_ci NOT NULL,
  `permission` varchar(10) COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (29,'bupa','$2y$10$xBVhk80Hq.j8njW2i8VO4uXHioukfbX0Gkykem7j.A1zPReNK6ylO','admin'),(37,'user2','asd','user'),(39,'user12','$2y$10$E.jHdNDbM5fh9vMvcVfmduYHcGfZW6UjA3I1FiYxMqBBf7UIx/Ft6','user'),(42,'deleted','$2y$10$PCosSvHITRnrKjN.8zfm8uAzDdPba4AnOWEmva8hgKtoEOp1S0b/e','user'),(44,'checkdb','$2y$10$mrfIZ0HmpYZkKciynPa6veonS5jIJjrq1fUgvt0HB7.SMlZ3/0rKa','user'),(45,'tuncike','$2y$10$XHuOha7oVVBtkO5/Z9DcCunYNv4cFBnBSvlUL8t16l1M4VtnLEFEC','user'),(46,'hatizsak2','$2y$10$SAoDtqRqmjhf4hY9cWcVM.ARg3jjU.BWRxhyPw2vlng1fIWWjT3TO','user');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-29 14:38:56
