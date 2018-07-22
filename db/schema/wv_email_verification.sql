-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2018 at 11:23 AM
-- Server version: 10.1.29-MariaDB-6
-- PHP Version: 7.0.29-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `worldvoting`
--

-- --------------------------------------------------------

--
-- Table structure for table `wv_email_verification`
--

CREATE TABLE `wv_email_verification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `expirationtime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status disables after usage.',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Triggers `wv_email_verification`
--
DELIMITER $$
CREATE TRIGGER `Set Expiration Time` BEFORE INSERT ON `wv_email_verification` FOR EACH ROW BEGIN
  SET NEW.expirationtime = NOW() + INTERVAL 5 HOUR;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wv_email_verification`
--
ALTER TABLE `wv_email_verification`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wv_email_verification`
--
ALTER TABLE `wv_email_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
