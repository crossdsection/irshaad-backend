-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 11, 2018 at 11:25 AM
-- Server version: 10.1.29-MariaDB-6+b1
-- PHP Version: 7.2.4-1+b2

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
-- Table structure for table `area_ratings`
--

CREATE TABLE `area_ratings` (
  `id` int(11) NOT NULL,
  `area_level` enum('world','country','state','city','locality','department') COLLATE utf8_unicode_ci NOT NULL,
  `area_level_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `good` tinyint(4) NOT NULL DEFAULT '0',
  `bad` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area_ratings`
--
ALTER TABLE `area_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `area_level` (`area_level`,`area_level_id`,`user_id`),
  ADD KEY `area_level_id` (`area_level_id`,`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area_ratings`
--
ALTER TABLE `area_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
