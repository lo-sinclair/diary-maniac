/*
Navicat MySQL Data Transfer

Source Server         : lustrum_main
Source Server Version : 50170
Source Host           : localhost:3306
Source Database       : lustrum_diarymaniac

Target Server Type    : MYSQL
Target Server Version : 50170
File Encoding         : 65001

Date: 2013-10-13 18:31:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `authors`
-- ----------------------------
DROP TABLE IF EXISTS `authors`;
CREATE TABLE `authors` (
  `author_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) DEFAULT NULL,
  `fullname` varchar(128) DEFAULT NULL,
  `blog_resource` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of authors
-- ----------------------------

-- ----------------------------
-- Table structure for `comments`
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `author` varchar(128) NOT NULL,
  `body` longtext NOT NULL,
  `postdate` datetime NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comments
-- ----------------------------

-- ----------------------------
-- Table structure for `diaries`
-- ----------------------------
DROP TABLE IF EXISTS `diaries`;
CREATE TABLE `diaries` (
  `diary_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `blog_resource` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`diary_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of diaries
-- ----------------------------

-- ----------------------------
-- Table structure for `entries`
-- ----------------------------
DROP TABLE IF EXISTS `entries`;
CREATE TABLE `entries` (
  `entry_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `diary_id` int(11) NOT NULL,
  `inner_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(256) DEFAULT NULL,
  `body` longtext,
  `url` varchar(255) DEFAULT NULL,
  `postdate` datetime NOT NULL,
  `update` datetime DEFAULT NULL,
  `comments_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`entry_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of entries
-- ----------------------------

-- ----------------------------
-- Table structure for `parameters`
-- ----------------------------
DROP TABLE IF EXISTS `parameters`;
CREATE TABLE `parameters` (
  `param_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `param_name` varchar(128) NOT NULL,
  `param_value` varchar(256) NOT NULL,
  `update` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`param_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of parameters
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(80) NOT NULL,
  `password` varchar(128) NOT NULL,
  `blog_resource` varchar(128) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `login` (`login`,`blog_resource`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'lyn)(browser', 'd2d48c70f283f81a67c031e877fae4f5', 'diary', '1');
INSERT INTO `users` VALUES ('2', 'loise', 'd2d48c70f283f81a67c031e877fae4f5', 'diary', '1');
INSERT INTO `users` VALUES ('3', 'loise', 'd2d48c70f283f81a67c031e877fae4f5', 'lj', '1');
INSERT INTO `users` VALUES ('4', 'ezen ', 'ae7a501bd50ee4e0cb0d444478c5ea34', 'diary', '1');
