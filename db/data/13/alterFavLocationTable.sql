ALTER TABLE `fav_location`  ADD `latitude` VARCHAR(50) NOT NULL DEFAULT '0'  AFTER `locality_id`,  ADD `longitude` VARCHAR(50) NOT NULL DEFAULT '0'  AFTER `latitude`;
