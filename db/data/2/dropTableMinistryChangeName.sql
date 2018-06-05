DROP TABLE `wv_ministry`;

CREATE TABLE `wv_departments` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 for world & 1 for country & 2 for state & 3 for city',
  `head_profilepic` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `wv_departments` ADD PRIMARY KEY( `id`);
ALTER TABLE `wv_departments` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
