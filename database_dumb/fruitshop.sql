/*
SQLyog Community v13.1.1 (64 bit)
MySQL - 10.3.13-MariaDB : Database - fruitshop_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fruitshop_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `fruitshop_db`;

/*Table structure for table `account` */

DROP TABLE IF EXISTS `account`;

CREATE TABLE `account` (
  `email` varchar(64) NOT NULL,
  `password` char(128) NOT NULL,
  `full_name` varchar(64) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `image` varchar(128) NOT NULL,
  `owner` tinyint(1) NOT NULL DEFAULT 0,
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `account` */

insert  into `account`(`email`,`password`,`full_name`,`description`,`image`,`owner`,`last_login`) values 
('antonius09@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$MEE2VmUwakxONVNBTlEvdg$5dwx53ot8u9Nn7OqIjGJZBcAGpqK+e5rmBxgmvbZJBw','aku dan kamu','keren','images\\\\default.jpg',0,'2019-12-12 14:18:59'),
('juandaantonius08@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$QmNvNy42TTJUQWlTcC9JRw$s/jgK7N6tzqDrKfLpNqJgc6mANCSJmK4FaPuhWPij1E','Juanda Pakpahan','AMan','images\\\\default.jpg',0,'2019-10-22 01:17:29'),
('juandapapak08@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$c1NRaWd3YUxidk1yRHNBQw$qsKwqP80ORUBzOXErKnNPPxLHYu2obhJ2o+NTOQ4O5U','Juanda Pakpahan','mantap\r\n','images\\\\default.jpg',0,'2019-10-22 10:08:40'),
('jujuju@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$cWxtYS9mZ2hvclZDdndDdA$lj74RomsRqvTf9qYzSnmdFLZgLL0YAfqGtFSYvrmCRk','asd','tampan','images\\\\default.jpg',0,'2019-10-22 12:51:14');

/*Table structure for table `fruit` */

DROP TABLE IF EXISTS `fruit`;

CREATE TABLE `fruit` (
  `id` char(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `latin` varchar(64) NOT NULL,
  `color` varchar(64) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `image` varchar(128) NOT NULL,
  `price` float(4,2) unsigned NOT NULL DEFAULT 0.00,
  `stock` int(4) unsigned NOT NULL DEFAULT 0,
  `added_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `fruit` */

insert  into `fruit`(`id`,`name`,`latin`,`color`,`description`,`image`,`price`,`stock`,`added_at`) values 
('0e21b9e56243d2915bd56d09034cecf5a4e20c86a928cb63623acfb83494217c','Grape','Vitis vinifera','Green, Purple, Red, & White',NULL,'images/grape.jpg',1.00,0,'2018-09-09 20:24:13'),
('77d04b1ea52cc7145049407abfaf761b76af78f26ef5c5d451a3f2f190c11ce5','Cherry','Prunus avium','Red',NULL,'images/cherry.jpg',1.00,0,'2018-09-20 20:24:18'),
('ca7baa9f5a65d045756e291728eb0df6a9da8d80bdcf397284d48b8cd8746112','Apple','Malus','Red & Green',NULL,'images/apple.jpg',1.00,0,'2018-09-04 20:24:22'),
('fdc8e69bc9ce41b3bdc72163c88265afefe1931f082221a8982f3cd75de8c1dc','Strawberry','Fragaria','Red & Green',NULL,'images/strawberry.jpg',1.00,0,'2018-10-03 20:24:28');

/*Table structure for table `fruit_voting` */

DROP TABLE IF EXISTS `fruit_voting`;

CREATE TABLE `fruit_voting` (
  `id` varchar(64) NOT NULL,
  `voted_fruit` varchar(64) NOT NULL,
  `voted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `voted_fruit` (`voted_fruit`),
  CONSTRAINT `fruit_voting_ibfk_1` FOREIGN KEY (`voted_fruit`) REFERENCES `fruit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `fruit_voting` */

/*Table structure for table `purchasing` */

DROP TABLE IF EXISTS `purchasing`;

CREATE TABLE `purchasing` (
  `id` char(64) NOT NULL,
  `buyer` varchar(64) NOT NULL,
  `total` float(6,2) unsigned NOT NULL DEFAULT 0.00,
  `payed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `issued_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `buyer` (`buyer`),
  CONSTRAINT `purchasing_ibfk_1` FOREIGN KEY (`buyer`) REFERENCES `account` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchasing` */

/*Table structure for table `purchasing_detail` */

DROP TABLE IF EXISTS `purchasing_detail`;

CREATE TABLE `purchasing_detail` (
  `purchasing` varchar(64) NOT NULL,
  `fruit` varchar(64) NOT NULL,
  `amount` int(2) unsigned NOT NULL DEFAULT 0,
  `price` float(4,2) unsigned NOT NULL DEFAULT 0.00,
  `discount` float(4,2) unsigned NOT NULL DEFAULT 0.00,
  `placed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`purchasing`,`fruit`),
  KEY `fruit` (`fruit`),
  CONSTRAINT `purchasing_detail_ibfk_1` FOREIGN KEY (`purchasing`) REFERENCES `purchasing` (`id`),
  CONSTRAINT `purchasing_detail_ibfk_2` FOREIGN KEY (`fruit`) REFERENCES `fruit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchasing_detail` */

/*Table structure for table `status` */

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id` char(64) NOT NULL,
  `text` varchar(128) NOT NULL,
  `published_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `status` */

insert  into `status`(`id`,`text`,`published_at`) values 
('27c04c1931b3c63ec265b7c0d3368b19e4ca9d9b9291811ffb0b18c7c2bb23e5','Learning new stuff, PHP. It looks cool.','2018-10-02 21:36:10'),
('49fd328e195cebe329441c6eef8703cdeb737d2fbe4146bf8599665f9c32ceea','Medoo is in the house.','2018-10-03 11:39:43'),
('7bd597c05ade9899bdbd7f3450341d6c6963bd559b6092e25c3a634d3ecec39e','Nice lah pokoknya','2019-12-07 13:18:40'),
('9fd6b1051aee994b27ad3b11609381e810e3b0c60ce7acf2df41fe1a0006f4ef','It works like a charm!','2018-10-03 07:46:35'),
('b8a0565618c2c99eac41732350dc96e9cf49754b4cd6ce67cf5798742c91029a','Whooa!','2018-10-03 20:06:04'),
('c5ea827236309dc6fcdac8f7e995d701d1362820c5bff229b0bec0fb6d05c071','gas cuy','2019-10-28 10:21:25'),
('d335bb722bcef6b995d1d4bae4a8456baa7d5d058791dda99fb704606f50028c','Starting the day with HTML and CSS. I managed to develop some nice pages. :)','2018-09-06 12:14:48'),
('fb17a21793037ef87c93164294a6fa81e9871d6d202cbae2de7da85b5f6d2854','I cannot resist the beauty of JavaScript and jQuery. Really awesome.','2018-09-12 08:45:24');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
