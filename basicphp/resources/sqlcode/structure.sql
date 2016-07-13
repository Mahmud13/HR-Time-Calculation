-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 06, 2016 at 06:29 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timedb`
--
DROP DATABASE IF EXISTS `timedb`;
CREATE DATABASE IF NOT EXISTS `timedb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `timedb`;

-- --------------------------------------------------------

--
-- Table structure for table `RawMonthTable`
--

CREATE TABLE `RawMonthTable` (
  `pin` int(11) NOT NULL,
  `month` date NOT NULL,
  `lates` int(11) DEFAULT NULL,
  `halves` int(11) DEFAULT NULL,
  `absents` int(11) DEFAULT NULL,
  `casualLeave` decimal(11,5) DEFAULT NULL,
  `medicalLeave` decimal(11,5) DEFAULT NULL,
  `earnedLeave` decimal(11,5) DEFAULT NULL,
  `leaveswithoutpay` decimal(11,5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `RawNameTable`
--

CREATE TABLE `RawNameTable` (
  `pin` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `des` varchar(255) NOT NULL,
  `desID` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `RawTimeTable`
--

CREATE TABLE `RawTimeTable` (
  `pin` int(11) NOT NULL,
  `date` date NOT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `inTime` time NOT NULL,
  `outTime` time DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `medicalleave` decimal(11,6) NOT NULL,
  `casualleave` decimal(11,6) NOT NULL,
  `enjoyedleave` decimal(11,6) NOT NULL,
  `earnedleave` decimal(11,6) NOT NULL,
  `leavewithoutpay` decimal(11,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `RawYearTable`
--

CREATE TABLE `RawYearTable` (
  `pin` int(11) NOT NULL,
  `year` date NOT NULL,
  `earnedleavebalance` decimal(11,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `epochdate` int(11) NOT NULL,
  `date` date NOT NULL,
  `flag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `RawMonthTable`
--
ALTER TABLE `RawMonthTable`
  ADD PRIMARY KEY (`pin`,`month`);

--
-- Indexes for table `RawNameTable`
--
ALTER TABLE `RawNameTable`
  ADD PRIMARY KEY (`pin`);

--
-- Indexes for table `RawTimeTable`
--
ALTER TABLE `RawTimeTable`
  ADD PRIMARY KEY (`pin`,`date`);

--
-- Indexes for table `RawYearTable`
--
ALTER TABLE `RawYearTable`
  ADD PRIMARY KEY (`pin`,`year`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`epochdate`);


--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

DROP USER IF EXISTS 'timedbuser'@'localhost';
CREATE USER 'timedbuser'@'localhost' IDENTIFIED BY 'helloyou';GRANT USAGE ON *.* TO 'timedbuser'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;GRANT ALL PRIVILEGES ON `timedb`.* TO 'timedbuser'@'localhost';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
