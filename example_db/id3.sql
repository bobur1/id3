-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.19 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table id3.questions
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table id3.questions: ~4 rows (approximately)
DELETE FROM `questions`;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` (`id`, `question`) VALUES
	(1, 'Outlook'),
	(2, 'Temperature'),
	(3, 'Humidity'),
	(4, 'Windy');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;


-- Dumping structure for table id3.answers
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `answer` varchar(50) NOT NULL,
  `questions_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__questions` (`questions_id`),
  CONSTRAINT `FK__questions` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table id3.answers: ~10 rows (approximately)
DELETE FROM `answers`;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` (`id`, `answer`, `questions_id`) VALUES
  (1, 'Sunny', 1),
  (2, 'Overcast', 1),
  (3, 'Rainy', 1),
  (4, 'Hot', 2),
  (5, 'Mild', 2),
  (6, 'Cool', 2),
  (7, 'High', 3),
  (8, 'Normal', 3),
  (9, 'Weak', 4),
  (10, 'Strong', 4);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;


-- Dumping structure for table id3.records
CREATE TABLE IF NOT EXISTS `records` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `final` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table id3.records: ~14 rows (approximately)
DELETE FROM `records`;
/*!40000 ALTER TABLE `records` DISABLE KEYS */;
INSERT INTO `records` (`id`, `final`) VALUES
	(1, 0),
	(2, 0),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 0),
	(7, 1),
	(8, 0),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1),
	(14, 0);
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
