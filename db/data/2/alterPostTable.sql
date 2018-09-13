ALTER TABLE `post` CHANGE `ministry_id` `department_id` INT(10) NOT NULL;

ALTER TABLE `post` CHANGE `total_likes` `total_likes` INT(10) NOT NULL DEFAULT '0';
ALTER TABLE `post` CHANGE `total_comments` `total_comments` INT(10) NOT NULL DEFAULT '0';
ALTER TABLE `post` CHANGE `location` `location` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `post` CHANGE `poststatus` `poststatus` TINYINT(1) NOT NULL DEFAULT '1';
ALTER TABLE `post` DROP `type_flag`;
ALTER TABLE `post` CHANGE `details` `details` VARCHAR(512) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
