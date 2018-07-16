DROP TABLE wv_activitylog;

CREATE TABLE `worldvoting`.`wv_activitylog` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT , 
    `user_id` INT(11) NOT NULL , 
    `post_id` INT(11) NOT NULL , 
    `upvote` BOOLEAN NOT NULL DEFAULT FALSE , 
    `downvote` BOOLEAN NOT NULL DEFAULT FALSE , 
    `bookmark` BOOLEAN NOT NULL DEFAULT FALSE , 
    `shares` INT(11) NOT NULL DEFAULT 0 , 
    `flag` BIT(1) NOT NULL DEFAULT 0 , 
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `wv_activitylog` ADD `eyewitness` BOOLEAN NOT NULL AFTER `flag`;

ALTER TABLE `wv_activitylog` CHANGE `flag` `flag` BOOLEAN NOT NULL DEFAULT FALSE;

ALTER TABLE `wv_activitylog` ADD UNIQUE `unique_index`(`user_id`, `post_id`);
