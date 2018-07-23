ALTER TABLE `wv_user` CHANGE `gender` `gender` ENUM('male','female','transgender') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `wv_user` ADD `date_of_birth` DATETIME NULL AFTER `status`;
