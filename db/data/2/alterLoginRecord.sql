ALTER TABLE `wv_login_record` ADD `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `longitude`, ADD `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created`;
