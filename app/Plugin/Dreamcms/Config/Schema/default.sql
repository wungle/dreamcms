

DROP TABLE IF EXISTS `dreamcms`.`acos`;
DROP TABLE IF EXISTS `dreamcms`.`admins`;
DROP TABLE IF EXISTS `dreamcms`.`aros`;
DROP TABLE IF EXISTS `dreamcms`.`aros_acos`;
DROP TABLE IF EXISTS `dreamcms`.`cms_menus`;
DROP TABLE IF EXISTS `dreamcms`.`file_i18n`;
DROP TABLE IF EXISTS `dreamcms`.`file_types`;
DROP TABLE IF EXISTS `dreamcms`.`files`;
DROP TABLE IF EXISTS `dreamcms`.`groups`;
DROP TABLE IF EXISTS `dreamcms`.`icons`;
DROP TABLE IF EXISTS `dreamcms`.`languages`;
DROP TABLE IF EXISTS `dreamcms`.`settings`;
DROP TABLE IF EXISTS `dreamcms`.`temp_dirs`;
DROP TABLE IF EXISTS `dreamcms`.`thumbnail_types`;
DROP TABLE IF EXISTS `dreamcms`.`web_menu_i18n`;
DROP TABLE IF EXISTS `dreamcms`.`web_menus`;


CREATE TABLE `dreamcms`.`acos` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) DEFAULT NULL,
	`model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`foreign_key` int(10) DEFAULT NULL,
	`alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`lft` int(10) DEFAULT NULL,
	`rght` int(10) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`admins` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`group_id` bigint(20) NOT NULL,
	`username` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`password` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`real_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`last_login` datetime DEFAULT NULL,
	`last_login_ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`active` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `username_UNIQUE` (`username`),
	UNIQUE KEY `email_UNIQUE` (`email`),
	KEY `deleted` (`deleted`),
	KEY `group_id` (`group_id`),
	KEY `active` (`active`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`aros` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) DEFAULT NULL,
	`model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`foreign_key` int(10) DEFAULT NULL,
	`alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`lft` int(10) DEFAULT NULL,
	`rght` int(10) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`aros_acos` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`aro_id` int(10) NOT NULL,
	`aco_id` int(10) NOT NULL,
	`_create` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0' NOT NULL,
	`_read` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0' NOT NULL,
	`_update` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0' NOT NULL,
	`_delete` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0' NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `ARO_ACO_KEY` (`aro_id`, `aco_id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`cms_menus` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) NOT NULL,
	`icon` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`published` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`lft` bigint(20) NOT NULL,
	`rght` bigint(20) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `url_UNIQUE` (`url`),
	KEY `parent_id` (`parent_id`),
	KEY `deleted` (`deleted`),
	KEY `lft` (`lft`),
	KEY `rght` (`rght`),
	KEY `tree` (`lft`, `rght`),
	KEY `published` (`published`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`file_i18n` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`locale` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`foreign_key` int(10) NOT NULL,
	`field` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `locale` (`locale`),
	KEY `model` (`model`),
	KEY `row_id` (`foreign_key`),
	KEY `field` (`field`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`file_types` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) NOT NULL,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`published` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`lft` bigint(20) NOT NULL,
	`rght` bigint(20) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `parent_id` (`parent_id`),
	KEY `published` (`published`),
	KEY `deleted` (`deleted`),
	KEY `lft` (`lft`),
	KEY `rght` (`rght`),
	KEY `tree` (`lft`, `rght`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`files` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`file_type_id` bigint(20) NOT NULL,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`priority` int(10) NOT NULL,
	`filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`extension` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`size` bigint(20) NOT NULL,
	`mime_type` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`category` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`width` int(10) NOT NULL,
	`height` int(10) NOT NULL,
	`published` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `file_type_id_idx` (`file_type_id`),
	KEY `priority` (`priority`),
	KEY `category` (`category`),
	KEY `published` (`published`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`groups` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `name_UNIQUE` (`name`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`icons` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`languages` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `name` (`name`),
	KEY `locale` (`locale`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`settings` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `name_UNIQUE` (`name`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`temp_dirs` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`path` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`lifespan` bigint(20) NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `path_UNIQUE` (`path`),
	KEY `path` (`path`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`thumbnail_types` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`width` int(10) NOT NULL,
	`height` int(10) NOT NULL,
	`method` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `name_UNIQUE` (`name`),
	KEY `name` (`name`),
	KEY `method` (`method`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`web_menu_i18n` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`locale` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`foreign_key` int(10) NOT NULL,
	`field` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `locale` (`locale`),
	KEY `model` (`model`),
	KEY `row_id` (`foreign_key`),
	KEY `field` (`field`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `dreamcms`.`web_menus` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) NOT NULL,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`priority` int(10) NOT NULL,
	`published` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`lft` bigint(20) NOT NULL,
	`rght` bigint(20) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `url_UNIQUE` (`url`),
	KEY `parent_id` (`parent_id`),
	KEY `published` (`published`),
	KEY `deleted` (`deleted`),
	KEY `lft` (`lft`),
	KEY `rght` (`rght`),
	KEY `tree` (`lft`, `rght`),
	KEY `priority` (`priority`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

