

DROP TABLE IF EXISTS `photo_album_i18n`;
DROP TABLE IF EXISTS `photo_albums`;
DROP TABLE IF EXISTS `photo_i18n`;
DROP TABLE IF EXISTS `photo_thumbnails`;
DROP TABLE IF EXISTS `photos`;


CREATE TABLE `photo_album_i18n` (
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

CREATE TABLE `photo_albums` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`parent_id` bigint(20) NOT NULL,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`published` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`lft` bigint(20) NOT NULL,
	`rght` bigint(20) NOT NULL,
	`deleted` tinyint(1) NOT NULL,
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

CREATE TABLE `photo_i18n` (
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

CREATE TABLE `photo_thumbnails` (
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

CREATE TABLE `photos` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`photo_album_id` bigint(20) NOT NULL,
	`name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`extension` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`size` bigint(20) NOT NULL,
	`width` int(10) NOT NULL,
	`height` int(10) NOT NULL,
	`mime_type` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`published` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`deleted` tinyint(1) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `photo_album_id` (`photo_album_id`),
	KEY `published` (`published`),
	KEY `deleted` (`deleted`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=InnoDB;

