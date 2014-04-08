CREATE TABLE `ci_sessions` (
  `session_id` VARCHAR(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` VARCHAR(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` VARCHAR(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` TEXT COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ckeditor` (
  `ckeditor_id` INT(10) NOT NULL AUTO_INCREMENT,
  `content` TEXT COLLATE utf8_unicode_ci,
  PRIMARY KEY (`ckeditor_id`)
) ENGINE=MYISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `email` (
  `email_id` INT(11) NOT NULL AUTO_INCREMENT,
  `recipient` VARCHAR(45) COLLATE utf8_unicode_ci NOT NULL,
  `headers` TEXT COLLATE utf8_unicode_ci,
  `subject` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` TEXT COLLATE utf8_unicode_ci,
  `send_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`email_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `module` (
  `module_id` INT(10) NOT NULL AUTO_INCREMENT,
  `page_id` INT(10) DEFAULT NULL,
  `class_name` VARCHAR(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` INT(10) DEFAULT NULL,
  `settings` TEXT COLLATE utf8_unicode_ci,
  `content_area` VARCHAR(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=MYISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `page` (
  `page_id` INT(10) NOT NULL AUTO_INCREMENT,
  `parent_page_id` INT(10) DEFAULT '1',
  `page_title` VARCHAR(45) COLLATE utf8_unicode_ci NOT NULL,
  `page_path` VARCHAR(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template` VARCHAR(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `privileges` ENUM('1','2') COLLATE utf8_unicode_ci DEFAULT '1',
  PRIMARY KEY (`page_id`)
) ENGINE=MYISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `user` (
  `user_id` INT(10) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` VARCHAR(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` VARCHAR(256) COLLATE utf8_unicode_ci NOT NULL,
  `address` VARCHAR(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` INT(4) DEFAULT NULL,
  `city` VARCHAR(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` INT(8) DEFAULT NULL,
  `email` VARCHAR(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salt` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` ENUM('user','admin') COLLATE utf8_unicode_ci DEFAULT 'user',
  PRIMARY KEY (`user_id`)
) ENGINE=MYISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
