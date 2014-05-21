/*
SQLyog Ultimate v8.55 
MySQL - 5.1.50-community : Database - publishIT
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`publishIT` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `publishIT`;

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ci_sessions` */

insert  into `ci_sessions`(`session_id`,`ip_address`,`user_agent`,`last_activity`,`user_data`) values ('01aeefb4a87365142805717a8c4cfc60','127.0.0.1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.137 Safari/537.36',1400667065,'a:6:{s:9:\"user_data\";s:0:\"\";s:7:\"user_id\";i:1;s:4:\"name\";s:7:\"Andreas\";s:5:\"email\";s:18:\"dk-ads@outlook.com\";s:12:\"is_logged_in\";b:1;s:8:\"is_admin\";b:1;}');

/*Table structure for table `module` */

DROP TABLE IF EXISTS `module`;

CREATE TABLE `module` (
  `module_id` int(10) NOT NULL AUTO_INCREMENT,
  `page_id` int(10) DEFAULT NULL,
  `class_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(10) DEFAULT NULL,
  `settings` text COLLATE utf8_unicode_ci,
  `content_area` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `module` */

insert  into `module`(`module_id`,`page_id`,`class_name`,`sort_order`,`settings`,`content_area`) values (1,2,'login',1,NULL,'main_content'),(2,1,'search',1,NULL,'main_content'),(3,1,'publications',1,NULL,'left_content');

/*Table structure for table `page` */

DROP TABLE IF EXISTS `page`;

CREATE TABLE `page` (
  `page_id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_page_id` int(10) DEFAULT '1',
  `page_title` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `page_path` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `privileges` enum('1','2') COLLATE utf8_unicode_ci DEFAULT '1',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `page` */

insert  into `page`(`page_id`,`parent_page_id`,`page_title`,`page_path`,`template`,`privileges`) values (1,-1,'forside','/','publishit','2'),(2,-1,'login','/login','publishit','1');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
