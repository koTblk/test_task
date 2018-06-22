# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: 127.0.0.1 (MySQL 5.6.39)
# Схема: test_task
# Время создания: 2018-06-22 11:07:06 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы countries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `cnt_id` int(11) NOT NULL AUTO_INCREMENT,
  `cnt_code` varchar(255) DEFAULT NULL,
  `cnt_title` varchar(255) DEFAULT NULL,
  `cnt_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cnt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;

INSERT INTO `countries` (`cnt_id`, `cnt_code`, `cnt_title`, `cnt_created`)
VALUES
	(1,'044','UK','2018-06-22 10:58:03'),
	(2,'123','kr','2018-06-22 10:58:03'),
	(3,'1123','US','2018-06-22 10:58:03'),
	(4,'512','asd','2018-06-22 10:58:03');

/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы migration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;

INSERT INTO `migration` (`version`, `apply_time`)
VALUES
	('m000000_000000_base',1529665055),
	('m180621_151020_struct',1529665056),
	('m180621_153311_send_log_aggregated',1529665056);

/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы numbers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `numbers`;

CREATE TABLE `numbers` (
  `num_id` int(11) NOT NULL AUTO_INCREMENT,
  `cnt_id` int(11) DEFAULT NULL,
  `num_number` int(11) DEFAULT NULL,
  `num_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`num_id`),
  KEY `NumCntId_to_CntCntId` (`cnt_id`),
  CONSTRAINT `NumCntId_to_CntCntId` FOREIGN KEY (`cnt_id`) REFERENCES `countries` (`cnt_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `numbers` WRITE;
/*!40000 ALTER TABLE `numbers` DISABLE KEYS */;

INSERT INTO `numbers` (`num_id`, `cnt_id`, `num_number`, `num_created`)
VALUES
	(1,1,444,'2018-06-22 10:58:27'),
	(2,2,444,'2018-06-22 10:58:27'),
	(3,2,444,'2018-06-22 10:58:27');

/*!40000 ALTER TABLE `numbers` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы send_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `send_log`;

CREATE TABLE `send_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` int(11) NOT NULL,
  `num_id` int(11) NOT NULL,
  `log_message` varchar(255) DEFAULT NULL,
  `log_success` tinyint(1) DEFAULT NULL,
  `log_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `LogUsrId_to_UsrUsrId` (`usr_id`),
  KEY `LogNumId_to_NumNumId` (`num_id`),
  CONSTRAINT `LogNumId_to_NumNumId` FOREIGN KEY (`num_id`) REFERENCES `numbers` (`num_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `LogUsrId_to_UsrUsrId` FOREIGN KEY (`usr_id`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

LOCK TABLES `send_log` WRITE;
/*!40000 ALTER TABLE `send_log` DISABLE KEYS */;

INSERT INTO `send_log` (`log_id`, `usr_id`, `num_id`, `log_message`, `log_success`, `log_created`)
VALUES
	(2,2,1,'test',1,'2018-06-22 10:58:47'),
	(3,1,1,'test',0,'2018-06-22 10:58:47'),
	(4,1,1,'test',0,'2018-06-22 10:58:47'),
	(5,1,1,'test',0,'2018-06-22 10:58:47'),
	(6,1,1,'test',1,'2018-06-22 10:58:47');

/*!40000 ALTER TABLE `send_log` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы send_log_aggregated
# ------------------------------------------------------------

DROP TABLE IF EXISTS `send_log_aggregated`;

CREATE TABLE `send_log_aggregated` (
  `date` date NOT NULL,
  `log_success_count` int(11) DEFAULT NULL,
  `log_failed_count` int(11) DEFAULT NULL,
  `cnt_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL,
  KEY `UserUsrId_to_aggrUsrId` (`usr_id`),
  KEY `CountryCntId_to_AggrCntId` (`cnt_id`),
  CONSTRAINT `CountryCntId_to_AggrCntId` FOREIGN KEY (`cnt_id`) REFERENCES `countries` (`cnt_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `UserUsrId_to_aggrUsrId` FOREIGN KEY (`usr_id`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `send_log_aggregated` WRITE;
/*!40000 ALTER TABLE `send_log_aggregated` DISABLE KEYS */;

INSERT INTO `send_log_aggregated` (`date`, `log_success_count`, `log_failed_count`, `cnt_id`, `usr_id`)
VALUES
	('2017-01-01',3,4,2,1),
	('2017-01-01',3,4,2,1),
	('2017-01-01',3,4,2,1);

/*!40000 ALTER TABLE `send_log_aggregated` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_name` varchar(255) DEFAULT NULL,
  `usr_active` smallint(1) DEFAULT '1',
  `usr_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`usr_id`, `usr_name`, `usr_active`, `usr_created`)
VALUES
	(1,'yura',1,'2018-06-22 10:57:49'),
	(2,'dima',1,'2018-06-22 10:57:53');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
