DROP TABLE `wv_locality_reviews`

CREATE TABLE `wv_localities` (
  `id` int(11) NOT NULL,
  `locality` varchar(100) NOT NULL,
  `city_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
