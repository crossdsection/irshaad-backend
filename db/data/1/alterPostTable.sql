ALTER TABLE `wv_post` DROP `cat_id`;
ALTER TABLE `wv_post` DROP `subcat_id`;
ALTER TABLE `wv_post` DROP `posttime`;

ALTER TABLE `wv_post` CHANGE `filelink` `filejson` VARCHAR(512) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `wv_post` ADD `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `locality_id`, ADD `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created`;


