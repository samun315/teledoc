/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.22-MariaDB : Database - abs_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`abs_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `root_project_db`;

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

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

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `menu_items` */

DROP TABLE IF EXISTS `menu_items`;

CREATE TABLE `menu_items` (
  `menu_item_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `module_id` bigint(20) unsigned NOT NULL,
  `module_item_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `type` enum('divider','menu_item') COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'YES',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`menu_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menu_items` */

insert  into `menu_items`(`menu_item_id`,`menu_id`,`module_id`,`module_item_id`,`parent_id`,`type`,`menu_item_name`,`url`,`icon_class`,`order`,`target`,`active`,`created_by`,`updated_by`,`created_at`,`updated_at`) values 
(45,2,2,2,NULL,'menu_item','Dashboard','/dashboard','fas fa-tachometer-alt',1,NULL,'YES',1,2,'2024-08-01 06:29:24','2024-12-30 16:48:48'),
(107,2,6,0,NULL,'divider','MENU MANAGEMENT',NULL,NULL,36,NULL,'YES',1,2,'2024-08-06 14:06:11','2025-02-10 15:07:41'),
(108,2,6,0,NULL,'menu_item','Menu Master',NULL,'fas fa-table',37,NULL,'YES',1,2,'2024-08-06 14:06:40','2025-02-10 15:07:41'),
(109,2,6,46,108,'menu_item','Menu Module','/menu/module','fas fa-list',2,NULL,'YES',1,2,'2024-08-06 14:09:36','2024-12-30 15:53:18'),
(110,2,6,48,114,'menu_item','Permission','/menu/permission','fas fa-list',3,NULL,'YES',1,2,'2024-08-06 14:10:53','2025-01-01 13:13:08'),
(111,2,6,47,108,'menu_item','Module Item','/menu/module-item','fas fa-list',3,NULL,'YES',1,2,'2024-08-06 14:12:26','2024-12-30 15:53:34'),
(112,2,6,49,114,'menu_item','Role Permission','/menu/role-permission','fas fa-list',4,NULL,'YES',1,2,'2024-08-06 14:13:43','2025-01-01 13:13:14'),
(113,2,5,0,NULL,'divider','User Management',NULL,NULL,38,NULL,'YES',1,2,'2024-08-06 14:14:23','2025-02-10 15:07:41'),
(114,2,5,0,NULL,'menu_item','Access Control',NULL,'fas fa-list',39,NULL,'YES',1,2,'2024-08-06 14:14:55','2025-02-10 15:07:41'),
(115,2,5,97,114,'menu_item','User List','/users/index','fas fa-list',1,NULL,'YES',1,2,'2024-08-06 14:16:19','2024-12-30 15:56:00'),
(116,2,5,76,114,'menu_item','User Role List','/common/userRole','fas fa-list',2,NULL,'YES',1,2,'2024-08-06 14:18:51','2024-12-30 15:56:15'),
(117,2,6,88,108,'menu_item','Menu','/menu/menu','fas fa-list',1,NULL,'YES',1,2,'2024-08-06 14:20:01','2024-12-30 15:52:55');

/*Table structure for table `menu_modules` */

DROP TABLE IF EXISTS `menu_modules`;

CREATE TABLE `menu_modules` (
  `module_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'YES',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menu_modules` */

insert  into `menu_modules`(`module_id`,`module_name`,`active`,`created_by`,`updated_by`,`created_at`,`updated_at`) values 
(2,'DASHBOARED','YES',NULL,2,'2024-08-11 10:33:34','2024-08-13 09:41:32'),
(5,'User Management','YES',NULL,2,'2024-08-13 09:16:03','2024-08-13 09:16:03'),
(6,'Menu Management','YES',NULL,2,'2024-08-13 09:20:06','2024-08-13 09:20:06'),
(9,'Employee Master','YES',NULL,2,'2024-08-14 05:12:29','2024-08-14 05:12:29'),
(10,'SIDEBAR','YES',NULL,1,'2024-07-15 04:05:48','2024-07-15 04:05:48'),
(20,'DASHBOARD','YES',NULL,2,'2024-12-24 13:10:37','2024-12-24 13:10:37');

/*Table structure for table `menu_permissions` */

DROP TABLE IF EXISTS `menu_permissions`;

CREATE TABLE `menu_permissions` (
  `menu_permission_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'YES',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`menu_permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menu_permissions` */

