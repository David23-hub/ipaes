/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.24-MariaDB : Database - laravel
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`laravel` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `laravel`;

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `po_id` varchar(50) DEFAULT NULL,
  `doctor_id` int DEFAULT NULL,
  `item_category` varchar(20) DEFAULT NULL,
  `cart` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `management_order` tinyint DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `packing_at` timestamp NULL DEFAULT NULL,
  `packing_by` varchar(50) DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `sent_by` varchar(50) DEFAULT NULL,
  `expedition_id` int DEFAULT NULL,
  `shipping_cost` int DEFAULT NULL,
  `recepient_number` varchar(100) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `paid_by` varchar(50) DEFAULT NULL,
  `paid_bank_name` varchar(100) DEFAULT NULL,
  `paid_account_bank_name` varchar(100) DEFAULT NULL,
  `cancel_at` timestamp NULL DEFAULT NULL,
  `cancel_by` varchar(50) DEFAULT NULL,
  `cancel_reason` varchar(100) DEFAULT NULL,
  `nominal` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `cart` */

insert  into `cart`(`id`,`po_id`,`doctor_id`,`item_category`,`cart`,`notes`,`management_order`,`due_date`,`created_by`,`created_at`,`updated_by`,`updated_at`,`deleted_by`,`deleted_at`) values 
(11,'asd',3,NULL,'1|product|100|20',NULL,0,'2024-03-04 14:42:41','david@gmail.com','2024-02-26 14:39:17','david@gmail.com','2024-02-26 14:42:41',NULL,NULL);

/*Table structure for table `category_product` */

DROP TABLE IF EXISTS `category_product`;

CREATE TABLE `category_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `category_product` */

insert  into `category_product`(`id`,`name`,`status`,`created_by`,`created_at`,`updated_by`,`updated_at`,`deleted_by`,`deleted_at`) values 
(1,'paket',1,'david@gmail.com','2024-02-20 14:30:52','david@gmail.com','2024-02-20 14:35:36',NULL,NULL),
(2,'product',1,'david@gmail.com','2024-02-20 14:30:57',NULL,NULL,NULL,NULL),
(5,'sad',1,'david@gmail.com','2024-02-26 15:05:06','david@gmail.com','2024-02-26 15:05:21',NULL,NULL),
(6,'123',0,'david@gmail.com','2024-02-26 15:05:14',NULL,NULL,NULL,NULL);

/*Table structure for table `dokter` */

DROP TABLE IF EXISTS `dokter`;

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `clinic` varchar(255) DEFAULT NULL,
  `information` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `billing_no_hp` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `dokter` */

insert  into `dokter`(`id`,`name`,`address`,`clinic`,`information`,`dob`,`no_hp`,`billing_no_hp`,`status`,`created_by`,`created_at`,`updated_by`,`updated_at`,`deleted_by`,`deleted_at`) values 
(1,'david1','add1','cl1','ini info1','dob1','12341','3211',1,'david@gmail.com','2024-02-20 08:29:00','david@gmail.com','2024-02-20 08:34:16','david@gmail.com','2024-02-20 14:17:05'),
(2,'asd','sad','123','sdsa','da','123','321',0,'davidb','2024-02-20 14:16:58',NULL,NULL,NULL,'2024-02-20 14:17:07'),
(3,'dr dabun','tandur','klinik sehat pelita','DOKTER TAMPAN DAN PEMBERANI','23 aug 2000','081270861076','0812389123',1,'davidb','2024-02-20 14:18:08',NULL,NULL,NULL,NULL),
(4,'11','11','11','11','2024-02-23','11','11',1,'davidb','2024-02-22 12:18:07','david@gmail.com','2024-02-22 12:18:38',NULL,NULL),
(5,'2','2','2','2','2024-03-01','2','2',0,'davidb','2024-02-26 15:03:25','david@gmail.com','2024-02-26 15:03:30',NULL,NULL),
(6,'3','23','23','2','2024-03-01','23','2',0,'davidb','2024-02-26 15:03:38',NULL,NULL,NULL,NULL);

/*Table structure for table `ekspedisi` */

DROP TABLE IF EXISTS `ekspedisi`;

CREATE TABLE `ekspedisi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ekspedisi` */

insert  into `ekspedisi`(`id`,`name`,`status`,`created_by`,`created_at`,`updated_by`,`updated_at`,`deleted_by`,`deleted_at`) values 
(1,'da',0,NULL,NULL,NULL,NULL,'david@gmail.com','2024-02-20 04:12:44'),
(2,'sad',1,NULL,NULL,NULL,NULL,'david@gmail.com','2024-02-20 07:54:38'),
(3,NULL,0,'david@gmail.com','2024-02-20 04:10:29',NULL,NULL,'david@gmail.com','2024-02-20 04:11:18'),
(4,'wwwqe',0,'david@gmail.com','2024-02-20 04:11:15',NULL,NULL,'david@gmail.com','2024-02-20 07:54:39'),
(5,'123',1,'david@gmail.com','2024-02-20 04:11:25',NULL,NULL,'david@gmail.com','2024-02-20 07:54:41'),
(6,NULL,0,'david@gmail.com','2024-02-20 04:13:16',NULL,NULL,'david@gmail.com','2024-02-20 07:54:42'),
(7,'JNE',1,'david@gmail.com','2024-02-20 07:54:50','david@gmail.com','2024-02-20 07:55:17',NULL,NULL),
(8,'Product',0,'david@gmail.com','2024-02-20 10:19:19',NULL,NULL,NULL,NULL),
(9,'david',0,'david@gmail.com','2024-02-20 10:20:04',NULL,NULL,NULL,NULL),
(10,'dsadsa',1,'david@gmail.com','2024-02-26 14:58:13','david@gmail.com','2024-02-26 14:58:18',NULL,NULL),
(11,'asdasd',1,'david@gmail.com','2024-02-26 14:58:23','david@gmail.com','2024-02-26 15:01:28',NULL,NULL);

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `flights_user` */

DROP TABLE IF EXISTS `flights_user`;

CREATE TABLE `flights_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `flights_user` */

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT 0,
  `unit` varchar(10) DEFAULT NULL,
  `category_product` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `presentation` float DEFAULT NULL,
  `mini_desc` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `commision_rate` float DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `img` varchar(255) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

