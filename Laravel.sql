-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: laravel
-- ------------------------------------------------------
-- Server version	5.5.5-10.11.16-MariaDB

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_04_20_080710_create_posts_table',2),(5,'2026_04_20_085340_add_background_to_posts_table',3),(6,'2026_04_22_022618_add_views_to_posts_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `dateposted` date NOT NULL,
  `content` longtext NOT NULL,
  `background` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (12,'50 Amazing Adventures To Explore in Santorini','Europe','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<div class=\"main-textimg\">\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\n    turpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\n    adv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n    <br />\r\n    <br />\r\n    Vel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\n    varius ultrices.Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Quisque\r\n    velit nisi, pretium ut lacinia in, elementum id enim.Vivamus magna justo, lacinia eget\r\n    consectetur sed, convallis at tellus. Quisque velit nisi, pretium ut lacinia in, elementum id\r\n    enim.\r\n</p>\r\n<picture>\r\n    <img src=\"/uploads/1776742812/post1/images/santorini_gate.webp\" loading=\"lazy\" />\r\n</picture>\r\n</div>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776742812_imgcomponent1.webp','2026-04-20 20:40:12','2026-04-20 20:40:12',62688),(13,'5 tips for visiting Japan with kids on a budget','Asia','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\nturpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\nadv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n<br />\r\n<br />\r\nVel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\nvarius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\nUrna, bibendum aliquet mi et, proin etiam vulputate.\r\n<br />\r\n<br />\r\nCursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\nsuspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776745800_imgcomponent7.webp','2026-04-20 21:30:00','2026-04-20 21:30:00',53663),(14,'8 Benefits of Travel to a Happy Fulfilled Life','North America','Rabinsthame','2026-04-21','                <p class=\"main-text1\"><span>Bitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\n                        letius feugiat praesent vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus\n                        fames. Nulla a proin dapibus neque arcu nec eleifend. Viverra etiam elementum tellus vitae,\n                        quisque leo</span><b>Lectus nulla magnis aliquet ac. Quam sft risus adipiscing justo quis\n                        fringilla pellentesque. In bibendum in arcu at leo.</b>\n                </p>\n                <p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\n                    faucibus suspendisse. Est et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio\n                    pellentesque nibh. Id aliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit\n                    ultrices. Id id arcu erat maecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique\n                    tristique pretium odio nam. Eget in volutpat aliquam proin neque, amet neque ultrices. Quis lis\n                    lobortis ultricies elit consequat et lectus felis. Ainar mi cras urna sed sollicitudin orci\n                    facilisis enim, pellentesque.\n                </p>\n                <blockquote>\n                    <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\n                        malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\n                        malesuada velit nisi, pretium.</p>\n                </blockquote>\n                <div class=\"main-divtextimg\">\n                    <p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\n                        turpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\n                        adv consequat. In ultrices non purus vitae risus, sav dictum nunc.\n                        <br />\n                        <br />\n                        Vel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\n                        varius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\n                        Urna, bibendum aliquet mi et, proin etiam vulputate.\n                        <br />\n                        <br />\n                        Cursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\n                        suspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\n                    </p>\n                    <picture>\n                        <img src=\"/uploads/1776746832/post2/images/gallery_3.webp\" loading=\"lazy\" />\n                    </picture>\n                </div>\n                <p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\n                    faucibus suspendisse.\n                    Est et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\n                    aliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\n                    maecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\n                    Eget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\n                    consequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\n                    pellentesque.</p>','/uploads/backgrounds/1776746832_imgcomponent2.webp','2026-04-20 21:47:12','2026-04-20 21:47:12',80250),(15,'25 Lessons Learned from a Life of Travel','Asia','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<div class=\"main-divtextimg\">\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\n    turpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\n    adv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n    <br />\r\n    <br />\r\n    Vel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\n    varius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\n    Urna, bibendum aliquet mi et, proin etiam vulputate.\r\n    <br />\r\n    <br />\r\n    Cursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\n    suspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<picture>\r\n    <img src=\"/uploads/1776746872/post3/images/gallery_3.webp\" loading=\"lazy\" />\r\n</picture>\r\n</div>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776746872_imgcomponent3.webp','2026-04-20 21:47:52','2026-04-20 21:47:52',40260),(16,'How to Stay Safe Anywhere as a Solo Traveller','Antarctica','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<div class=\"main-divtextimg\">\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\n    turpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\n    adv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n    <br />\r\n    <br />\r\n    Vel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\n    varius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\n    Urna, bibendum aliquet mi et, proin etiam vulputate.\r\n    <br />\r\n    <br />\r\n    Cursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\n    suspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<picture>\r\n    <img src=\"/uploads/1776746926/post4/images/gallery_5.webp\" loading=\"lazy\" />\r\n</picture>\r\n</div>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776746926_imgcomponent4.webp','2026-04-20 21:48:46','2026-04-20 21:48:46',60552),(17,'Discover an Authentic Mexico City','South America','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<div class=\"main-divtextimg\">\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\n    turpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\n    adv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n    <br />\r\n    <br />\r\n    Vel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\n    varius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\n    Urna, bibendum aliquet mi et, proin etiam vulputate.\r\n    <br />\r\n    <br />\r\n    Cursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\n    suspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<picture>\r\n    <img src=\"/uploads/1776747006/post4 - Copy/images/gallery_3.webp\" loading=\"lazy\" />\r\n</picture>\r\n</div>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776747006_imgcomponent5.webp','2026-04-20 21:50:06','2026-04-20 21:50:06',81980),(18,'22 Unique Islands to Visit','Africa','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\nturpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\nadv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n<br />\r\n<br />\r\nVel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\nvarius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\nUrna, bibendum aliquet mi et, proin etiam vulputate.\r\n<br />\r\n<br />\r\nCursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\nsuspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776753402_imgcomponent6.webp','2026-04-20 23:36:42','2026-04-20 23:36:42',28245),(19,'Insiders Guide: What to Do in Medellin, Colombia','South America','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<div class=\"main-divtextimg\">\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\n    turpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\n    adv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n    <br />\r\n    <br />\r\n    Vel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\n    varius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\n    Urna, bibendum aliquet mi et, proin etiam vulputate.\r\n    <br />\r\n    <br />\r\n    Cursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\n    suspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<picture>\r\n    <img src=\"/uploads/1776753440/post4 - Copy (4)/images/gallery_2.webp\" loading=\"lazy\" />\r\n</picture>\r\n</div>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776753440_imgcomponent8.webp','2026-04-20 23:37:20','2026-04-20 23:37:20',95285),(20,'Places to see in Jasper Park','North America','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<div class=\"main-divtextimg\">\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\n    turpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\n    adv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n    <br />\r\n    <br />\r\n    Vel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\n    varius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\n    Urna, bibendum aliquet mi et, proin etiam vulputate.\r\n    <br />\r\n    <br />\r\n    Cursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\n    suspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<picture>\r\n    <img src=\"/uploads/1776753480/post4 - Copy (5)/images/gallery_1.webp\" loading=\"lazy\" />\r\n</picture>\r\n</div>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776753480_imgcomponent9.webp','2026-04-20 23:38:00','2026-04-20 23:38:00',91691),(21,'18 short walks in Australia to love','Australia','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<div class=\"main-divtextimg\">\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\n    turpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\n    adv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n    <br />\r\n    <br />\r\n    Vel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\n    varius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\n    Urna, bibendum aliquet mi et, proin etiam vulputate.\r\n    <br />\r\n    <br />\r\n    Cursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\n    suspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<picture>\r\n    <img src=\"/uploads/1776753586/post4 - Copy (6)/images/gallery_5.webp\" loading=\"lazy\" />\r\n</picture>\r\n</div>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776753586_imgcomponent10.webp','2026-04-20 23:39:46','2026-04-20 23:39:46',72599),(22,'45 things to know about Australia as Traveller','Australia','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<div class=\"main-divtextimg\">\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\n    turpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\n    adv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n    <br />\r\n    <br />\r\n    Vel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\n    varius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\n    Urna, bibendum aliquet mi et, proin etiam vulputate.\r\n    <br />\r\n    <br />\r\n    Cursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\n    suspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<picture>\r\n    <img src=\"/uploads/1776753630/post4 - Copy (7)/images/gallery_4.webp\" loading=\"lazy\" />\r\n</picture>\r\n</div>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776753630_imgcomponent11.webp','2026-04-20 23:40:30','2026-04-20 23:40:30',87922),(23,'33+ Essential Things to know Before Traveling to London','Europe','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\nturpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\nadv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n<br />\r\n<br />\r\nVel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\nvarius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\nUrna, bibendum aliquet mi et, proin etiam vulputate.\r\n<br />\r\n<br />\r\nCursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\nsuspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776753668_imgcomponent12.webp','2026-04-20 23:41:08','2026-04-20 23:41:08',21815),(24,'Top Outdoor Adventures: From Hikes to Summiting Peaks','Antarctica','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<div class=\"main-divtextimg\">\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\n    turpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\n    adv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n    <br />\r\n    <br />\r\n    Vel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\n    varius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\n    Urna, bibendum aliquet mi et, proin etiam vulputate.\r\n    <br />\r\n    <br />\r\n    Cursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\n    suspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<picture>\r\n    <img src=\"/uploads/1776753715/post4 - Copy (9)/images/gallery_3.webp\" loading=\"lazy\" />\r\n</picture>\r\n</div>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776753715_imgcomponent13.webp','2026-04-20 23:41:55','2026-04-21 19:34:54',45309),(25,'The 10 Best Places to Visit in Mauritius This Year loremm','Africa','Rabinsthame','2026-04-21','<p class=\"main-text1\"><span>Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer\r\n    letius feugiat\r\n    praesent\r\n    vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus fames. Nulla a proin\r\n    dapibus\r\n    neque arcu nec eleifend. Viverra etiam elementum tellus vitae, quisque leo.</span><b>Lectus\r\n    nulla magnis\r\n    aliquet ac. Quam sft risus adipiscing justo quis fringilla pellentesque. In bibendum in arcu at\r\n    leo.</b>\r\n</p>\r\n<p class=\"main-text2\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam eratsf eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas ddfbji gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis. Ainar mi cras urna sed sollicitudin orci facilisis enim, pellentesque.\r\n</p>\r\n<blockquote>\r\n<p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Donec sollicitudin mestie\r\n    malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim sollicitudin molestie\r\n    malesuada velit nisi, pretium.</p>\r\n</blockquote>\r\n<div class=\"main-divtextimg\">\r\n<p>Lorem ipsum dolor sit amet, consectetur sidjvgw adipiscing elit. Adipiscing ullamcorper senectus\r\n    turpis amet. Mauris semper id ut pulvinar massa facilisi. Faucibus faucibus diam fringilla non,\r\n    adv consequat. In ultrices non purus vitae risus, sav dictum nunc.\r\n    <br />\r\n    <br />\r\n    Vel nisl, elementum viverra sodales euismod btr convallis nullam porttitor. Ligula enim nisi\r\n    varius ultrices nunc aenean lorem eget. Feugiat orci sc risus sed consectetur sit purus aliquam.\r\n    Urna, bibendum aliquet mi et, proin etiam vulputate.\r\n    <br />\r\n    <br />\r\n    Cursus commodo eget faucibus tellus. Eget asdc netus nec magnis fermentum. Diam quam quam\r\n    suspendisse vitae consequat phasellus non odio morbi bibendum odio libero.\r\n</p>\r\n<picture>\r\n    <img src=\"/uploads/1776753748/post4 - Copy (10)/images/gallery_5.webp\" loading=\"lazy\" />\r\n</picture>\r\n</div>\r\n<p class=\"main-text3\">Amet, mauris habitant varius nunc ac cras in nulla. Nisl volutpat id libero,\r\nfaucibus suspendisse.\r\nEst et morbi duis a ut metus phasellus. Id purus a rhoncus habitant odio pellentesque nibh. Id\r\naliquam erat eros senectus sed semper eunc aliquet cursus consequat, sit ultrices. Id id arcu erat\r\nmaecenas sgca gravida massa facilisi. Turpis bibendum semper tristique tristique pretium odio nam.\r\nEget in volutpat aliquam proin neque, amet neque ultrices. Quis lis lobortis ultricies elit\r\nconsequat et lectus felis sdfgs. Pulvinar mi cras urna sed sollicitudin orci facilisis enim,\r\npellentesque.</p>','/uploads/backgrounds/1776753748_imgcomponent14.webp','2026-04-20 23:42:28','2026-04-22 02:00:56',61100);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('XGaB0s87P8IbYMjoR4VWpFPFErJz4HDPlTjvfWJt',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','eyJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2hvbWU/cGFnZT00Iiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sIl90b2tlbiI6Ik9WS0FSUU9TcE80eWFGSFRSbGdqb0NoOE1qejJKSkVWZTBBVHY0SE8iLCJ1c2VyIjoiYWRtaW4iLCJyb2xlIjoiYWRtaW4ifQ==',1776848750);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','admin@admin.admin',NULL,'$2y$12$JN5e4XA9XVmatBOHGD2DVens2ONwNtgnyhwNuJV6BVXIIothZrZ6e',NULL,'admin','2026-04-20 00:16:40','2026-04-22 01:33:31'),(2,'linhkk','linh','linh.ln.2584@aptechlearning.edu.vn',NULL,'$2y$12$mhJns5YxtRRHSH1txjxwL.2v07Bm3RQ.vCa27QqVI826tmzh1O1.u',NULL,'user','2026-04-20 01:39:19','2026-04-20 01:39:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-22 16:17:08