insert  into `menu_permissions`(`menu_permission_id`,`item_id`,`name`,`slug`,`active`,`created_by`,`updated_by`,`created_at`,`updated_at`) values 
(2,2,'Dashboard','dashboard','YES',NULL,2,'2024-08-06 06:52:32','2024-08-20 06:11:18'),
(3,97,'User edit','user.edit','YES',NULL,2,'2024-08-06 06:53:18','2024-12-31 11:13:27'),
(4,97,'User create','user.create','YES',NULL,2,'2024-08-06 06:54:08','2024-12-31 11:13:20'),
(5,97,'User list','user.index','YES',NULL,2,'2024-08-06 06:54:27','2024-12-31 11:13:14'),
(7,46,'menu module list','menu.master.module.index','YES',NULL,2,'2024-08-06 14:21:19','2024-08-18 09:48:02'),
(9,48,'Permission list','menu.master.permission.index','YES',NULL,2,'2024-08-06 14:23:24','2024-08-23 17:28:12'),
(10,49,'role permission XXX','menu.master.rolePermission.index','YES',NULL,2,'2024-08-06 14:23:55','2024-08-18 09:49:12'),
(51,76,'user role list','common.master.userRole.index','YES',NULL,2,'2024-08-11 11:24:06','2024-12-31 11:13:06'),
(52,76,'user role create','common.master.userRole.create','YES',NULL,2,'2024-08-11 11:24:25','2024-12-31 11:12:54'),
(53,76,'user role edit','common.master.userRole.edit','YES',NULL,2,'2024-08-11 11:24:42','2024-12-31 11:12:46'),
(54,76,'user role delete','common.master.userRole.delete','YES',NULL,2,'2024-08-11 11:25:01','2024-12-31 11:12:39'),
(122,97,'User delete','user.delete','YES',NULL,2,'2024-08-13 10:07:52','2024-12-31 11:12:30'),
(207,88,'menu','menu.menu.index','YES',NULL,2,'2024-08-18 09:25:18','2024-12-24 16:02:09'),
(208,88,'menu create','menu.menu.create','YES',NULL,2,'2024-08-18 09:27:07','2024-12-24 16:01:35'),
(209,88,'menu edit','menu.menu.edit','YES',NULL,2,'2024-08-18 09:27:47','2024-12-24 16:01:25'),
(210,88,'menu delete','menu.menu.delete','YES',NULL,2,'2024-08-18 09:28:04','2024-12-24 16:01:14'),
(211,46,'menu module list','menu.master.module.index','YES',NULL,2,'2024-08-18 09:29:21','2024-08-18 09:47:35'),
(212,46,'menu module create','menu.master.module.create','YES',NULL,2,'2024-08-18 09:29:50','2024-08-18 09:47:16'),
(213,46,'menu module edit','menu.master.module.edit','YES',NULL,2,'2024-08-18 09:30:06','2024-08-18 09:46:02'),
(214,46,'menu module delete','menu.master.module.delete','YES',NULL,2,'2024-08-18 09:30:25','2024-08-18 09:46:44'),
(215,47,'module item list','menu.master.moduleItem.index','YES',NULL,2,'2024-08-18 09:31:21','2024-08-18 09:45:30'),
(216,47,'module item create','menu.master.moduleItem.create','YES',NULL,2,'2024-08-18 09:32:26','2024-08-18 09:45:18'),
(217,47,'module item edit','menu.master.moduleItem.edit','YES',NULL,2,'2024-08-18 09:32:53','2024-08-18 09:45:08'),
(218,47,'module item delete','menu.master.moduleItem.delete','YES',NULL,2,'2024-08-18 09:33:26','2024-08-18 09:44:54'),
(219,49,'role permission list','menu.master.rolePermission.index','YES',NULL,2,'2024-08-18 09:34:10','2024-08-18 09:42:18'),
(220,49,'role permission create','menu.master.rolePermission.create','YES',NULL,2,'2024-08-18 09:34:34','2024-08-18 09:40:24'),
(221,49,'role permission XXX','menu.master.rolePermission.create','YES',NULL,2,'2024-08-18 09:35:03','2024-08-18 09:49:22'),
(222,49,'role permission edit','menu.master.rolePermission.edit','YES',NULL,2,'2024-08-18 09:35:21','2024-08-18 09:38:33'),
(223,49,'role permission delete','menu.master.rolePermission.delete','YES',NULL,2,'2024-08-18 09:35:40','2024-08-18 09:38:25'),
(238,48,'Permission create','menu.master.permission.create','YES',NULL,2,'2024-08-23 17:29:00','2024-08-23 17:29:00'),
(239,48,'Permission edit','menu.master.permission.edit','YES',NULL,2,'2024-08-23 17:29:18','2024-08-23 17:29:18'),
(240,48,'Permission delete','menu.master.permission.delete','YES',NULL,2,'2024-08-23 17:29:40','2024-08-23 17:29:40');

/*Table structure for table `menu_role_permissions` */

DROP TABLE IF EXISTS `menu_role_permissions`;

