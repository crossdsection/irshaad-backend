ALTER TABLE `post` ADD `post_type` ENUM('court','discussion','news') NOT NULL DEFAULT 'court' AFTER `locality_id`;
