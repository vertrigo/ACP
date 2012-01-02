/*
SQLyog Ultimate v8.82 
MySQL - 5.5.15 : Database - acp
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`u0880315_acp` /*!40100 DEFAULT CHARACTER SET utf8 */;

/*Table structure for table `bagreports` */

DROP TABLE IF EXISTS `bagreports`;

CREATE TABLE `bagreports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `charid` int(11) unsigned NOT NULL,
  `charname` varchar(30) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `theme` varchar(50) NOT NULL,
  `datewrite` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `report` longtext,
  `status` tinyint(3) DEFAULT NULL,
  `adminnote` longtext,
  `thanks` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `bagreports` */

/*Table structure for table `events` */

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `description` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `events` */

insert  into `events`(`id`,`description`) values (16,'На арене Гурубаши появляется странная конструкция из ящиков. В самом верху которой, располагается сундук с призами. \r\n\r\nВаша цель - допрыгать вверх по ящикам до сундука и забрать приз.');

/*Table structure for table `links` */

DROP TABLE IF EXISTS `links`;

CREATE TABLE `links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `linkname` varchar(50) NOT NULL,
  `linkstr` varchar(250) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `gmlevel` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `links` */

insert  into `links`(`id`,`linkname`,`linkstr`,`image`,`gmlevel`) values (1,'WOWHead','http://ru.wowhead.com','images/links/wowhead.gif',0),(2,'RU-Mangos','http://ru-mangos.ru','images/links/rumangos.gif',2),(3,'YTDB','http://www.ytdb.ru','images/links/ytdb.gif',3);

/*Table structure for table `log` */

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата',
  `ip` varchar(15) NOT NULL COMMENT 'ип',
  `account` int(11) unsigned NOT NULL COMMENT 'акк',
  `character` int(11) unsigned DEFAULT NULL COMMENT 'чар',
  `mode` tinyint(3) unsigned NOT NULL COMMENT 'что делали',
  `email` varchar(100) DEFAULT NULL COMMENT 'емайл',
  `resultat` longtext COMMENT 'изменили на',
  `note` longtext COMMENT 'описание',
  `old_data` longtext,
  `realmd` int(11) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `log` */

/*Table structure for table `login_failed` */

DROP TABLE IF EXISTS `login_failed`;

CREATE TABLE `login_failed` (
  `ip` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `login_failed` */

/*Table structure for table `mail` */

DROP TABLE IF EXISTS `mail`;

CREATE TABLE `mail` (
  `random` varchar(40) NOT NULL,
  `account` double DEFAULT NULL,
  `email` blob,
  `character` double DEFAULT NULL,
  `mode` tinyint(4) DEFAULT NULL,
  `distination` double DEFAULT NULL,
  `requere_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`random`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mail` */

/*Table structure for table `news` */

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` longtext,
  `text` longtext,
  `status` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `news` */

insert  into `news`(`id`,`date`,`title`,`text`,`status`) values (1,'2011-09-19 10:34:15','От разработчика.','<p style=\"text-align: center;\"><img style=\"border: 0pt none; vertical-align: middle;\" src=\"images/other/ok.png\" alt=\"\" /></p>\r\n<p style=\"text-align: center;\"><span style=\"font-size: small;\"><strong>Панель управления учетной записью ACP успешно установлена.</strong></span></p>',0);

/*Table structure for table `static` */

DROP TABLE IF EXISTS `static`;

CREATE TABLE `static` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `menutitle` varchar(15) NOT NULL,
  `text` longtext,
  `type` tinyint(3) unsigned DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `static` */

insert  into `static`(`id`,`title`,`menutitle`,`text`,`type`,`date`) values (1,'Правила сервера','Правила','<p>Здесь надо поместить правила.</p>',0,'2010-05-28 21:04:49');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
