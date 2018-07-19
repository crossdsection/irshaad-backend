ALTER TABLE `wv_post`  ADD `total_score` INT NOT NULL DEFAULT '0'  AFTER `longitude`,  ADD `total_upvotes` INT NOT NULL DEFAULT '0'  AFTER `total_score`;
