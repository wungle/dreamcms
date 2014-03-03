

DROP TABLE IF EXISTS `acos`;
DROP TABLE IF EXISTS `admins`;
DROP TABLE IF EXISTS `aros`;
DROP TABLE IF EXISTS `aros_acos`;
DROP TABLE IF EXISTS `cms_logs`;
DROP TABLE IF EXISTS `cms_menus`;
DROP TABLE IF EXISTS `file_i18n`;
DROP TABLE IF EXISTS `file_types`;
DROP TABLE IF EXISTS `files`;
DROP TABLE IF EXISTS `groups`;
DROP TABLE IF EXISTS `icons`;
DROP TABLE IF EXISTS `languages`;
DROP TABLE IF EXISTS `page_attachment_thumbnails`;
DROP TABLE IF EXISTS `page_attachment_types`;
DROP TABLE IF EXISTS `page_attachments`;
DROP TABLE IF EXISTS `page_i18n`;
DROP TABLE IF EXISTS `page_types`;
DROP TABLE IF EXISTS `pages`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `tagged`;
DROP TABLE IF EXISTS `tags`;
DROP TABLE IF EXISTS `temp_dirs`;
DROP TABLE IF EXISTS `thumbnail_types`;
DROP TABLE IF EXISTS `thumbnails`;
DROP TABLE IF EXISTS `web_menu_i18n`;
DROP TABLE IF EXISTS `web_menus`;


CREATE TABLE `acos` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) DEFAULT NULL,
	`model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`foreign_key` int(10) DEFAULT NULL,
	`alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`lft` int(10) DEFAULT NULL,
	`rght` int(10) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `admins` (
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

CREATE TABLE `aros` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) DEFAULT NULL,
	`model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`foreign_key` int(10) DEFAULT NULL,
	`alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`lft` int(10) DEFAULT NULL,
	`rght` int(10) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `aros_acos` (
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

CREATE TABLE `cms_logs` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`admin` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`controller` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`model` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`foreign_key` bigint(20) NOT NULL,
	`fields` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`operation` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`data_before` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`data_after` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `controller` (`controller`),
	KEY `model` (`model`),
	KEY `foreign_key` (`foreign_key`),
	KEY `operation` (`operation`),
	KEY `common_query` (`model`, `foreign_key`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `cms_menus` (
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

CREATE TABLE `file_i18n` (
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

CREATE TABLE `file_types` (
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

CREATE TABLE `files` (
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

CREATE TABLE `groups` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `name_UNIQUE` (`name`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `icons` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `languages` (
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

CREATE TABLE `page_attachment_thumbnails` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`thumbnail_type_id` bigint(20) NOT NULL,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`foreign_key` bigint(20) NOT NULL,
	`field` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`locale` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`width` int(10) NOT NULL,
	`height` int(10) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `thumbnail_type_id` (`thumbnail_type_id`),
	KEY `name` (`name`),
	KEY `model` (`model`),
	KEY `foreign_key` (`foreign_key`),
	KEY `field` (`field`),
	KEY `locale` (`locale`),
	KEY `common_query1` (`model`, `foreign_key`, `field`, `locale`),
	KEY `common_query2` (`thumbnail_type_id`, `model`, `foreign_key`, `field`, `locale`),
	KEY `common_query3` (`model`, `foreign_key`, `field`),
	KEY `common_query4` (`thumbnail_type_id`, `model`, `foreign_key`, `field`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `page_attachment_types` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) NOT NULL,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`lft` bigint(20) NOT NULL,
	`rght` bigint(20) NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `parent_id` (`parent_id`),
	KEY `lft` (`lft`),
	KEY `rght` (`rght`),
	KEY `tree` (`lft`, `rght`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `page_attachments` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`page_id` bigint(20) NOT NULL,
	`page_attachment_type_id` bigint(20) NOT NULL,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`extension` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`size` bigint(20) NOT NULL,
	`mime_type` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`category` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`width` int(10) NOT NULL,
	`height` int(10) NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `page_id` (`page_id`),
	KEY `page_attachment_type_id` (`page_attachment_type_id`),
	KEY `category` (`category`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `page_i18n` (
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

CREATE TABLE `page_types` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) NOT NULL,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`layout` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`published` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`lft` bigint(20) NOT NULL,
	`rght` bigint(20) NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `parent_id` (`parent_id`),
	KEY `published` (`published`),
	KEY `lft` (`lft`),
	KEY `rght` (`rght`),
	KEY `tree` (`lft`, `rght`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `pages` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`page_type_id` bigint(20) NOT NULL,
	`path` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`description` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`tags` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`read_count` bigint(20) NOT NULL,
	`published` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`published_at` datetime NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`),
	KEY `page_type_id` (`page_type_id`),
	KEY `path` (`path`),
	KEY `tags` (`tags`(255)),
	KEY `published` (`published`),
	KEY `published_at` (`published_at`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `settings` (
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

CREATE TABLE `tagged` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`tag_id` bigint(20) DEFAULT NULL,
	`model` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`model_id` bigint(20) DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `tag_id` (`tag_id`),
	KEY `model` (`model`),
	KEY `model_id` (`model_id`),
	KEY `common_query1` (`tag_id`, `model`, `model_id`),
	KEY `common_query2` (`model`, `model_id`),
	KEY `common_query3` (`tag_id`, `model`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `tags` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`name` varchar(160) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`slug` varchar(160) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`count` bigint(20) DEFAULT 0 NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `temp_dirs` (
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

CREATE TABLE `thumbnail_types` (
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

CREATE TABLE `thumbnails` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`thumbnail_type_id` bigint(20) NOT NULL,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`foreign_key` bigint(20) NOT NULL,
	`field` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`locale` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`width` int(10) NOT NULL,
	`height` int(10) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `thumbnail_type_id` (`thumbnail_type_id`),
	KEY `name` (`name`),
	KEY `model` (`model`),
	KEY `foreign_key` (`foreign_key`),
	KEY `field` (`field`),
	KEY `locale` (`locale`),
	KEY `common_query1` (`model`, `foreign_key`, `field`, `locale`),
	KEY `common_query2` (`thumbnail_type_id`, `model`, `foreign_key`, `field`, `locale`),
	KEY `common_query3` (`model`, `foreign_key`, `field`),
	KEY `common_query4` (`thumbnail_type_id`, `model`, `foreign_key`, `field`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

CREATE TABLE `web_menu_i18n` (
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

CREATE TABLE `web_menus` (
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
	KEY `url` (`url`),
	KEY `parent_id` (`parent_id`),
	KEY `published` (`published`),
	KEY `deleted` (`deleted`),
	KEY `lft` (`lft`),
	KEY `rght` (`rght`),
	KEY `tree` (`lft`, `rght`),
	KEY `priority` (`priority`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

