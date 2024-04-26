-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.36-0ubuntu0.20.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for test_assignment
CREATE DATABASE IF NOT EXISTS `test_assignment` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `test_assignment`;

-- Dumping structure for table test_assignment.azans
CREATE TABLE IF NOT EXISTS `azans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table test_assignment.azans: ~5 rows (approximately)
DELETE FROM `azans`;
INSERT INTO `azans` (`id`, `name`, `path`, `created_at`, `updated_at`) VALUES
	(1, 'Urdu', 'app/frontend/assets/audio/urdu.mp3', '2024-04-05 17:35:59', '2024-04-05 17:36:00');
INSERT INTO `azans` (`id`, `name`, `path`, `created_at`, `updated_at`) VALUES
	(2, 'Russian', 'app/frontend/assets/audio/russian.mp3', NULL, NULL);
INSERT INTO `azans` (`id`, `name`, `path`, `created_at`, `updated_at`) VALUES
	(3, 'Malasian', 'app/frontend/assets/audio/malasian.mp3', NULL, NULL);
INSERT INTO `azans` (`id`, `name`, `path`, `created_at`, `updated_at`) VALUES
	(4, 'Arabic', 'app/frontend/assets/audio/arabic.mp3', NULL, NULL);
INSERT INTO `azans` (`id`, `name`, `path`, `created_at`, `updated_at`) VALUES
	(5, 'English', 'app/frontend/assets/audio/english.mp3', NULL, NULL);

-- Dumping structure for table test_assignment.boxes
CREATE TABLE IF NOT EXISTS `boxes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_zone_id` bigint unsigned NOT NULL,
  `azan_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boxes_time_zone_id_foreign` (`time_zone_id`),
  KEY `boxes_azan_id_foreign` (`azan_id`),
  CONSTRAINT `boxes_azan_id_foreign` FOREIGN KEY (`azan_id`) REFERENCES `azans` (`id`),
  CONSTRAINT `boxes_time_zone_id_foreign` FOREIGN KEY (`time_zone_id`) REFERENCES `time_zones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table test_assignment.boxes: ~2 rows (approximately)
DELETE FROM `boxes`;
INSERT INTO `boxes` (`id`, `name`, `time_zone_id`, `azan_id`, `created_at`, `updated_at`) VALUES
	(1, 'Na1', 6, 1, '2024-04-21 12:34:00', '2024-04-21 12:34:00');
INSERT INTO `boxes` (`id`, `name`, `time_zone_id`, `azan_id`, `created_at`, `updated_at`) VALUES
	(2, 'Box2', 3, 3, NULL, NULL);

-- Dumping structure for table test_assignment.box_subscriptions
CREATE TABLE IF NOT EXISTS `box_subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `box_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `box_subscriptions_user_id_unique` (`user_id`),
  KEY `box_subscriptions_box_id_foreign` (`box_id`),
  CONSTRAINT `box_subscriptions_box_id_foreign` FOREIGN KEY (`box_id`) REFERENCES `boxes` (`id`),
  CONSTRAINT `box_subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table test_assignment.box_subscriptions: ~0 rows (approximately)
DELETE FROM `box_subscriptions`;

-- Dumping structure for table test_assignment.namaz_times
CREATE TABLE IF NOT EXISTS `namaz_times` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `time_zone_id` bigint unsigned NOT NULL,
  `namaz` enum('imsak','fajr','syuruk','dhuhr','asr','maghrib','isha') COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `namaz_times_time_zone_id_foreign` (`time_zone_id`),
  CONSTRAINT `namaz_times_time_zone_id_foreign` FOREIGN KEY (`time_zone_id`) REFERENCES `time_zones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10153 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table test_assignment.namaz_times: ~0 rows (approximately)
DELETE FROM `namaz_times`;

-- Dumping structure for table test_assignment.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table test_assignment.roles: ~2 rows (approximately)
DELETE FROM `roles`;
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '2024-04-05 11:37:45', '2024-04-05 11:37:48');
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(2, 'user', '2024-04-05 11:38:01', '2024-04-05 11:38:04');

-- Dumping structure for table test_assignment.time_zones
CREATE TABLE IF NOT EXISTS `time_zones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table test_assignment.time_zones: ~16 rows (approximately)
DELETE FROM `time_zones`;
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(2, 'JHR01', '2024-04-05 12:01:12', '2024-04-05 12:01:13');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(3, 'JHR02', '2024-04-05 12:01:14', '2024-04-05 12:01:15');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(4, 'JHR03', '2024-04-05 12:01:18', '2024-04-05 12:01:17');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(5, 'JHR04', '2024-04-05 12:01:20', '2024-04-05 12:01:19');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(6, 'KDH01', '2024-04-05 12:01:23', '2024-04-05 12:01:22');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(7, 'KDH02', '2024-04-05 12:01:24', '2024-04-05 12:01:25');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(8, 'KDH03', '2024-04-05 12:01:26', '2024-04-05 12:01:27');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(9, 'KDH04', '2024-04-05 12:01:28', '2024-04-05 12:01:30');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(10, 'KDH05', '2024-04-05 12:01:31', '2024-04-05 12:01:32');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(11, 'KDH06', '2024-04-05 12:01:33', '2024-04-05 12:01:34');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(12, 'KDH07', '2024-04-05 12:01:36', '2024-04-05 12:01:35');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(13, 'KTN01', '2024-04-05 12:01:37', '2024-04-05 12:01:37');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(14, 'KTN03', '2024-04-05 12:01:39', '2024-04-05 12:01:38');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(15, 'MLK01', '2024-04-05 12:01:40', '2024-04-05 12:01:41');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(16, 'NGS01', '2024-04-05 12:01:46', '2024-04-05 12:01:42');
INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(17, 'NGS02', '2024-04-05 12:01:44', '2024-04-05 12:01:43');

-- Dumping structure for table test_assignment.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table test_assignment.users: ~2 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@gmail.com', '123456', 1, '2024-04-05 11:49:11', '2024-04-05 11:49:12');
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `created_at`, `updated_at`) VALUES
	(2, 'user', 'user@gmail.com', '123456', 2, '2024-04-05 11:49:11', '2024-04-05 11:49:12');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
