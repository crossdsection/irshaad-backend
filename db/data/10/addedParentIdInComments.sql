ALTER TABLE `wv_comments` ADD `parent_id` INT NOT NULL DEFAULT '0' AFTER `post_id`;
