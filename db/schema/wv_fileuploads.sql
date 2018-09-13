-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 21, 2018 at 05:01 PM
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
-- Table structure for table `fileuploads`
--

CREATE TABLE `fileuploads` (
  `id` int(11) NOT NULL,
  `filepath` varchar(256) NOT NULL,
  `filetype` varchar(256) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fileuploads`
--

INSERT INTO `fileuploads` (`id`, `filepath`, `filetype`, `created`, `modified`) VALUES
(5, '/var/www/worlvoting/webroot/img/upload/5a27990e44efe.jpg', 'image/jpeg', '2018-06-21 11:30:19', '2018-06-21 11:30:19'),
(6, '/var/www/worlvoting/webroot/img/upload/5a27990e44efe.jpg', 'image/jpeg', '2018-06-21 11:31:23', '2018-06-21 11:31:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fileuploads`
--
ALTER TABLE `fileuploads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fileuploads`
--
ALTER TABLE `fileuploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
