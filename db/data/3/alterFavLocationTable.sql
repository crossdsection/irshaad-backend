DROP TABLE `fav_location`;

CREATE TABLE `fav_location` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `locality_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `fav_location` ADD PRIMARY KEY (`id`);

ALTER TABLE `fav_location` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
