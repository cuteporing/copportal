-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2015 at 09:06 AM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cop_announcement_description`
--

CREATE TABLE IF NOT EXISTS `cop_announcement_description` (
`id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cop_department`
--

INSERT INTO `cop_department` (`dept_id`, `department`) VALUES
(1, 'Pharmacy'),
(2, 'Dentistry'),
(3, 'Med. Tech'),
(4, 'Rad. Tech'),
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
(15, 'IHM');

-- --------------------------------------------------------

--
-- Table structure for table `cop_description`
--

CREATE TABLE IF NOT EXISTS `cop_description` (
`description_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_description`
--

INSERT INTO `cop_description` (`description_id`, `event_id`, `description`, `sequence`) VALUES
(21, 5, 'Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;<br><ul style="list-style-type: disc; margin-left: 1.5em;"><li>rån&nbsp;Lorem Ipsum är en utf<br></li><li>&nbsp;Lorem Ipsum är en&nbsp;<br></li></ul><br>', 1),
(32, 12, '<span>Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;</span>', 1),
(42, 22, 'aaaaaaaaaaaaaaaaaaaaaaaaa', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_events`
--

INSERT INTO `cop_events` (`event_id`, `owner_id`, `title`, `status`, `appr_cop_dir`, `appr_sps_dir`, `category_id`, `date_entered`, `date_start`, `date_end`, `time_start`, `time_end`, `location`, `in_charge`, `expected_output`, `materials_needed`, `budget`, `raw_name`, `file_path`, `file_ext`, `slug`) VALUES
(5, 2, 'LOREM IPSUM 4', 'Approved', 1, 1, 1, '2015-03-08 04:14:09', '2015-03-03', '2015-03-11', '12:30 AM', '12:30 AM', 'Asdas', '', '', '', '', NULL, NULL, NULL, 'lorem-ipsum-4'),
(12, 1, 'LOREM IPSUM 45', 'Approved', 1, 1, 1, '2015-03-07 23:08:26', '2015-03-08', '2015-03-08', '02:00 PM', '02:00 PM', 'Las Piñas', 0x3c756c207374796c653d226c6973742d7374796c652d747970653a20646973633b206d617267696e2d6c6566743a20312e35656d3b223e3c6c693e4c6f72656d20497073756d20c3a47220656e20757466796c6c6e61647374657874206672c3a56e266e6273703b3c2f6c693e3c6c693e4c6f72656d20497073756d20c3a47220656e20757466796c6c6e61647374657874206672c3a56e266e6273703b3c62723e3c2f6c693e3c6c693e4c6f72656d20497073756d20c3a47220656e20757466796c6c6e61647374657874206672c3a56e266e6273703b3c62723e3c2f6c693e3c6c693e4c6f72656d20497073756d20c3a47220656e20757466796c6c6e61647374657874206672c3a56e266e6273703b3c62723e3c2f6c693e3c2f756c3e, 0x3c756c207374796c653d226c6973742d7374796c652d747970653a20646973633b206d617267696e2d6c6566743a20312e35656d3b223e3c6c693e4c6f72656d20497073756d20c3a47220656e20757466796c6c6e61647374657874206672c3a56e266e6273703b3c2f6c693e3c6c693e4c6f72656d20497073756d20c3a47220656e20757466796c6c6e61647374657874206672c3a56e266e6273703b3c62723e3c2f6c693e3c6c693e4c6f72656d20497073756d20c3a47220656e20757466796c6c6e61647374657874206672c3a56e266e6273703b3c62723e3c2f6c693e3c6c693e4c6f72656d20497073756d20c3a47220656e20757466796c6c6e61647374657874206672c3a56e266e6273703b3c62723e3c2f6c693e3c2f756c3e, 0x3c756c207374796c653d226c6973742d7374796c652d747970653a20646973633b206d617267696e2d6c6566743a20312e35656d3b223e3c6c693e4c6f72656d20497073756d20c3a47220656e20757466796c6c6e61647374657874206672c3a56e266e6273703b3c2f6c693e3c6c693e4c6f72656d20497073756d20c3a47220656e20757466796c6c6e61647374657874206672c3a56e266e6273703b3c62723e3c2f6c693e3c6c693e4c6f72656d20497073756d20c3a47220656e20757466796c6c6e61647374657874206672c3a56e266e6273703b3c62723e3c2f6c693e3c2f756c3e, 0x31302c20303030, NULL, NULL, NULL, 'lorem-ipsum-45'),
(22, 1, 'asdasd', 'Approved', 1, 1, 1, '2015-03-08 00:18:18', '2015-03-08', '2015-03-08', '03:15 PM', '03:15 PM', 'Asd', 0x617364, 0x617364, '', 0x617364, NULL, NULL, NULL, 'asdasd');

-- --------------------------------------------------------

--
-- Table structure for table `cop_events_member`
--

CREATE TABLE IF NOT EXISTS `cop_events_member` (
`_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_events_member`
--

INSERT INTO `cop_events_member` (`_id`, `event_id`, `id`, `date_entered`) VALUES
(4, 18, 4, '2015-03-08 06:37:12'),
(8, 22, 4, '2015-03-08 07:18:18');

-- --------------------------------------------------------

--
-- Table structure for table `cop_event_confirmation`
--

CREATE TABLE IF NOT EXISTS `cop_event_confirmation` (
`_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_users`
--

INSERT INTO `cop_users` (`id`, `user_name`, `user_password`, `first_name`, `last_name`, `gender`, `user_kbn`, `dept_id`, `date_entered`, `date_modified`, `phone`, `email`, `status`, `address_street`, `address_city_id`, `imagename`, `deleted`, `crypt_type`) VALUES
(1, 'admin', '$1$ad000000$hzXFXvL3XVlnUE/X.1n9t/', 'Zhara', 'Gonzales', 'Female', 30, 1, '2015-03-07 17:49:07', '2015-03-06 22:49:07', '[]', '', 'Active', 'L18 B3 Belisario Subd.', 1, NULL, 0, 'PHP5.3MD5'),
(2, 'ish', '$1$is000000$WJSzElarDohtazA863l5S.', 'Ish', 'Landrito', 'Female', 20, 3, '2015-03-08 04:16:03', '2015-03-06 22:49:10', '[]', '', 'Active', '', 1, NULL, 0, 'PHP5.3MD5'),
(3, 'azenette', '$1$az000000$kugfYCMHKWIKW6gCeobm91', 'Azenette', 'Caingal', 'Female', 10, 15, '2015-03-07 17:49:31', '2015-03-06 22:49:31', '[]', '', 'Active', '', 2, NULL, 0, 'PHP5.3MD5'),
(7, 'user', '$1$us000000$NnQJTRkDhBAWoNJZM6KyT1', 'User', 'User', 'female', 10, 2, '2015-03-08 05:09:36', '2015-03-07 22:09:36', '[]', '', 'Active', '', 1, NULL, 0, 'PHP5.3MD5');

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
MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cop_announcement_description`
--
ALTER TABLE `cop_announcement_description`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `cop_description`
--
ALTER TABLE `cop_description`
MODIFY `description_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `cop_events`
--
ALTER TABLE `cop_events`
MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `cop_events_member`
--
ALTER TABLE `cop_events_member`
MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cop_event_confirmation`
--
ALTER TABLE `cop_event_confirmation`
MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
