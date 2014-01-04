

DROP TABLE IF EXISTS `thumbnails`;

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

