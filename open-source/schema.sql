/*
 Navicat MySQL Data Transfer

 Source Server         : local
 Source Server Version : 50137
 Source Host           : localhost
 Source Database       : rockdove

 Target Server Version : 50137
 File Encoding         : utf-8

 Date: 11/05/2009 14:59:13 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `allies`
-- ----------------------------
DROP TABLE IF EXISTS `allies`;
CREATE TABLE `allies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_user` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_user` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `categories`
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_user` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_user` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `categories_to_services`
-- ----------------------------
DROP TABLE IF EXISTS `categories_to_services`;
CREATE TABLE `categories_to_services` (
  `option_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `email_addresses`
-- ----------------------------
DROP TABLE IF EXISTS `email_addresses`;
CREATE TABLE `email_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `is_valid` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
--  Table structure for `events`
-- ----------------------------
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `description` text NOT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_user` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_user` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `options_gender`
-- ----------------------------
DROP TABLE IF EXISTS `options_gender`;
CREATE TABLE `options_gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `pronoun` varchar(255) NOT NULL,
  `pronoun_possessive` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `options_language`
-- ----------------------------
DROP TABLE IF EXISTS `options_language`;
CREATE TABLE `options_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `options_payment`
-- ----------------------------
DROP TABLE IF EXISTS `options_payment`;
CREATE TABLE `options_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `options_service`
-- ----------------------------
DROP TABLE IF EXISTS `options_service`;
CREATE TABLE `options_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `wiki` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `options_tier`
-- ----------------------------
DROP TABLE IF EXISTS `options_tier`;
CREATE TABLE `options_tier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `providers`
-- ----------------------------
DROP TABLE IF EXISTS `providers`;
CREATE TABLE `providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tier_id` int(11) NOT NULL,
  `service` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `availability` text NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  `phone_landline` varchar(255) DEFAULT NULL,
  `phone_mobile` varchar(255) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_user` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_user` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `providers_to_languages`
-- ----------------------------
DROP TABLE IF EXISTS `providers_to_languages`;
CREATE TABLE `providers_to_languages` (
  `object_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `providers_to_payment`
-- ----------------------------
DROP TABLE IF EXISTS `providers_to_payment`;
CREATE TABLE `providers_to_payment` (
  `object_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `providers_to_services`
-- ----------------------------
DROP TABLE IF EXISTS `providers_to_services`;
CREATE TABLE `providers_to_services` (
  `object_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_user` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `zip_codes`
-- ----------------------------
DROP TABLE IF EXISTS `zip_codes`;
CREATE TABLE `zip_codes` (
  `ZIP` tinytext,
  `ZIPType` tinytext,
  `City` tinytext,
  `CityType` tinytext,
  `StateName` tinytext,
  `State` tinytext,
  `AreaCode` tinytext,
  `Latitude` tinytext,
  `Longitude` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

