-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table id3.answers
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `answer` varchar(50) NOT NULL,
  `questions_id` int(11) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__questions` (`questions_id`),
  CONSTRAINT `FK__questions` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table id3.answers: ~10 rows (approximately)
DELETE FROM `answers`;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` (`id`, `answer`, `questions_id`, `created_at`, `updated_at`) VALUES
	(1, 'Sunny', 1, NULL, NULL),
	(2, 'Overcast', 1, NULL, NULL),
	(3, 'Rainy', 1, NULL, NULL),
	(4, 'Hot', 2, NULL, NULL),
	(5, 'Mild', 2, NULL, NULL),
	(6, 'Cool', 2, NULL, NULL),
	(7, 'High', 3, NULL, NULL),
	(8, 'Normal', 3, NULL, NULL),
	(9, 'Weak', 4, NULL, NULL),
	(10, 'Strong', 4, NULL, NULL);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;

-- Dumping structure for table id3.configs
CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table id3.configs: ~2 rows (approximately)
DELETE FROM `configs`;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
INSERT INTO `configs` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
	(1, 'last_question', 'Do you want to play tennis?', NULL, NULL),
	(2, 'min_records', '10', NULL, NULL);
/*!40000 ALTER TABLE `configs` ENABLE KEYS */;

-- Dumping structure for table id3.questions
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table id3.questions: ~4 rows (approximately)
DELETE FROM `questions`;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` (`id`, `question`, `created_at`, `updated_at`) VALUES
	(1, 'Outlook', NULL, NULL),
	(2, 'Temperature', NULL, NULL),
	(3, 'Humidity', NULL, NULL),
	(4, 'Windy', NULL, NULL);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;

-- Dumping structure for table id3.records
CREATE TABLE IF NOT EXISTS `records` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `final` tinyint(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table id3.records: ~14 rows (approximately)
DELETE FROM `records`;
/*!40000 ALTER TABLE `records` DISABLE KEYS */;
INSERT INTO `records` (`id`, `final`, `created_at`, `updated_at`) VALUES
	(1, 0, NULL, NULL),
	(2, 0, NULL, NULL),
	(3, 1, NULL, NULL),
	(4, 1, NULL, NULL),
	(5, 1, NULL, NULL),
	(6, 0, NULL, NULL),
	(7, 1, NULL, NULL),
	(8, 0, NULL, NULL),
	(9, 1, NULL, NULL),
	(10, 1, NULL, NULL),
	(11, 1, NULL, NULL),
	(12, 1, NULL, NULL),
	(13, 1, NULL, NULL),
	(14, 0, NULL, NULL);
/*!40000 ALTER TABLE `records` ENABLE KEYS */;

-- Dumping structure for table id3.records_answers
CREATE TABLE IF NOT EXISTS `records_answers` (
  `records_id` int(11) unsigned NOT NULL,
  `answers_id` int(11) unsigned NOT NULL,
  KEY `FK__records` (`records_id`),
  KEY `FK__answers` (`answers_id`),
  CONSTRAINT `FK__answers` FOREIGN KEY (`answers_id`) REFERENCES `answers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK__records` FOREIGN KEY (`records_id`) REFERENCES `records` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table id3.records_answers: ~56 rows (approximately)
DELETE FROM `records_answers`;
/*!40000 ALTER TABLE `records_answers` DISABLE KEYS */;
INSERT INTO `records_answers` (`records_id`, `answers_id`) VALUES
	(1, 1),
	(1, 4),
	(1, 7),
	(1, 9),
	(2, 1),
	(2, 4),
	(2, 7),
	(2, 10),
	(3, 2),
	(3, 4),
	(3, 7),
	(3, 9),
	(4, 3),
	(4, 5),
	(4, 7),
	(4, 9),
	(5, 6),
	(5, 3),
	(5, 8),
	(5, 9),
	(6, 3),
	(6, 6),
	(6, 8),
	(6, 10),
	(7, 2),
	(7, 6),
	(7, 8),
	(7, 10),
	(8, 1),
	(8, 5),
	(8, 7),
	(8, 9),
	(9, 1),
	(9, 6),
	(9, 8),
	(9, 9),
	(10, 3),
	(10, 5),
	(10, 8),
	(10, 9),
	(11, 1),
	(11, 5),
	(11, 8),
	(11, 10),
	(12, 2),
	(12, 5),
	(12, 7),
	(12, 10),
	(13, 2),
	(13, 4),
	(13, 8),
	(13, 9),
	(14, 3),
	(14, 5),
	(14, 7),
	(14, 10);
/*!40000 ALTER TABLE `records_answers` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
