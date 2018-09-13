ALTER TABLE `post` DROP `cat_id`;
ALTER TABLE `post` DROP `subcat_id`;
ALTER TABLE `post` DROP `posttime`;

ALTER TABLE `post` CHANGE `filelink` `filejson` VARCHAR(512) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `post` ADD `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `locality_id`, ADD `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created`;


