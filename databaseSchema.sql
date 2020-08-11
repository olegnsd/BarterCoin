-- MariaDB dump 10.17  Distrib 10.4.8-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: barter
-- ------------------------------------------------------
-- Server version	10.3.18-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Session`
--

DROP TABLE IF EXISTS `Session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Session` (
  `Session_Id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Session_Expires` datetime NOT NULL,
  `Session_Data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Session_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `number` varchar(16) NOT NULL,
  `expiremonth` int(3) NOT NULL,
  `expireyear` int(4) NOT NULL,
  `cvc` int(3) NOT NULL,
  `activated` int(2) NOT NULL DEFAULT 0,
  `black` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0-чистая, 1 - в ЧС',
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `lim` bigint(20) NOT NULL,
  `monthlim` float NOT NULL,
  `withdrawlim` float NOT NULL DEFAULT 500,
  `lim_one` int(10) unsigned NOT NULL DEFAULT 200 COMMENT 'лимит за раз',
  `withdraw_int` int(11) NOT NULL DEFAULT 60 COMMENT 'интервал вывода мин',
  `amount_ref` int(11) NOT NULL DEFAULT 5,
  `loan_accept` mediumint(9) DEFAULT 1 COMMENT '0-запрещено, 1-разрешено, 1****-fisl',
  `data` mediumtext NOT NULL DEFAULT '' COMMENT 'title=>text, descr=>text, got=>1-no, 2-yes',
  `bankomats` varchar(256) NOT NULL DEFAULT '{"allow":[1]}',
  `name1` varchar(64) NOT NULL,
  `name2` varchar(64) NOT NULL,
  `name3` varchar(64) NOT NULL,
  `phone` varchar(19) DEFAULT NULL,
  `phone_utc` int(2) DEFAULT NULL,
  `ip_reg` varchar(16) DEFAULT NULL,
  `info_ip` varchar(256) DEFAULT NULL,
  `ip_trusted` varchar(2000) DEFAULT NULL,
  `is_try_trans` tinyint(4) DEFAULT NULL,
  `yandex` varchar(18) DEFAULT NULL COMMENT 'счет для вывода',
  `qiwi` varchar(15) DEFAULT NULL COMMENT 'счет для вывода',
  `visa_mastercard` varchar(16) DEFAULT NULL,
  `cod_vs_mc` mediumint(9) DEFAULT NULL,
  `webmoney` varchar(16) DEFAULT NULL,
  `payeer` varchar(20) DEFAULT NULL,
  `black_wallet` varchar(18) DEFAULT NULL COMMENT 'кошелек из за которого блокнулся',
  `last_sms` int(10) unsigned NOT NULL DEFAULT 0,
  `telegram` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`),
  KEY `activated` (`activated`)
) ENGINE=InnoDB AUTO_INCREMENT=6146 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `adminy`
--

DROP TABLE IF EXISTS `adminy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(15) NOT NULL DEFAULT '',
  `password` varchar(70) NOT NULL DEFAULT '',
  `is_admin` int(2) NOT NULL DEFAULT 0,
  `util` int(1) unsigned NOT NULL DEFAULT 0 COMMENT 'жкх',
  `comment` mediumtext NOT NULL,
  `seen` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `balance`
--

DROP TABLE IF EXISTS `balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sum` bigint(20) NOT NULL,
  `add_sum` smallint(6) NOT NULL,
  `max` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `balance12`
--

DROP TABLE IF EXISTS `balance12`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance12` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sum` bigint(20) NOT NULL,
  `add_sum` smallint(6) NOT NULL,
  `max` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `balance13`
--

DROP TABLE IF EXISTS `balance13`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance13` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sum` bigint(20) NOT NULL,
  `add_sum` smallint(6) NOT NULL,
  `max` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `card_for_pay`
--

DROP TABLE IF EXISTS `card_for_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `card_for_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `card_rel` int(11) NOT NULL,
  `name` varchar(256) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `number` varchar(20) NOT NULL,
  `amount` bigint(20) unsigned NOT NULL,
  `status` varchar(256) CHARACTER SET utf8 NOT NULL DEFAULT 'Ожидание активации',
  `status_id` tinyint(2) NOT NULL DEFAULT 0,
  `date_act` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comissions`
--

DROP TABLE IF EXISTS `comissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sum` bigint(11) NOT NULL,
  `comission` smallint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_type` varchar(25) DEFAULT NULL,
  `image` mediumblob NOT NULL,
  `image_size` varchar(25) DEFAULT NULL,
  `image_ctgy` varchar(25) DEFAULT NULL,
  `image_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loans`
--

