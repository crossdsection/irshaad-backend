ALTER TABLE `wv_post` CHANGE `department_id` `department_id` INT(11) NOT NULL DEFAULT '0', CHANGE `country_id` `country_id` INT(11) NOT NULL DEFAULT '0', CHANGE `state_id` `state_id` INT(11) NOT NULL DEFAULT '0', CHANGE `city_id` `city_id` INT(11) NOT NULL DEFAULT '0', CHANGE `locality_id` `locality_id` INT(11) NOT NULL DEFAULT '0';

ALTER TABLE `wv_post` ADD `anonymous` TINYINT(1) NOT NULL DEFAULT '0' AFTER `poststatus`;
