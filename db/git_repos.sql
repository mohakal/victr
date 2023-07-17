/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 5.7.42-0ubuntu0.18.04.1 : Database - victr
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `git_repos` */

DROP TABLE IF EXISTS `git_repos`;

CREATE TABLE `git_repos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repo_id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `url` text,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_push_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text,
  `stars` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniquerepoid` (`repo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
ALTER TABLE `git_repos` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