DROP TABLE IF EXISTS `loans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sum_loan` bigint(20) NOT NULL,
  `sum_issuse` bigint(20) NOT NULL DEFAULT 0,
  `date_loan` datetime DEFAULT NULL,
  `decision` int(2) NOT NULL COMMENT '0-на рассмотр, 1-да, 2-отказ, 3-выдан',
  `issue_date` datetime DEFAULT NULL,
  `loan_rep` bigint(20) NOT NULL DEFAULT 0,
  `date_rep` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=305 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pay_phone`
--

DROP TABLE IF EXISTS `pay_phone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pay_phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer` varchar(2048) CHARACTER SET utf8 DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3218 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `per_room`
--

DROP TABLE IF EXISTS `per_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `per_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) NOT NULL,
  `password` varchar(70) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phone_for_pay`
--

DROP TABLE IF EXISTS `phone_for_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phone_for_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `card_rel` int(11) NOT NULL,
  `name` varchar(256) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `number` varchar(20) NOT NULL,
  `amount` bigint(20) unsigned NOT NULL,
  `status` varchar(256) CHARACTER SET utf8 NOT NULL DEFAULT 'Ожидание активации',
  `status_id` tinyint(2) NOT NULL DEFAULT 0,
  `date_act` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `qaz_add_br`
--

DROP TABLE IF EXISTS `qaz_add_br`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qaz_add_br` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(2056) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7596870 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `qaz_barter`
--

DROP TABLE IF EXISTS `qaz_barter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qaz_barter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(2056) CHARACTER SET utf8 NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `referals`
--

DROP TABLE IF EXISTS `referals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `referals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `phone` varchar(18) CHARACTER SET utf8 NOT NULL,
  `date` date NOT NULL,
  `activated` int(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1973 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `amount_max` varchar(20) DEFAULT NULL,
  `delta_time` int(11) DEFAULT NULL,
  `token` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `exp_token` date DEFAULT NULL,
  `last_time` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `card` int(6) NOT NULL,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `key1` varchar(16) COLLATE utf8_bin NOT NULL,
  `key2` varchar(16) COLLATE utf8_bin NOT NULL,
  `url` varchar(128) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `card` (`card`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sms`
--

