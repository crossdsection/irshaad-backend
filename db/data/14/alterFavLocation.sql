ALTER TABLE `wv_fav_location`  ADD `level` ENUM('city','country','locality','state') NOT NULL  AFTER `locality_id`;
