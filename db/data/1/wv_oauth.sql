-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 04, 2018 at 07:10 AM
-- Server version: 10.2.14-MariaDB-log
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `worldvote2`
--

-- --------------------------------------------------------

--
-- Table structure for table `wv_oauth`
--

CREATE TABLE `wv_oauth` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider_id` varchar(512) NOT NULL,
  `access_token` varchar(2048) NOT NULL,
  `issued_at` datetime NOT NULL,
  `expiration_time` datetime NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wv_oauth`
--

INSERT INTO `wv_oauth` (`id`, `user_id`, `provider_id`, `access_token`, `issued_at`, `expiration_time`, `created`, `modified`) VALUES
(1, 36, 'https://localhost', 'xwxLftFsFLyb3SxYSUhY8dJruOav/xjqX8CufTgig+o=', '2018-06-04 06:29:20', '2018-06-05 06:29:20', '2018-06-04 06:14:57', '2018-06-04 06:29:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wv_oauth`
--
ALTER TABLE `wv_oauth`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wv_oauth`
--
ALTER TABLE `wv_oauth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