DROP TABLE IF EXISTS `sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms` (
  `code1` varchar(128) NOT NULL,
  `code2` varchar(128) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `chck` varchar(32) NOT NULL,
  UNIQUE KEY `code1` (`code1`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sms_bombila`
--

DROP TABLE IF EXISTS `sms_bombila`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_bombila` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(6) NOT NULL,
  `id_acc` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=314 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_0`
--

DROP TABLE IF EXISTS `task_0`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_0` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_274`
--

DROP TABLE IF EXISTS `task_274`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_274` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3634 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_275`
--

DROP TABLE IF EXISTS `task_275`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_275` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6708 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_276`
--

DROP TABLE IF EXISTS `task_276`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_276` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6864 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_279`
--

DROP TABLE IF EXISTS `task_279`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_279` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8687 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_280`
--

DROP TABLE IF EXISTS `task_280`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_280` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=246 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_282`
--

DROP TABLE IF EXISTS `task_282`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_282` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_283`
--

DROP TABLE IF EXISTS `task_283`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_283` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9558 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_285`
--

DROP TABLE IF EXISTS `task_285`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_285` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2210 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_288`
--

DROP TABLE IF EXISTS `task_288`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_288` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_289`
--

DROP TABLE IF EXISTS `task_289`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_289` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8133 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_294`
--

DROP TABLE IF EXISTS `task_294`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_294` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13267 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_298`
--

DROP TABLE IF EXISTS `task_298`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_298` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4715 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_300`
--

DROP TABLE IF EXISTS `task_300`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_300` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17016 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_303`
--

DROP TABLE IF EXISTS `task_303`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_303` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2887 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_304`
--

DROP TABLE IF EXISTS `task_304`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_304` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3399 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_307`
--

DROP TABLE IF EXISTS `task_307`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_307` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14713 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_308`
--

DROP TABLE IF EXISTS `task_308`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_308` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15748 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_309`
--

DROP TABLE IF EXISTS `task_309`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_309` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=222 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_311`
--

DROP TABLE IF EXISTS `task_311`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_311` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2825 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_312`
--

DROP TABLE IF EXISTS `task_312`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_312` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_313`
--

DROP TABLE IF EXISTS `task_313`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_313` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_314`
--

DROP TABLE IF EXISTS `task_314`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_314` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1518 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_321`
--

DROP TABLE IF EXISTS `task_321`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_321` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_322`
--

DROP TABLE IF EXISTS `task_322`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_322` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_323`
--

DROP TABLE IF EXISTS `task_323`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_323` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_324`
--

DROP TABLE IF EXISTS `task_324`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_324` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_325`
--

DROP TABLE IF EXISTS `task_325`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_325` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=220 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_327`
--

DROP TABLE IF EXISTS `task_327`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_327` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2406 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_330`
--

DROP TABLE IF EXISTS `task_330`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_330` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_331`
--

DROP TABLE IF EXISTS `task_331`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_331` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_332`
--

DROP TABLE IF EXISTS `task_332`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_332` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_333`
--

DROP TABLE IF EXISTS `task_333`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_333` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_334`
--

DROP TABLE IF EXISTS `task_334`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_334` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_335`
--

DROP TABLE IF EXISTS `task_335`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_335` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=139 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_339`
--

DROP TABLE IF EXISTS `task_339`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_339` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3790 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_343`
--

DROP TABLE IF EXISTS `task_343`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_343` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_349`
--

DROP TABLE IF EXISTS `task_349`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_349` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_352`
--

DROP TABLE IF EXISTS `task_352`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_352` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_355`
--

DROP TABLE IF EXISTS `task_355`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_355` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_361`
--

DROP TABLE IF EXISTS `task_361`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_361` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_364`
--

DROP TABLE IF EXISTS `task_364`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_364` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_371`
--

DROP TABLE IF EXISTS `task_371`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_371` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14145 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_372`
--

DROP TABLE IF EXISTS `task_372`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_372` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `zone` int(2) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5213 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tasks_tasks_sms`
--

DROP TABLE IF EXISTS `tasks_tasks_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks_tasks_sms` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `sms` mediumtext CHARACTER SET utf8 NOT NULL,
  `sim` tinyint(4) NOT NULL,
  `data` mediumtext CHARACTER SET utf8 NOT NULL,
  `t_all` int(6) NOT NULL DEFAULT 0,
  `next` int(6) NOT NULL DEFAULT 0,
  `status` int(3) NOT NULL DEFAULT -1 COMMENT '-1-пауза, 0-в процессе, 1-пауза, 2-выполнено',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=373 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tasks_user_api_calls`
--

DROP TABLE IF EXISTS `tasks_user_api_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks_user_api_calls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mode` tinyint(4) NOT NULL DEFAULT 0,
  `api_key` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `timefrom` char(5) COLLATE utf8_bin NOT NULL DEFAULT '10:00',
  `timeto` char(5) COLLATE utf8_bin NOT NULL DEFAULT '14:00',
  `prefix` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `prior` enum('3','2','1','0','-1','-2','-3') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `caller` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `sms_enable` tinyint(4) DEFAULT NULL,
  `sms_text` text CHARACTER SET utf8 DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `time_zone`
--

DROP TABLE IF EXISTS `time_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_cod` varchar(3) DEFAULT NULL,
  `phone_from` varchar(7) DEFAULT NULL,
  `phone_to` varchar(7) DEFAULT NULL,
  `zone` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6551 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `fromid` int(6) NOT NULL,
  `toid` int(6) NOT NULL,
  `sum` float NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `comment` text NOT NULL,
  `iswithdraw` int(2) NOT NULL DEFAULT 0,
  `bankomat` int(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`),
  KEY `fromid` (`fromid`,`timestamp`)
) ENGINE=InnoDB AUTO_INCREMENT=65560 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `util`
--

DROP TABLE IF EXISTS `util`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `util` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'token qiwi',
  `util_id_recip` varchar(20) NOT NULL COMMENT 'id куда платить',
  `util_id_prov` varchar(20) NOT NULL COMMENT 'Идентификатор провайдера киви',
  `util_value` int(10) unsigned NOT NULL COMMENT 'сколько пополнять',
  `util_day` tinyint(3) unsigned NOT NULL COMMENT 'пополнять раз в Х дней',
  `util_time` time NOT NULL,
  `prior` tinyint(4) NOT NULL COMMENT 'приоритет',
  `min_fiat` int(10) unsigned NOT NULL DEFAULT 500 COMMENT 'минимум донора, при котором пополнять',
  `pay` tinyint(4) NOT NULL,
  `last_pay` datetime DEFAULT '2000-01-01 00:00:00',
  `num_launch` int(11) NOT NULL DEFAULT 10000,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `util_log`
--

DROP TABLE IF EXISTS `util_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `util_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `util_id` int(10) unsigned NOT NULL COMMENT 'id to util',
  `util_pay` int(11) NOT NULL COMMENT 'сколько пополнено',
  `answer` varchar(2048) CHARACTER SET utf8 DEFAULT NULL,
  `date` datetime NOT NULL COMMENT 'дата пополнения',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=837 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `withdrawals`
--

DROP TABLE IF EXISTS `withdrawals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `withdrawals` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `card` int(6) NOT NULL,
  `amount` float NOT NULL,
  `target` varchar(256) NOT NULL,
  `status` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `card` (`card`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-22 13:20:35