CREATE TABLE `menu_role_permissions` (
  `menu_role_permission_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `active` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'YES',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`menu_role_permission_id`),
  KEY `menu_role_permissions_menu_permission_id_foreign` (`menu_permission_id`),
  KEY `menu_role_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `menu_role_permissions_menu_permission_id_foreign` FOREIGN KEY (`menu_permission_id`) REFERENCES `menu_permissions` (`menu_permission_id`) ON DELETE CASCADE,
  CONSTRAINT `menu_role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`role_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9907 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menu_role_permissions` */

insert  into `menu_role_permissions`(`menu_role_permission_id`,`menu_permission_id`,`role_id`,`active`,`created_by`,`updated_by`,`created_at`,`updated_at`) values 
(9621,2,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9637,215,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9638,218,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9639,217,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9640,216,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9641,9,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9642,238,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9643,239,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9644,240,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9645,10,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9646,222,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9647,223,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9648,220,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9649,219,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9650,221,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9651,7,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9652,213,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9653,214,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9654,212,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9655,211,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9712,54,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9713,53,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9714,51,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9715,52,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9752,210,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9753,209,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9754,208,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9755,207,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9903,5,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9904,4,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9905,3,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL),
(9906,122,1,'YES',NULL,NULL,'2025-02-10 15:08:42',NULL);

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `menu_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'YES',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menus` */

insert  into `menus`(`menu_id`,`menu_name`,`description`,`active`,`created_by`,`updated_by`,`created_at`,`updated_at`) values 
(2,'Sidebar','sidebar menus','YES',1,1,'2024-07-14 11:53:52','2024-07-14 11:53:59');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2024_07_10_064440_create_menu_modules_table',1),
(5,'2024_07_10_092406_create_user_roles_table',1),
(6,'2024_07_11_045212_create_menu_permissions_table',1),
(7,'2024_07_11_045246_create_menus_table',1),
(8,'2024_07_11_045342_create_menu_items_table',1),
(9,'2024_07_11_045500_create_menu_role_permissions_table',1),
(10,'2024_07_11_052350_create_module_items_table',1);

/*Table structure for table `module_items` */

DROP TABLE IF EXISTS `module_items`;

CREATE TABLE `module_items` (
  `item_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint(20) unsigned NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'YES',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `module_items_module_id_foreign` (`module_id`),
  CONSTRAINT `module_items_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `menu_modules` (`module_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `module_items` */

insert  into `module_items`(`item_id`,`module_id`,`item_name`,`active`,`created_by`,`updated_by`,`created_at`,`updated_at`) values 
(2,2,'Dashboard','YES',NULL,2,'2024-08-08 11:04:27','2024-08-13 09:42:55'),
(46,6,'Menu Module','YES',NULL,2,'2024-08-18 09:37:21','2024-08-18 09:45:47'),
(47,6,'Moudle Item','YES',NULL,2,'2024-08-18 09:37:40','2024-08-18 09:37:40'),
(48,6,'Permission','YES',NULL,2,'2024-08-18 09:37:53','2024-08-18 09:37:53'),
(49,6,'Role Permission','YES',NULL,2,'2024-08-18 09:38:08','2024-08-18 09:38:08'),
(76,5,'User Role','YES',NULL,2,'2024-12-24 13:14:14','2024-12-24 13:14:14'),
(88,6,'Menu','YES',NULL,2,'2024-12-24 15:13:07','2024-12-24 15:13:07'),
(97,5,'User','YES',NULL,2,'2024-12-30 15:55:44','2024-12-30 15:55:44');

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('c38hczsFCNJwdPSgoVJxuRa13uJBW5DVPWUDSNrY',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUDFoVmo4cEQ5d2F1R0oySDdFNnNsTXpsNkNvQXVRZ2tBWWtseUs2MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9hYnMudGVzdC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTk6ImxvZ2dlZF9zZXNzaW9uX2RhdGEiO2E6MTA6e3M6MjoiaWQiO2k6MTtzOjExOiJlbXBsb3llZV9pZCI7aToxO3M6NDoibmFtZSI7czo1OiJBZG1pbiI7czo1OiJlbWFpbCI7czoxNzoiYWRtaW5AZXhhbXBsZS5jb20iO3M6MTA6InBpbl9udW1iZXIiO3M6NToiMTAwMTEiO3M6Nzoicm9sZV9pZCI7aToxO3M6MTM6ImRlcGFydG1lbnRfaWQiO047czoxODoiaXNfZGVwYXJ0bWVudF9oZWFkIjtpOjE7czo1OiJwaG9uZSI7czoxMToiMDE3NDY2OTM1NTIiO3M6NjoiYWN0aXZlIjtzOjM6IllFUyI7fX0=',1739698782);

/*Table structure for table `user_roles` */

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `role_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'YES',
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_roles` */

insert  into `user_roles`(`role_id`,`role_name`,`active`,`created_by`,`updated_by`,`created_at`,`updated_at`) values 
(1,'Admin','YES',1,NULL,'2025-02-16 15:32:56',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `department_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_pin_number_unique` (`pin_number`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`employee_id`,`role_id`,`department_id`,`name`,`email`,`pin_number`,`phone`,`active`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,1,1,NULL,'Admin','admin@example.com','10011','01746693552','YES','2025-02-16 08:56:33','$2y$12$8YeDOfCaaKU0I9ItOtRIa.fotKe7d4U.R9Y39T4BcZrBWYcQa/OdW','0YNgfTZDPc','2025-02-16 08:56:33','2025-02-16 08:56:33');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
