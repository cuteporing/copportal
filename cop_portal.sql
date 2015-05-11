-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2015 at 06:08 PM
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
  `raw_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_ext` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_announcements`
--

INSERT INTO `cop_announcements` (`announcement_id`, `owner_id`, `title`, `date_entered`, `raw_name`, `file_path`, `file_ext`, `slug`) VALUES
(1, 1, 'asdasda', '2015-03-07 18:15:01', NULL, NULL, NULL, 'asdasda');

-- --------------------------------------------------------

--
-- Table structure for table `cop_announcement_description`
--

CREATE TABLE IF NOT EXISTS `cop_announcement_description` (
`id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_announcement_description`
--

INSERT INTO `cop_announcement_description` (`id`, `announcement_id`, `description`, `sequence`) VALUES
(1, 1, 'sdas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cop_artcore_parenttab`
--

CREATE TABLE IF NOT EXISTS `cop_artcore_parenttab` (
`parenttab_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `attribute` blob,
  `sequence` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_artcore_parenttab`
--

INSERT INTO `cop_artcore_parenttab` (`parenttab_id`, `title`, `link`, `attribute`, `sequence`, `slug`) VALUES
(1, 'Home', 'home', NULL, 1, 'home'),
(2, 'Events', 'event/new/page/', NULL, 3, 'events'),
(3, 'Gallery', 'galleries', NULL, 4, 'galleries'),
(4, 'Sign in', 'login', NULL, 6, 'login'),
(5, 'Announcement', 'announcement/page/', NULL, 2, 'announcement'),
(6, 'About', 'about', NULL, 5, 'about');

-- --------------------------------------------------------

--
-- Table structure for table `cop_artcore_subtab`
--

CREATE TABLE IF NOT EXISTS `cop_artcore_subtab` (
`subtab_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `attribute` blob,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cop_artcore_subtab`
--

INSERT INTO `cop_artcore_subtab` (`subtab_id`, `title`, `link`, `attribute`, `slug`) VALUES
(1, 'New events', 'event/new/page/', NULL, 'new_events'),
(2, 'Archive', 'event/archive/page/', NULL, 'archive');

-- --------------------------------------------------------

--
-- Table structure for table `cop_artcore_tab_map`
--

CREATE TABLE IF NOT EXISTS `cop_artcore_tab_map` (
`map_id` int(11) NOT NULL,
  `parenttab_id` int(11) NOT NULL,
  `subtab_id` int(11) NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_artcore_tab_map`
--

INSERT INTO `cop_artcore_tab_map` (`map_id`, `parenttab_id`, `subtab_id`, `sequence`) VALUES
(1, 2, 1, 1),
(2, 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cop_banner`
--

CREATE TABLE IF NOT EXISTS `cop_banner` (
`banner_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `sequence` int(11) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `link_title` varchar(255) DEFAULT NULL,
  `raw_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_ext` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_banner`
--

INSERT INTO `cop_banner` (`banner_id`, `title`, `subtitle`, `sequence`, `link`, `link_title`, `raw_name`, `file_path`, `file_ext`, `slug`) VALUES
(1, '', '', 1, '', 'See more', 'project_4', 'uploads/banner/', '.jpg', ''),
(2, '', '', 1, '', 'See more', 'project_3', 'uploads/banner/', '.jpg', ''),
(3, 'LOREM IPSUM ', 'dolor esmet', 1, '', 'See more', 'project_1', 'uploads/banner/', '.jpg', 'lorem-ipsum');

-- --------------------------------------------------------

--
-- Table structure for table `cop_beneficiaries`
--

CREATE TABLE IF NOT EXISTS `cop_beneficiaries` (
`id` int(11) NOT NULL,
  `beneficiary` varchar(255) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `phone` varchar(150) DEFAULT NULL,
  `address_street` varchar(150) NOT NULL,
  `address_city_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_beneficiaries`
--

INSERT INTO `cop_beneficiaries` (`id`, `beneficiary`, `date_entered`, `date_modified`, `phone`, `address_street`, `address_city_id`) VALUES
(3, 'SATIMA Village', '2015-03-07 18:45:35', '2015-03-07 18:45:35', '[]', '', 1),
(4, 'COP Coordinators', '2015-03-07 18:50:14', '2015-03-07 18:50:14', '[]', 'asdasdas', 3);

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
-- Table structure for table `cop_department`
--

CREATE TABLE IF NOT EXISTS `cop_department` (
`dept_id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cop_department`
--

INSERT INTO `cop_department` (`dept_id`, `department`) VALUES
(1, 'Pharmacy'),
(2, 'Dentistry'),
(3, 'Med Tech'),
(4, 'Rad Tech'),
(5, 'Criminology'),
(6, 'Maritime'),
(7, 'CAS'),
(8, 'Nursing & Midwifery'),
(9, 'Computer Studies'),
(10, 'Engineering'),
(11, 'Education'),
(12, 'CBAA'),
(13, 'Basic Education'),
(14, 'PT/OT/RT'),
(15, 'IHM'),
(16, 'COP Department');

-- --------------------------------------------------------

--
-- Table structure for table `cop_description`
--

CREATE TABLE IF NOT EXISTS `cop_description` (
`description_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_description`
--

INSERT INTO `cop_description` (`description_id`, `event_id`, `description`, `sequence`) VALUES
(63, 38, 'asdasdasd', 1),
(64, 40, 'asd', 1),
(69, 37, '<strong>Lorem Ipsum</strong><span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</span>', 1),
(72, 39, '<div>n try1.php, I am having a button on which I have apllied onclcck event. When I click on the button it prints the data but also prints the url text which I don''t want.</div><div><br></div><div>May I know the way to remove the url text from the printed page?<br><div>n try1.php, I am having a button on which I have apllied onclcck event. When I click on the button it prints the data but also prints the url text which I don''t want.</div><div><br></div><div>May I know the way to remove the url text from the printed page?n try1.php, I am having a button on which I have apllied onclcck event. When I click on the button it prints the data but also prints the url text which I don''t want.</div><div><br></div><div>May I know the way to remove the url text from the printed page?</div></div>', 1),
(74, 41, 'asdasd', 1),
(75, 42, 'ASDASD', 1),
(76, 43, 'asd', 1),
(77, 44, 'asd', 1),
(78, 45, 'asd', 1),
(79, 46, 'asdasd', 1),
(80, 47, 'asdasd', 1),
(81, 48, 'ASDASD', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cop_events`
--

CREATE TABLE IF NOT EXISTS `cop_events` (
`event_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` varchar(50) NOT NULL,
  `appr_cop_dir` tinyint(2) NOT NULL,
  `appr_sps_dir` tinyint(2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `time_start` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `time_end` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `location` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `in_charge` blob NOT NULL,
  `expected_output` blob NOT NULL,
  `materials_needed` blob NOT NULL,
  `budget` blob NOT NULL,
  `raw_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_ext` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_events`
--

INSERT INTO `cop_events` (`event_id`, `owner_id`, `title`, `status`, `appr_cop_dir`, `appr_sps_dir`, `category_id`, `date_entered`, `date_start`, `date_end`, `time_start`, `time_end`, `location`, `in_charge`, `expected_output`, `materials_needed`, `budget`, `raw_name`, `file_path`, `file_ext`, `slug`) VALUES
(37, 1, 'LOREM IPSUM 12', 'Approved', 1, 1, 1, '2015-03-08 03:40:14', '2015-03-06', '2015-03-06', '07:30 PM', '07:30 PM', 'Las piñas', 0x546865726520617265206d616e7920766172696174696f6e73206f66207061737361676573206f66204c6f72656d20497073756d20617661696c61626c652c2062757420746865206d616a6f72697479206861766520737566666572656420616c7465726174696f6e20696e20736f6d6520666f726d2c20627920696e6a65637465642068756d6f75722c206f722072616e646f6d6973656420776f72647320776869636820646f6e2774206c6f6f6b206576656e20736c696768746c792062656c69657661626c652e20496620796f752061726520676f696e6720746f2075736520612070617373616765206f66204c6f723c7370616e3e4c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e73656374657475722061646970697363696e6720656c69742e266e6273703b3c2f7370616e3e6572652069736e277420616e797468696e6720656d62617272617373696e672068696464656e20696e20746865206d6964646c65206f6620746578742e266e6273703b, 0x3c756c207374796c653d226c6973742d7374796c652d747970653a20646973633b206d617267696e2d6c6566743a20312e35656d3b223e3c6c693e4c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e73656374657475722061646970697363696e6720656c69742e266e6273703b3c62723e3c2f6c693e3c6c693e3c7370616e3e3c7370616e3e4c6f72656d20697073756d20646f6c6f722073697420616d65742e3c2f7370616e3e3c62723e3c2f7370616e3e3c2f6c693e3c2f756c3e, '', 0x32342c20303030, NULL, NULL, NULL, 'lorem-ipsum-12'),
(38, 7, 'TECH TUTOR 5', 'Approved', 1, 1, 1, '2015-03-08 14:54:13', '2015-04-09', '2015-04-10', '08:00 PM', '08:00 PM', 'Asd', 0x617364, 0x617364, '', 0x617364, NULL, NULL, NULL, 'tech-tutor-5'),
(39, 2, 'asdasdasdasd', 'Final confirmation', 1, 0, 1, '2015-03-09 04:41:00', '2015-03-08', '2015-03-08', '08:00 PM', '08:00 PM', 'Asd', 0x3c756c207374796c653d226c6973742d7374796c652d747970653a20646973633b206d617267696e2d6c6566743a20312e35656d3b223e3c6c693e4d61792049206b6e6f77207468652077617920746f2072656d6f7665207468652075726c20746578742066726f6d20746865207072696e74656420706167653f3c2f6c693e3c2f756c3e, 0x3c756c207374796c653d226c6973742d7374796c652d747970653a20646973633b206d617267696e2d6c6566743a20312e35656d3b223e3c6c693e4d61792049206b6e6f77207468652077617920746f2072656d6f7665207468652075726c20746578742066726f6d20746865207072696e74656420706167653f3c2f6c693e3c6c693e4d61792049206b6e6f77207468652077617920746f2072656d6f7665207468652075726c20746578742066726f6d20746865207072696e74656420706167653f3c62723e3c2f6c693e3c6c693e4d61792049206b6e6f77207468652077617920746f2072656d6f7665207468652075726c20746578742066726f6d20746865207072696e74656420706167653f3c62723e3c2f6c693e3c2f756c3e, 0x4d61792049206b6e6f77207468652077617920746f2072656d6f7665207468652075726c20746578742066726f6d20746865207072696e74656420706167653f, 0x31302c303030, NULL, NULL, NULL, 'asdasdasdasd'),
(40, 7, 'asdasd', 'Approved', 1, 1, 1, '2015-03-19 14:28:15', '2015-03-08', '2015-03-08', '09:00 PM', '09:00 PM', 'Asd', 0x61736461, 0x617364, 0x3c626c6f636b71756f7465207374796c653d226d617267696e3a20302030203020343070783b20626f726465723a206e6f6e653b2070616464696e673a203070783b223e3c62723e3c2f626c6f636b71756f74653e, 0x617364, NULL, NULL, NULL, 'asdasd'),
(41, 7, 'TUTORIALs', 'Approved', 1, 1, 1, '2015-03-16 15:45:47', '2015-03-16', '2015-03-16', '11:15 PM', '11:15 PM', 'Asd', 0x617364, 0x617364, '', 0x617364, NULL, NULL, NULL, 'tutorials'),
(42, 1, 'ASDASDASD', 'Approved', 1, 1, 1, '2015-03-19 01:52:44', '2015-03-19', '2015-03-19', '09:45 PM', '09:45 PM', 'ASD', 0x41534441, 0x5344415344415344415344, '', 0x617364, NULL, NULL, NULL, 'asdasdasd'),
(43, 1, 'asdasd', 'Approved', 1, 1, 1, '2015-03-19 01:55:42', '2015-03-19', '2015-03-19', '09:45 PM', '09:45 PM', 'Asd', 0x617364, 0x736461, '', 0x61736461, NULL, NULL, NULL, 'asdasd'),
(44, 2, 'asdasda', 'Approved', 1, 1, 1, '2015-03-19 14:28:27', '2015-03-19', '2015-03-19', '10:00 PM', '10:00 PM', 'Asd', 0x617364, 0x617364, 0x617364, 0x617364, NULL, NULL, NULL, 'asdasda'),
(45, 7, 'asdasdasd', 'Pending', 0, 0, 1, '2015-03-19 02:05:53', '2015-03-19', '2015-03-19', '10:00 PM', '10:00 PM', 'Asd', 0x61736461, 0x7364617364, '', 0x61736461, NULL, NULL, NULL, 'asdasdasd'),
(46, 1, 'asdasdasd', 'Approved', 1, 1, 1, '2015-03-19 02:15:53', '2015-03-19', '2015-03-19', '10:15 PM', '10:15 PM', 'Asd', 0x617364, 0x617364, '', 0x617364, NULL, NULL, NULL, 'asdasdasd'),
(47, 3, 'azenette', 'Approved', 1, 1, 1, '2015-03-19 14:28:40', '2015-03-19', '2015-03-19', '10:15 PM', '10:15 PM', 'Asd', 0x7364617364, 0x617364, '', 0x6461736461, NULL, NULL, NULL, 'azenette'),
(48, 1, 'THIS IS CREATED BY ADMIN', 'Approved', 1, 1, 1, '2015-03-19 03:12:40', '2015-03-19', '2015-03-19', '11:00 PM', '11:00 PM', 'ASD', 0x415344, 0x415344, '', 0x415344, NULL, NULL, NULL, 'this-is-created-by-admin');

-- --------------------------------------------------------

--
-- Table structure for table `cop_events_member`
--

CREATE TABLE IF NOT EXISTS `cop_events_member` (
`_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_events_member`
--

INSERT INTO `cop_events_member` (`_id`, `event_id`, `id`, `date_entered`) VALUES
(41, 38, 3, '2015-03-08 12:32:33'),
(42, 40, 4, '2015-03-08 13:06:17'),
(43, 40, 3, '2015-03-08 13:06:17'),
(48, 37, 3, '2015-03-08 15:40:14'),
(51, 39, 3, '2015-03-08 16:41:00'),
(53, 41, 4, '2015-03-16 15:20:29'),
(54, 42, 4, '2015-03-19 13:52:44'),
(55, 43, 4, '2015-03-19 13:55:42'),
(56, 44, 4, '2015-03-19 14:03:51'),
(57, 45, 3, '2015-03-19 14:05:53'),
(58, 46, 3, '2015-03-19 14:15:53'),
(59, 47, 4, '2015-03-19 14:25:51'),
(60, 48, 4, '2015-03-19 15:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `cop_event_comments`
--

CREATE TABLE IF NOT EXISTS `cop_event_comments` (
`comment_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_event_comments`
--

INSERT INTO `cop_event_comments` (`comment_id`, `event_id`, `name`, `text`, `date_entered`, `img`) VALUES
(38, 40, 'Zhara Gonzales', 'asdas', '2015-03-08 14:49:43', 'assets/img/avatar3.png'),
(39, 40, 'Zhara Gonzales', 'asdasd', '2015-03-08 14:49:45', 'assets/img/avatar3.png'),
(40, 40, 'Zhara Gonzales', 'asd', '2015-03-08 14:49:46', 'assets/img/avatar3.png'),
(41, 40, 'Zhara Gonzales', 'fgfgfgfgfg', '2015-03-08 14:49:48', 'assets/img/avatar3.png'),
(42, 38, 'Ish Landrito', 'dddddddddddddddddddddd', '2015-03-08 14:53:29', 'assets/img/avatar3.png'),
(43, 38, 'Zhara Gonzales', 'asdddddddddddddddd', '2015-03-08 14:53:45', 'assets/img/avatar3.png'),
(44, 38, 'User User', 'asdasd', '2015-03-08 14:54:19', 'assets/img/avatar3.png'),
(45, 39, 'Zhara Gonzales', 'asasd', '2015-03-08 16:09:26', 'assets/img/avatar3.png'),
(46, 40, 'User User', 'asdasd', '2015-03-10 12:42:28', 'assets/img/avatar3.png'),
(47, 40, 'User User', 'asssssssssssssssssssssssssssssssss', '2015-03-10 12:42:31', 'assets/img/avatar3.png'),
(48, 40, 'User User', 'asdasd', '2015-03-10 12:43:32', 'assets/img/avatar3.png'),
(49, 41, 'Zhara Gonzales', 'asd', '2015-03-16 15:46:26', 'assets/img/avatar3.png'),
(50, 41, 'Zhara Gonzales', 'asdasdasdasd', '2015-03-16 15:46:29', 'assets/img/avatar3.png');

-- --------------------------------------------------------

--
-- Table structure for table `cop_event_confirmation`
--

CREATE TABLE IF NOT EXISTS `cop_event_confirmation` (
`_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `cop_director` varchar(255) DEFAULT NULL,
  `sps_director` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_event_confirmation`
--

INSERT INTO `cop_event_confirmation` (`_id`, `event_id`, `cop_director`, `sps_director`) VALUES
(11, 44, NULL, 'Zhara Gonzales'),
(12, 44, NULL, 'Zhara Gonzales'),
(13, 44, NULL, 'Zhara Gonzales'),
(14, 44, 'Ish Landrito', 'Zhara Gonzales'),
(15, 44, '', 'Zhara Gonzales'),
(16, 44, '', 'Zhara Gonzales'),
(17, 44, '', 'Zhara Gonzales'),
(18, 44, NULL, 'Zhara Gonzales'),
(19, 47, NULL, 'Zhara Gonzales'),
(20, 48, '', 'Zhara Gonzales');

-- --------------------------------------------------------

--
-- Table structure for table `cop_gallery`
--

CREATE TABLE IF NOT EXISTS `cop_gallery` (
`gallery_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `cover_photo_id` varchar(50) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cop_gallery_photos`
--

CREATE TABLE IF NOT EXISTS `cop_gallery_photos` (
`gallery_photos_id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `raw_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_ext` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cop_kbn`
--

CREATE TABLE IF NOT EXISTS `cop_kbn` (
`_id` int(11) NOT NULL,
  `kbn_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_kbn`
--

INSERT INTO `cop_kbn` (`_id`, `kbn_id`, `role`, `description`) VALUES
(1, 10, 'COP Chairman', ''),
(2, 20, 'COP Director', ''),
(3, 30, 'SPS Director', '');

-- --------------------------------------------------------

--
-- Table structure for table `cop_sidebar`
--

CREATE TABLE IF NOT EXISTS `cop_sidebar` (
`id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `link` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `icon2` varchar(255) NOT NULL,
  `sequence` int(11) NOT NULL,
  `user_kbn` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_sidebar`
--

INSERT INTO `cop_sidebar` (`id`, `title`, `link`, `class`, `icon`, `icon2`, `sequence`, `user_kbn`) VALUES
(1, 'Dashboard', 'account/dashboard', '{"class":"active"}', '{"class":"fa fa-dashboard"}', '{"class":"fa fa-angle-left pull-right"}', 1, 10),
(2, 'Announcements', 'account/announcements', '{"class":"treeview"}', '{"class":"fa fa-th"}', '{"class":"fa fa-angle-left pull-right"}', 2, 10),
(3, 'Banner', 'account/banner', '{"class":""}', '{"class":"fa fa-flag-o"}', '{"class":"fa fa-angle-left pull-right"}', 3, 10),
(4, 'Events', 'account/events', '{"class":"treeview"}', '{"class":"fa fa-calendar"}', '{"class":"fa fa-angle-left pull-right"}', 4, 10),
(5, 'Gallery', 'account/gallery', '{"class":""}', '{"class":"fa fa-picture-o"}', '{"class":"fa fa-angle-left pull-right"}', 5, 10),
(6, 'Manage Beneficiary', 'account/manage_beneficiary', '{"class":"treeview"}', '{"class":"fa fa-users"}', '{"class":"fa fa-angle-left pull-right"}', 6, 10),
(7, 'Manage Users', 'account/manage_users', '{"class":"treeview"}', '{"class":"fa fa-user"}', '{"class":"fa fa-angle-left pull-right"}', 7, 30);

-- --------------------------------------------------------

--
-- Table structure for table `cop_sidebar_sub`
--

CREATE TABLE IF NOT EXISTS `cop_sidebar_sub` (
`sub_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_sidebar_sub`
--

INSERT INTO `cop_sidebar_sub` (`sub_id`, `id`, `title`, `link`, `icon`, `sequence`) VALUES
(1, 2, 'Create announcements', 'account/announcements/create', '{"class":"fa fa-angle-double-right"}', 1),
(2, 2, 'View announcements', 'account/announcements/', '{"class":"fa fa-angle-double-right"}', 2),
(3, 4, 'Create event', 'account/events/create', '{"class":"fa fa-angle-double-right"}', 1),
(4, 4, 'View events', 'account/events/', '{"class":"fa fa-angle-double-right"}', 2),
(5, 6, 'Add beneficiary', 'account/manage_beneficiary/create', '{"class":"fa fa-angle-double-right"}', 1),
(6, 6, 'View beneficiary', 'account/manage_beneficiary/view', '{"class":"fa fa-angle-double-right"}', 2),
(7, 7, 'Add user', 'account/manage_users/create', '{"class":"fa fa-angle-double-right"}', 1),
(8, 7, 'View Users', 'account/manage_users/view', '{"class":"fa fa-angle-double-right"}', 2);

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
  `user_kbn` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `phone` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `address_street` varchar(150) DEFAULT NULL,
  `address_city_id` int(11) DEFAULT NULL,
  `imagename` varchar(250) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `crypt_type` varchar(20) NOT NULL DEFAULT 'MD5'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_users`
--

INSERT INTO `cop_users` (`id`, `user_name`, `user_password`, `first_name`, `last_name`, `gender`, `user_kbn`, `dept_id`, `date_entered`, `date_modified`, `phone`, `email`, `status`, `address_street`, `address_city_id`, `imagename`, `deleted`, `crypt_type`) VALUES
(1, 'admin', '$1$ad000000$hzXFXvL3XVlnUE/X.1n9t/', 'Zhara', 'Gonzales', 'Female', 30, 16, '2015-03-19 15:13:25', '2015-03-06 22:49:07', '[]', '', 'Active', 'L18 B3 Belisario Subd.', 1, NULL, 0, 'PHP5.3MD5'),
(2, 'ish', '$1$is000000$WJSzElarDohtazA863l5S.', 'Ish', 'Landrito', 'Female', 20, 3, '2015-03-08 04:16:03', '2015-03-06 22:49:10', '[]', '', 'Active', '', 1, NULL, 0, 'PHP5.3MD5'),
(3, 'azenette', '$1$az000000$DURwizZNpXM5KzJoyo9cd1', 'Azenette', 'Caingal', 'Female', 10, 15, '2015-03-19 14:16:42', '2015-03-06 22:49:31', '[]', '', 'Active', '', 2, NULL, 0, 'PHP5.3MD5'),
(7, 'user', '$1$us000000$NnQJTRkDhBAWoNJZM6KyT1', 'User', 'User', 'female', 10, 2, '2015-03-08 05:09:36', '2015-03-07 22:09:36', '[]', '', 'Active', '', 1, NULL, 0, 'PHP5.3MD5'),
(8, 'KEVIN', '$1$KE000000$ynaJXMtoGCHXP.rvNEpxL1', 'Kevin', 'Valencia', 'male', 10, 13, '2015-03-19 15:14:27', '2015-03-19 03:14:27', '[]', '', 'Active', 'asdasdasd', 1, NULL, 0, 'PHP5.3MD5'),
(9, 'asd', '$1$as000000$7XoRA8ZB2p38Voq.Vbh7d0', 'Asd', 'Asd', 'Female', 10, 13, '2015-03-19 15:16:15', '2015-03-19 03:16:15', '[]', '', 'Active', '', 1, NULL, 0, 'PHP5.3MD5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cop_announcements`
--
ALTER TABLE `cop_announcements`
 ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `cop_announcement_description`
--
ALTER TABLE `cop_announcement_description`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cop_artcore_parenttab`
--
ALTER TABLE `cop_artcore_parenttab`
 ADD PRIMARY KEY (`parenttab_id`);

--
-- Indexes for table `cop_artcore_subtab`
--
ALTER TABLE `cop_artcore_subtab`
 ADD PRIMARY KEY (`subtab_id`);

--
-- Indexes for table `cop_artcore_tab_map`
--
ALTER TABLE `cop_artcore_tab_map`
 ADD PRIMARY KEY (`map_id`);

--
-- Indexes for table `cop_banner`
--
ALTER TABLE `cop_banner`
 ADD PRIMARY KEY (`banner_id`);

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
-- Indexes for table `cop_department`
--
ALTER TABLE `cop_department`
 ADD PRIMARY KEY (`dept_id`);

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
-- Indexes for table `cop_events_member`
--
ALTER TABLE `cop_events_member`
 ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `cop_event_comments`
--
ALTER TABLE `cop_event_comments`
 ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `cop_event_confirmation`
--
ALTER TABLE `cop_event_confirmation`
 ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `cop_gallery`
--
ALTER TABLE `cop_gallery`
 ADD PRIMARY KEY (`gallery_id`);

--
-- Indexes for table `cop_gallery_photos`
--
ALTER TABLE `cop_gallery_photos`
 ADD PRIMARY KEY (`gallery_photos_id`);

--
-- Indexes for table `cop_kbn`
--
ALTER TABLE `cop_kbn`
 ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `cop_sidebar`
--
ALTER TABLE `cop_sidebar`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cop_sidebar_sub`
--
ALTER TABLE `cop_sidebar_sub`
 ADD PRIMARY KEY (`sub_id`);

--
-- Indexes for table `cop_users`
--
ALTER TABLE `cop_users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cop_announcements`
--
ALTER TABLE `cop_announcements`
MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cop_announcement_description`
--
ALTER TABLE `cop_announcement_description`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cop_artcore_parenttab`
--
ALTER TABLE `cop_artcore_parenttab`
MODIFY `parenttab_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `cop_artcore_subtab`
--
ALTER TABLE `cop_artcore_subtab`
MODIFY `subtab_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cop_artcore_tab_map`
--
ALTER TABLE `cop_artcore_tab_map`
MODIFY `map_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cop_banner`
--
ALTER TABLE `cop_banner`
MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cop_beneficiaries`
--
ALTER TABLE `cop_beneficiaries`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
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
-- AUTO_INCREMENT for table `cop_department`
--
ALTER TABLE `cop_department`
MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `cop_description`
--
ALTER TABLE `cop_description`
MODIFY `description_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `cop_events`
--
ALTER TABLE `cop_events`
MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `cop_events_member`
--
ALTER TABLE `cop_events_member`
MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `cop_event_comments`
--
ALTER TABLE `cop_event_comments`
MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `cop_event_confirmation`
--
ALTER TABLE `cop_event_confirmation`
MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `cop_gallery`
--
ALTER TABLE `cop_gallery`
MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cop_gallery_photos`
--
ALTER TABLE `cop_gallery_photos`
MODIFY `gallery_photos_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cop_kbn`
--
ALTER TABLE `cop_kbn`
MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cop_sidebar`
--
ALTER TABLE `cop_sidebar`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `cop_sidebar_sub`
--
ALTER TABLE `cop_sidebar_sub`
MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cop_users`
--
ALTER TABLE `cop_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
