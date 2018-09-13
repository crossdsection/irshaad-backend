ALTER TABLE `user` CHANGE `access_role_ids` `access_role_ids` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '[]';

ALTER TABLE `user`  ADD `about` VARCHAR(2048) NULL  AFTER `default_location_id`,  ADD `tagline` VARCHAR(128) NULL  AFTER `about`;

ALTER TABLE `user` CHANGE `about` `about` VARCHAR(2048) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '', CHANGE `tagline` `tagline` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '';

ALTER TABLE `user` CHANGE `address` `address` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
