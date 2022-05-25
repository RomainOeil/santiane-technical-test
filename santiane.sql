-- phpMyAdmin SQL Dump
-- version 5.1.4-1.fc34
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 25, 2022 at 01:37 PM
-- Server version: 10.5.15-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `santiane`
--

-- --------------------------------------------------------

--
-- Table structure for table `etape`
--

CREATE TABLE `etape` (
  `id` int(11) NOT NULL,
  `voyage_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `departure` varchar(255) NOT NULL,
  `arrival` varchar(255) NOT NULL,
  `seat` varchar(255) DEFAULT NULL,
  `gate` varchar(255) DEFAULT NULL,
  `baggage_drop` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `etape`
--

INSERT INTO `etape` (`id`, `voyage_id`, `type`, `number`, `departure`, `arrival`, `seat`, `gate`, `baggage_drop`) VALUES
(1, 1, 'plane', 'SK22', 'Stockholm', 'New York JFK', '7B', '22', NULL),
(2, 1, 'bus', 'airport', 'Barcelona', 'Gerona Airport', '', '', NULL),
(3, 1, 'plane', 'SK455', 'Gerona Airport', 'Stockholm', '3A', '45B', 344),
(4, 1, 'train', '78A', 'Madrid', 'Barcelona', '45B', '', NULL),
(5, 2, 'bus', 'B1', 'Grasse', 'Cannes', '', '', NULL),
(6, 2, 'train', 'TER-A', 'Cannes', 'Nice Riquier', '', '', NULL),
(7, 2, 'bus', 'B2', 'Nice Riquier', 'Nice', '', '', NULL),
(8, 2, 'plane', 'P455', 'Nice', 'Paris', '3A', '45B', NULL),
(9, 2, 'plane', 'P42', 'Paris', 'Londre', '96B', '12', 123),
(10, 2, 'train', 'T9 3/4', 'Londre', 'Hogwarts Castle', '6', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `voyage`
--

CREATE TABLE `voyage` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voyage`
--

INSERT INTO `voyage` (`id`, `name`) VALUES
(1, 'Voyage1'),
(2, 'Voyage2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `etape`
--
ALTER TABLE `etape`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_voyage_id` (`voyage_id`);

--
-- Indexes for table `voyage`
--
ALTER TABLE `voyage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `etape`
--
ALTER TABLE `etape`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `voyage`
--
ALTER TABLE `voyage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `etape`
--
ALTER TABLE `etape`
  ADD CONSTRAINT `fk_voyage_id` FOREIGN KEY (`voyage_id`) REFERENCES `voyage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
