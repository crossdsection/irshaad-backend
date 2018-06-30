ALTER TABLE `wv_localities`  ADD `latitude` INT NOT NULL DEFAULT '0'  AFTER `active`,  ADD `longitude` INT NOT NULL DEFAULT '0'  AFTER `latitude`;
