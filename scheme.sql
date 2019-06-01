SET FOREIGN_KEY_CHECKS = 0;
CREATE DATABASE IF NOT EXISTS `my_app`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `role_details_roles`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `acos_role_details`;
DROP TABLE IF EXISTS `role_details`;
DROP TABLE IF EXISTS `aros_acos`;
DROP TABLE IF EXISTS `aros`;
DROP TABLE IF EXISTS `acos`;
DROP TABLE IF EXISTS `sessions`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `sessions` (
  `id` char(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data` blob,
  `expires` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_acos_lft_rght` (`lft`,`rght`),
  KEY `idx_acos_alias` (`alias`)
);

CREATE TABLE `aros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_aros_lft_rght` (`lft`,`rght`),
  KEY `idx_aros_alias` (`alias`)
);

CREATE TABLE `aros_acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aro_id` int(11) NOT NULL,
  `aco_id` int(11) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `aro_aco_id` (`aro_id`,`aco_id`),
  KEY `idx_aco_id` (`aco_id`)
);

CREATE TABLE `role_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `created_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `deleted_at` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `acos_role_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aco_id` int(11) NOT NULL,
  `role_detail_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aco_id` (`aco_id`,`role_detail_id`)
);

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `created_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `deleted_at` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `role_details_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `role_detail_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_id` (`role_id`,`role_detail_id`)
);

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `deleted_at` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

BEGIN;

INSERT INTO role_details (`id`,`name`,`description`) VALUES
(1,'RD 1',''),
(2,'RD 2',''),
(3,'RD 3',''),
(4,'RD 4','');

INSERT INTO roles (`id`,`name`,`description`) VALUES
(1,'全権限','for develop'),
(2,'Role 2','');

INSERT INTO acos (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 2);

INSERT INTO aros (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Roles', 1, NULL, 1, 2),
(2, NULL, 'Roles', 2, NULL, 3, 4);

INSERT INTO aros_acos (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, 1, 1, 1, 1);

INSERT INTO users (`id`,`name`,`description`,`password`,`role_id`) VALUES
(1,'user01','','$2y$10$CVFCqsDnNQi7xwDuamDvWOqiZxv79oFo6oxDFiktixvZs1KWITaRK',1),
(2,'user02','','$2y$10$CVFCqsDnNQi7xwDuamDvWOqiZxv79oFo6oxDFiktixvZs1KWITaRK',2);


COMMIT;