/*Data for the table `items` */

insert  into `items`(`id`,`name`,`qty`,`unit`,`category_product`,`price`,`presentation`,`mini_desc`,`desc`,`commision_rate`,`status`,`img`,`created_by`,`created_at`,`updated_by`,`updated_at`,`deleted_by`,`deleted_at`) values 
(1,'dabun product1',1001,'Vial',1,10000,2.51,'min desc1','WOW DESC1',31,1,'1708612185.png','david@gmail.com','2024-02-20 14:50:26','david@gmail.com','2024-02-25 15:23:13',NULL,NULL),
(12,'1',1,'Box',1,1,1,'1','1',1,0,'1708488119.png','david@gmail.com','2024-02-21 04:01:59',NULL,NULL,'david@gmail.com','2024-02-22 12:10:15'),
(13,'1',1,'Box',1,1,1,'1','1',1,1,'1708612194.jpeg','david@gmail.com','2024-02-22 11:57:29','david@gmail.com','2024-02-22 14:29:54',NULL,NULL),
(14,'2',2,'Box',1,2,2,'2','2',2,1,'1708613021.png','david@gmail.com','2024-02-22 14:43:41',NULL,NULL,NULL,NULL),
(15,'3',3,'Box',1,3,3,'3','23',3,1,'1708613054.jpeg','david@gmail.com','2024-02-22 14:44:14',NULL,NULL,NULL,NULL),
(16,'1123',1,'Box',1,1,1,'1','1123',1,1,'','david@gmail.com','2024-02-22 15:53:33','david@gmail.com','2024-02-22 16:19:01',NULL,NULL),
(17,'4',4,'Box',1,4,4,'4','4',4,0,'','david@gmail.com','2024-02-22 16:05:03',NULL,NULL,NULL,NULL),
(18,'112312321321',312,'Box',1,1132312132,1132210000,'a','sad',213,1,'','david@gmail.com','2024-02-26 14:53:11','david@gmail.com','2024-02-26 14:56:39',NULL,NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2023_05_15_085852_create_flights_user',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `purchase_order` */

DROP TABLE IF EXISTS `purchase_order`;

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_number` varchar(20) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `purchase_order` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`role`,`remember_token`,`created_at`,`updated_at`) values 
(2,'davidb','david@gmail.com',NULL,'$2y$10$6BHRI7wl9BgKMBy8c4NAxOCG6yrEE6.jdN5bkcfYiuMeVdqCucQU2','admin','NLPLxz7Pcq17Sq3JpHTGPPqo7KVwvcUCU3hpq3FqYXtTcbWBOOBwo9IRwyAd','2023-05-16 07:24:55','2023-05-16 07:24:55'),
(3,'davidb','davidb@gmail.com',NULL,'$2y$10$8lJaT2cD8CiM6w4qvo8TceRh.pzv19TLHfgBWgz1seqXZpIT3IpN2',NULL,NULL,'2024-02-09 15:57:12','2024-02-09 15:57:12');

-- laravel.package definition

CREATE TABLE `package` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `category_product` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `commision_rate` float DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `img` blob,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

CREATE TABLE `extra_charge` (
  `transaction_id` int DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `price` int DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `dokter_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `extra_charge_id_IDX` (`id`) USING BTREE,
  KEY `extra_charge_FK` (`transaction_id`),
  CONSTRAINT `extra_charge_FK` FOREIGN KEY (`transaction_id`) REFERENCES `cart` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

