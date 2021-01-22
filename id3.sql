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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Dumping data for table id3.answers: ~13 rows (approximately)
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

-- Dumping structure for table id3.languages
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(49) CHARACTER SET utf8 DEFAULT NULL,
  `iso_639` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table id3.languages: ~135 rows (approximately)
DELETE FROM `languages`;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` (`id`, `name`, `iso_639`, `created_at`, `updated_at`) VALUES
	(1, 'English', 'en', NULL, NULL),
	(2, 'Afar', 'aa', NULL, NULL),
	(3, 'Abkhazian', 'ab', NULL, NULL),
	(4, 'Afrikaans', 'af', NULL, NULL),
	(5, 'Amharic', 'am', NULL, NULL),
	(6, 'Arabic', 'ar', NULL, NULL),
	(7, 'Assamese', 'as', NULL, NULL),
	(8, 'Aymara', 'ay', NULL, NULL),
	(9, 'Azerbaijani', 'az', NULL, NULL),
	(10, 'Bashkir', 'ba', NULL, NULL),
	(11, 'Belarusian', 'be', NULL, NULL),
	(12, 'Bulgarian', 'bg', NULL, NULL),
	(13, 'Bihari', 'bh', NULL, NULL),
	(14, 'Bislama', 'bi', NULL, NULL),
	(15, 'Bengali/Bangla', 'bn', NULL, NULL),
	(16, 'Tibetan', 'bo', NULL, NULL),
	(17, 'Breton', 'br', NULL, NULL),
	(18, 'Catalan', 'ca', NULL, NULL),
	(19, 'Corsican', 'co', NULL, NULL),
	(20, 'Czech', 'cs', NULL, NULL),
	(21, 'Welsh', 'cy', NULL, NULL),
	(22, 'Danish', 'da', NULL, NULL),
	(23, 'German', 'de', NULL, NULL),
	(24, 'Bhutani', 'dz', NULL, NULL),
	(25, 'Greek', 'el', NULL, NULL),
	(26, 'Esperanto', 'eo', NULL, NULL),
	(27, 'Spanish', 'es', NULL, NULL),
	(28, 'Estonian', 'et', NULL, NULL),
	(29, 'Basque', 'eu', NULL, NULL),
	(30, 'Persian', 'fa', NULL, NULL),
	(31, 'Finnish', 'fi', NULL, NULL),
	(32, 'Fiji', 'fj', NULL, NULL),
	(33, 'Faeroese', 'fo', NULL, NULL),
	(34, 'French', 'fr', NULL, NULL),
	(35, 'Frisian', 'fy', NULL, NULL),
	(36, 'Irish', 'ga', NULL, NULL),
	(37, 'Scots/Gaelic', 'gd', NULL, NULL),
	(38, 'Galician', 'gl', NULL, NULL),
	(39, 'Guarani', 'gn', NULL, NULL),
	(40, 'Gujarati', 'gu', NULL, NULL),
	(41, 'Hausa', 'ha', NULL, NULL),
	(42, 'Hindi', 'hi', NULL, NULL),
	(43, 'Croatian', 'hr', NULL, NULL),
	(44, 'Hungarian', 'hu', NULL, NULL),
	(45, 'Armenian', 'hy', NULL, NULL),
	(46, 'Interlingua', 'ia', NULL, NULL),
	(47, 'Interlingue', 'ie', NULL, NULL),
	(48, 'Inupiak', 'ik', NULL, NULL),
	(49, 'Indonesian', 'in', NULL, NULL),
	(50, 'Icelandic', 'is', NULL, NULL),
	(51, 'Italian', 'it', NULL, NULL),
	(52, 'Hebrew', 'iw', NULL, NULL),
	(53, 'Japanese', 'ja', NULL, NULL),
	(54, 'Yiddish', 'ji', NULL, NULL),
	(55, 'Javanese', 'jw', NULL, NULL),
	(56, 'Georgian', 'ka', NULL, NULL),
	(57, 'Kazakh', 'kk', NULL, NULL),
	(58, 'Greenlandic', 'kl', NULL, NULL),
	(59, 'Cambodian', 'km', NULL, NULL),
	(60, 'Kannada', 'kn', NULL, NULL),
	(61, 'Korean', 'ko', NULL, NULL),
	(62, 'Kashmiri', 'ks', NULL, NULL),
	(63, 'Kurdish', 'ku', NULL, NULL),
	(64, 'Kirghiz', 'ky', NULL, NULL),
	(65, 'Latin', 'la', NULL, NULL),
	(66, 'Lingala', 'ln', NULL, NULL),
	(67, 'Laothian', 'lo', NULL, NULL),
	(68, 'Lithuanian', 'lt', NULL, NULL),
	(69, 'Latvian/Lettish', 'lv', NULL, NULL),
	(70, 'Malagasy', 'mg', NULL, NULL),
	(71, 'Maori', 'mi', NULL, NULL),
	(72, 'Macedonian', 'mk', NULL, NULL),
	(73, 'Malayalam', 'ml', NULL, NULL),
	(74, 'Mongolian', 'mn', NULL, NULL),
	(75, 'Moldavian', 'mo', NULL, NULL),
	(76, 'Marathi', 'mr', NULL, NULL),
	(77, 'Malay', 'ms', NULL, NULL),
	(78, 'Maltese', 'mt', NULL, NULL),
	(79, 'Burmese', 'my', NULL, NULL),
	(80, 'Nauru', 'na', NULL, NULL),
	(81, 'Nepali', 'ne', NULL, NULL),
	(82, 'Dutch', 'nl', NULL, NULL),
	(83, 'Norwegian', 'no', NULL, NULL),
	(84, 'Occitan', 'oc', NULL, NULL),
	(85, '(Afan)/Oromoor/Oriya', 'om', NULL, NULL),
	(86, 'Punjabi', 'pa', NULL, NULL),
	(87, 'Polish', 'pl', NULL, NULL),
	(88, 'Pashto/Pushto', 'ps', NULL, NULL),
	(89, 'Portuguese', 'pt', NULL, NULL),
	(90, 'Quechua', 'qu', NULL, NULL),
	(91, 'Rhaeto-Romance', 'rm', NULL, NULL),
	(92, 'Kirundi', 'rn', NULL, NULL),
	(93, 'Romanian', 'ro', NULL, NULL),
	(94, 'Russian', 'ru', NULL, NULL),
	(95, 'Kinyarwanda', 'rw', NULL, NULL),
	(96, 'Sanskrit', 'sa', NULL, NULL),
	(97, 'Sindhi', 'sd', NULL, NULL),
	(98, 'Sangro', 'sg', NULL, NULL),
	(99, 'Serbo-Croatian', 'sh', NULL, NULL),
	(100, 'Singhalese', 'si', NULL, NULL),
	(101, 'Slovak', 'sk', NULL, NULL),
	(102, 'Slovenian', 'sl', NULL, NULL),
	(103, 'Samoan', 'sm', NULL, NULL),
	(104, 'Shona', 'sn', NULL, NULL),
	(105, 'Somali', 'so', NULL, NULL),
	(106, 'Albanian', 'sq', NULL, NULL),
	(107, 'Serbian', 'sr', NULL, NULL),
	(108, 'Siswati', 'ss', NULL, NULL),
	(109, 'Sesotho', 'st', NULL, NULL),
	(110, 'Sundanese', 'su', NULL, NULL),
	(111, 'Swedish', 'sv', NULL, NULL),
	(112, 'Swahili', 'sw', NULL, NULL),
	(113, 'Tamil', 'ta', NULL, NULL),
	(114, 'Telugu', 'te', NULL, NULL),
	(115, 'Tajik', 'tg', NULL, NULL),
	(116, 'Thai', 'th', NULL, NULL),
	(117, 'Tigrinya', 'ti', NULL, NULL),
	(118, 'Turkmen', 'tk', NULL, NULL),
	(119, 'Tagalog', 'tl', NULL, NULL),
	(120, 'Setswana', 'tn', NULL, NULL),
	(121, 'Tonga', 'to', NULL, NULL),
	(122, 'Turkish', 'tr', NULL, NULL),
	(123, 'Tsonga', 'ts', NULL, NULL),
	(124, 'Tatar', 'tt', NULL, NULL),
	(125, 'Twi', 'tw', NULL, NULL),
	(126, 'Ukrainian', 'uk', NULL, NULL),
	(127, 'Urdu', 'ur', NULL, NULL),
	(128, 'Uzbek', 'uz', NULL, NULL),
	(129, 'Vietnamese', 'vi', NULL, NULL),
	(130, 'Volapuk', 'vo', NULL, NULL),
	(131, 'Wolof', 'wo', NULL, NULL),
	(132, 'Xhosa', 'xh', NULL, NULL),
	(133, 'Yoruba', 'yo', NULL, NULL),
	(134, 'Chinese', 'zh', NULL, NULL),
	(135, 'Zulu', 'zu', NULL, NULL);
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Dumping data for table id3.records: ~18 rows (approximately)
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

-- Dumping data for table id3.records_answers: ~64 rows (approximately)
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
