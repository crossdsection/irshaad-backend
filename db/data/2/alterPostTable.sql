ALTER TABLE `wv_post` CHANGE `ministry_id` `department_id` INT(10) NOT NULL;

ALTER TABLE `wv_post` CHANGE `total_likes` `total_likes` INT(10) NOT NULL DEFAULT '0';
ALTER TABLE `wv_post` CHANGE `total_comments` `total_comments` INT(10) NOT NULL DEFAULT '0';

