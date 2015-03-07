-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2015 at 03:18 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_beneficiaries`
--

INSERT INTO `cop_beneficiaries` (`id`, `first_name`, `last_name`, `gender`, `date_entered`, `date_modified`, `phone`, `address_street`, `address_city_id`, `imagename`, `deleted`) VALUES
(1, 'Ransu', 'Caw', 'Female', '2015-03-01 22:34:44', '2015-03-01 22:34:44', '[]', 'asd', 1, '', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_description`
--

INSERT INTO `cop_description` (`description_id`, `event_id`, `description`, `sequence`) VALUES
(4, 3, '', 1),
(11, 5, 'Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;Lorem Ipsum är en utfyllnadstext från&nbsp;<br>', 1),
(16, 2, 'Lorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem Ipsum<br>', 1),
(17, 6, '', 1),
(18, 7, 'asdasd', 1),
(20, 4, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cop_events`
--

CREATE TABLE IF NOT EXISTS `cop_events` (
`event_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` varchar(50) NOT NULL,
  `appr_status` tinyint(2) NOT NULL DEFAULT '1',
  `appr_cop_dir` tinyint(2) NOT NULL,
  `appr_sps_dir` tinyint(2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `time_start` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `time_end` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `location` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `raw_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_ext` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_events`
--

INSERT INTO `cop_events` (`event_id`, `owner_id`, `title`, `status`, `appr_status`, `appr_cop_dir`, `appr_sps_dir`, `category_id`, `date_entered`, `date_start`, `date_end`, `time_start`, `time_end`, `location`, `raw_name`, `file_path`, `file_ext`, `slug`) VALUES
(2, 1, 'Lorem Ipsum', 'open', 1, 1, 1, 1, '2015-03-06 01:02:21', '2015-03-12', '2015-03-13', '11:30 PM', '11:30 PM', 'ASDASDAS', NULL, NULL, NULL, 'lorem-ipsum'),
(3, 1, 'sdasdasdasda', 'open', 1, 1, 1, 1, '2015-03-06 01:02:24', '2015-03-01', '2015-03-01', '01:15 PM', '01:15 PM', 'Sdasd', NULL, NULL, NULL, 'sdasdasdasda'),
(4, 1, 'asdasdas', 'open', 1, 1, 1, 1, '2015-03-06 01:02:26', '2015-03-01', '2015-03-03', '12:30 AM', '12:30 AM', 'Asda', NULL, NULL, NULL, 'asdasdas'),
(5, 1, 'LOREM IPSUM 4', 'open', 1, 1, 1, 1, '2015-03-06 01:02:28', '2015-03-11', '2015-03-11', '12:30 AM', '12:30 AM', 'Asdas', NULL, NULL, NULL, 'lorem-ipsum-4'),
(6, 1, 'asdasdas', 'open', 1, 1, 1, 1, '2015-03-06 01:02:29', '2015-03-05', '2015-03-05', '11:00 PM', '11:00 PM', 'Dasd', NULL, NULL, NULL, 'asdasdas'),
(7, 1, 'asdasdasd', 'open', 1, 1, 1, 1, '2015-03-06 13:04:17', '2015-04-22', '2015-04-23', '09:00 PM', '09:00 PM', 'Asd', NULL, NULL, NULL, 'asdasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `cop_events_member`
--

CREATE TABLE IF NOT EXISTS `cop_events_member` (
  `event_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_events_member`
--

INSERT INTO `cop_events_member` (`event_id`, `id`, `date_entered`, `status`) VALUES
(2, 1, '2015-03-02 17:34:54', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_users`
--

INSERT INTO `cop_users` (`id`, `user_name`, `user_password`, `first_name`, `last_name`, `gender`, `user_kbn`, `date_entered`, `date_modified`, `phone`, `email`, `status`, `address_street`, `address_city_id`, `imagename`, `deleted`, `crypt_type`) VALUES
(1, 'admin', '$1$ad000000$hzXFXvL3XVlnUE/X.1n9t/', 'Zhara', 'Gonzales', 'female', 30, '2015-03-07 11:10:03', '0000-00-00 00:00:00', '[]', 'admin@gmail.com', 'Active', 'L18 B3 Belisario Subd.', 1, NULL, 0, 'PHP5.3MD5'),
(2, 'ish', '$1$is000000$WJSzElarDohtazA863l5S.', 'Ish', 'Landrito', 'female', 20, '2015-03-07 11:16:48', '2015-03-05 17:52:06', '[]', '', 'Active', '', 1, NULL, 0, 'PHP5.3MD5'),
(3, 'azenette', '$1$az000000$DURwizZNpXM5KzJoyo9cd1', 'Azenette', 'Caingal', 'female', 10, '2015-03-07 11:10:29', '2015-03-05 17:55:08', '[]', '', 'Active', '', 1, NULL, 0, 'PHP5.3MD5'),
(4, 'kevin', '$1$ke000000$RbIOedPHoBIz4C7HOMEcC.', 'Kevin', 'Valencia', 'female', 30, '2015-03-07 10:26:55', '2015-03-07 03:26:30', '[]', '', 'Inactive', '', 1, NULL, 1, 'PHP5.3MD5'),
(5, 'axa', '$1$ax000000$YXVSyoScVM1v3d6wjW7Bj.', 'Asd', 'Asd', 'female', 20, '2015-03-07 10:26:57', '2015-03-07 03:26:46', '[]', '', 'Inactive', '', 1, NULL, 1, 'PHP5.3MD5');

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
MODIFY `description_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `cop_events`
--
ALTER TABLE `cop_events`
MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
