/*
Navicat MySQL Data Transfer

Source Server         : 虚拟机vmware_mysql
Source Server Version : 50621
Source Host           : 192.168.163.128:3306
Source Database       : login

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2017-11-01 18:24:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pre_oauth_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `pre_oauth_access_tokens`;
CREATE TABLE `pre_oauth_access_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `access_token_id` varchar(255) NOT NULL,
  `expire_time` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `client_id` int(11) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `access_token_id` (`access_token_id`) USING BTREE,
  KEY `expire_time` (`expire_time`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `client_id` (`client_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_oauth_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for pre_oauth_auth_codes
-- ----------------------------
DROP TABLE IF EXISTS `pre_oauth_auth_codes`;
CREATE TABLE `pre_oauth_auth_codes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `client_id` int(11) unsigned NOT NULL,
  `expire_time` int(11) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_oauth_auth_codes
-- ----------------------------
INSERT INTO `pre_oauth_auth_codes` VALUES ('1', '157efccba50e2dd2eafc26c5837e9c68b24b4889f1f7d30f19d124be807970b12fa685ecd0a8f56e', '1', '1', '1509535037', '0', '0');
INSERT INTO `pre_oauth_auth_codes` VALUES ('2', 'b3bc98f91305b8220cab417d3ef26ae6b02dc890fc4d863223525304db0fbe4c4a893ffdae7b9373', '1', '1', '1509535121', '0', '0');
INSERT INTO `pre_oauth_auth_codes` VALUES ('3', '5d5ffa113bacda12f9752c5561682540d250c0e54c9a5ee89d91fd8c82a9d33051dc2efdae8508f8', '1', '1', '1509535160', '0', '0');
INSERT INTO `pre_oauth_auth_codes` VALUES ('4', '1e4696bed0322437f706749931c76889164d0285e30b02770b3058a8590f191139e8f85988772192', '1', '1', '1509535190', '0', '0');
INSERT INTO `pre_oauth_auth_codes` VALUES ('5', '93f7ea3b3cc009559c018d5db83719652d532965be5a534ee2a42b06eba149d3799b66ccd614b51b', '1', '1', '1509535344', '0', '0');
INSERT INTO `pre_oauth_auth_codes` VALUES ('6', 'e68006bea2df4d0bf233cda99ee34ab566879e97e78712cd8281d9ba39802605825e03618487309c', '1', '1', '1509535359', '0', '0');
INSERT INTO `pre_oauth_auth_codes` VALUES ('7', '575daf8ee6c42e6412747028fdd552874c1f6f2cafa2963b826b76f5022162e164f1b7ef4632a0ba', '1', '1', '1509535411', '0', '0');
INSERT INTO `pre_oauth_auth_codes` VALUES ('8', '5bdd427914c7d9b25b0262f52478a60e247f58f35d6c09fc56fb2ccb08d694083dddcffab2f08fe9', '1', '1', '1509535437', '0', '0');

-- ----------------------------
-- Table structure for pre_oauth_client_grants
-- ----------------------------
DROP TABLE IF EXISTS `pre_oauth_client_grants`;
CREATE TABLE `pre_oauth_client_grants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) unsigned NOT NULL,
  `grant_id` int(11) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `grant_id` (`grant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_oauth_client_grants
-- ----------------------------
INSERT INTO `pre_oauth_client_grants` VALUES ('2', '1', '1', '0', '0');

-- ----------------------------
-- Table structure for pre_oauth_client_scopes
-- ----------------------------
DROP TABLE IF EXISTS `pre_oauth_client_scopes`;
CREATE TABLE `pre_oauth_client_scopes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) unsigned NOT NULL,
  `scope_id` int(11) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `scope_id` (`scope_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_oauth_client_scopes
-- ----------------------------

-- ----------------------------
-- Table structure for pre_oauth_clients
-- ----------------------------
DROP TABLE IF EXISTS `pre_oauth_clients`;
CREATE TABLE `pre_oauth_clients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) NOT NULL,
  `secret` varchar(40) NOT NULL,
  `name` varchar(255) NOT NULL,
  `redirect_uri` varchar(512) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_id` (`client_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_oauth_clients
-- ----------------------------
INSERT INTO `pre_oauth_clients` VALUES ('1', 'client1', 'client1_secret', 'client1_name', 'http://sysyii.jhj.com/login/default/oauth2', '0', '0');

-- ----------------------------
-- Table structure for pre_oauth_grants
-- ----------------------------
DROP TABLE IF EXISTS `pre_oauth_grants`;
CREATE TABLE `pre_oauth_grants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_oauth_grants
-- ----------------------------
INSERT INTO `pre_oauth_grants` VALUES ('1', 'authorization_code', '1464246891', '1464246891');
INSERT INTO `pre_oauth_grants` VALUES ('2', 'client_credentials', '1464246891', '1464246891');
INSERT INTO `pre_oauth_grants` VALUES ('3', 'password', '1464246891', '1464246891');
INSERT INTO `pre_oauth_grants` VALUES ('4', 'refresh_token', '1464246891', '1464246891');

-- ----------------------------
-- Table structure for pre_oauth_refresh_tokens
-- ----------------------------
DROP TABLE IF EXISTS `pre_oauth_refresh_tokens`;
CREATE TABLE `pre_oauth_refresh_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `access_token_id` int(1) NOT NULL,
  `expire_time` int(11) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`) USING BTREE,
  KEY `access_token_id` (`access_token_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_oauth_refresh_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for pre_oauth_scopes
-- ----------------------------
DROP TABLE IF EXISTS `pre_oauth_scopes`;
CREATE TABLE `pre_oauth_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_oauth_scopes
-- ----------------------------
INSERT INTO `pre_oauth_scopes` VALUES ('2', 'scope1', 'scope1_name', '0', '0');

-- ----------------------------
-- Table structure for pre_users
-- ----------------------------
DROP TABLE IF EXISTS `pre_users`;
CREATE TABLE `pre_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pre_users
-- ----------------------------
INSERT INTO `pre_users` VALUES ('1', 'test', '$2y$13$skFFKGhmYjUtHdo/BWHiGeQ/i1Mr1oDgqSjuzdVwe58z1S0mo4Sg2', '0', '0');
