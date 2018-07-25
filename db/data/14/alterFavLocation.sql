ALTER TABLE `wv_fav_location`  ADD `level` ENUM('city','country','locality','state') NOT NULL  AFTER `locality_id`;

ALTER TABLE `wv_fav_location` CHANGE `country_id` `country_id` INT(11) NOT NULL DEFAULT '0', CHANGE `state_id` `state_id` INT(11) NOT NULL DEFAULT '0', CHANGE `city_id` `city_id` INT(11) NOT NULL DEFAULT '0', CHANGE `locality_id` `locality_id` INT(11) NOT NULL DEFAULT '0';

ALTER TABLE `wv_fav_location` DROP `department_id`;
