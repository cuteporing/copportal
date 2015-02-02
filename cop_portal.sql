-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2015 at 08:17 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cop_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `cop_announcements`
--

CREATE TABLE IF NOT EXISTS `cop_announcements` (
`announcement_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_announcements`
--

INSERT INTO `cop_announcements` (`announcement_id`, `owner_id`, `title`, `date_entered`, `slug`) VALUES
(1, 1, 'superubu', '2015-01-30 03:59:08', 'superubu'),
(7, 1, 'KURISHA', '2015-01-30 03:56:39', 'kurisha'),
(9, 1, 'asdasdas', '2015-01-29 20:04:48', 'asdasdas'),
(12, 1, 'asdasda', '2015-01-29 20:11:42', 'asdasda'),
(14, 1, 'RANSU', '2015-01-30 03:57:54', 'ransu'),
(16, 1, 'SUPER TUTOR', '2015-01-29 20:37:54', 'super-tutor');

-- --------------------------------------------------------

--
-- Table structure for table `cop_announcement_description`
--

CREATE TABLE IF NOT EXISTS `cop_announcement_description` (
  `announcement_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_announcement_description`
--

INSERT INTO `cop_announcement_description` (`announcement_id`, `description`, `sequence`) VALUES
(16, 'ASDASD', 1),
(1, 'asdasdasdas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cop_beneficiaries`
--

CREATE TABLE IF NOT EXISTS `cop_beneficiaries` (
`id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `phone` varchar(150) DEFAULT NULL,
  `address_street` varchar(150) NOT NULL,
  `address_city_id` int(11) NOT NULL,
  `imagename` varchar(250) NOT NULL,
  `deleted` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_beneficiaries`
--

INSERT INTO `cop_beneficiaries` (`id`, `first_name`, `last_name`, `gender`, `date_entered`, `date_modified`, `phone`, `address_street`, `address_city_id`, `imagename`, `deleted`) VALUES
(5, 'asdas', 'dasda', 'Female', '2015-01-29 18:57:55', '2015-01-29 18:57:55', '[]', 'asdas', 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cop_category`
--

CREATE TABLE IF NOT EXISTS `cop_category` (
`category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_category`
--

INSERT INTO `cop_category` (`category_id`, `category_name`) VALUES
(1, 'Trainings'),
(2, 'Seminars'),
(3, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `cop_city`
--

CREATE TABLE IF NOT EXISTS `cop_city` (
`city_id` int(11) NOT NULL,
  `city` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_city`
--

INSERT INTO `cop_city` (`city_id`, `city`) VALUES
(1, 'Caloocan'),
(2, 'Las Piñas'),
(3, 'Makati'),
(4, 'Malabon'),
(5, 'Mandaluyong'),
(6, 'Marikina'),
(7, 'Muntinlupa');

-- --------------------------------------------------------

--
-- Table structure for table `cop_description`
--

CREATE TABLE IF NOT EXISTS `cop_description` (
`description_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_description`
--

INSERT INTO `cop_description` (`description_id`, `event_id`, `description`, `sequence`) VALUES
(15, 12, 'asdasdaasd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cop_events`
--

CREATE TABLE IF NOT EXISTS `cop_events` (
`event_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `time_start` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `time_end` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `location` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_events`
--

INSERT INTO `cop_events` (`event_id`, `owner_id`, `title`, `status`, `category_id`, `date_entered`, `date_start`, `date_end`, `time_start`, `time_end`, `location`, `slug`) VALUES
(12, 1, 'TECH TUTOR 5', 'open', 1, '2015-01-21 23:15:39', '2015-01-22', '2015-01-22', '15:15:00', '15:15:00', 'asdas', 'tech-tutor-5');

-- --------------------------------------------------------

--
-- Table structure for table `cop_events_member`
--

CREATE TABLE IF NOT EXISTS `cop_events_member` (
  `event_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cop_users`
--

CREATE TABLE IF NOT EXISTS `cop_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_password` varchar(200) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `is_admin` varchar(3) DEFAULT '0',
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `phone` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `address_street` varchar(150) DEFAULT NULL,
  `address_city` varchar(100) DEFAULT NULL,
  `address_postalcode` varchar(9) DEFAULT NULL,
  `imagename` varchar(250) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `crypt_type` varchar(20) NOT NULL DEFAULT 'MD5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_users`
--

INSERT INTO `cop_users` (`id`, `user_name`, `user_password`, `first_name`, `last_name`, `gender`, `is_admin`, `date_entered`, `date_modified`, `phone`, `email`, `status`, `address_street`, `address_city`, `address_postalcode`, `imagename`, `deleted`, `crypt_type`) VALUES
(1, 'admin', '$1$ad000000$hzXFXvL3XVlnUE/X.1n9t/', 'Zhara', 'Gonzales', 'female', 'on', '2015-01-18 10:54:55', '0000-00-00 00:00:00', NULL, 'admin@gmail.com', 'Active', 'L18 B3 Belisario Subd.', 'Las Piñas', NULL, NULL, 0, 'PHP5.3MD5'),
(2, '311-1262', '$1$31000000$cw981R2sDU.dqcJR3rlXr.', 'Ish', 'Landrito', 'female', 'off', '2015-01-10 05:25:19', '2015-01-05 21:32:11', NULL, NULL, 'Active', NULL, NULL, NULL, NULL, 0, 'PHP5.3MD5'),
(3, '311-1263', '$1$31000000$cw981R2sDU.dqcJR3rlXr.', 'Azanette', 'Caingal', 'female', 'off', '2015-01-10 05:25:21', '2015-01-05 21:32:54', NULL, NULL, 'Active', NULL, NULL, NULL, NULL, 0, 'PHP5.3MD5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cop_announcements`
--
ALTER TABLE `cop_announcements`
 ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `cop_beneficiaries`
--
ALTER TABLE `cop_beneficiaries`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cop_category`
--
ALTER TABLE `cop_category`
 ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `cop_city`
--
ALTER TABLE `cop_city`
 ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `cop_description`
--
ALTER TABLE `cop_description`
 ADD PRIMARY KEY (`description_id`);

--
-- Indexes for table `cop_events`
--
ALTER TABLE `cop_events`
 ADD PRIMARY KEY (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cop_announcements`
--
ALTER TABLE `cop_announcements`
MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `cop_beneficiaries`
--
ALTER TABLE `cop_beneficiaries`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cop_category`
--
ALTER TABLE `cop_category`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cop_city`
--
ALTER TABLE `cop_city`
MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `cop_description`
--
ALTER TABLE `cop_description`
MODIFY `description_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `cop_events`
--
ALTER TABLE `cop_events`
MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
