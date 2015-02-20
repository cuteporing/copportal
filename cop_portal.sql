-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2015 at 03:51 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_announcements`
--

INSERT INTO `cop_announcements` (`announcement_id`, `owner_id`, `title`, `date_entered`, `raw_name`, `file_path`, `file_ext`, `slug`) VALUES
(9, 1, 'Neque porro quisquam est qui dolorem', '2015-02-20 11:38:36', 'blog-1', 'uploads/announcement/', '.jpg', 'neque-porro-quisquam-est-qui-dolorem'),
(12, 1, 'NEW ANNOUNCEMENT', '2015-02-20 11:35:00', 'blog-2', 'uploads/announcement/', '.jpg', 'new-announcement'),
(13, 1, 'Keep Your Stuff Alive And Apply it On Life', '2015-02-19 18:06:02', NULL, NULL, NULL, 'keep-your-stuff-alive-and-apply-it-on-life'),
(14, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', '2015-02-19 18:07:59', NULL, NULL, NULL, 'lorem-ipsum-dolor-sit-amet-consectetur-adipisicing-elit'),
(15, 1, 'Debitis, totam dignissimos fugiat voluptatem esse optio unde alias nulla fuga', '2015-02-19 18:08:17', NULL, NULL, NULL, 'debitis-totam-dignissimos-fugiat-voluptatem-esse-optio-unde-alias-nulla-fuga'),
(16, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. ', '2015-02-19 18:08:59', NULL, NULL, NULL, 'lorem-ipsum-dolor-sit-amet-consectetur-adipisicing-elit'),
(17, 1, 'NEW ANNOUNCEMENT', '2015-02-19 18:23:29', NULL, NULL, NULL, 'new-announcement');

-- --------------------------------------------------------

--
-- Table structure for table `cop_announcement_description`
--

CREATE TABLE IF NOT EXISTS `cop_announcement_description` (
`id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_announcement_description`
--

INSERT INTO `cop_announcement_description` (`id`, `announcement_id`, `description`, `sequence`) VALUES
(1, 12, '', 1),
(4, 9, '<strong>Lorem Ipsum</strong><span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</span>', 1),
(5, 13, '<a target="_blank" rel="nofollow" href="http://www.templatemo.com/preview/templatemo_423_artcore" title="Link: http://www.templatemo.com/preview/templatemo_423_artcore">Artcore</a><span>&nbsp;is free HTML5 bootstrap template by&nbsp;</span>templatemo<span>. Credit goes to&nbsp;</span><a target="_blank" rel="nofollow" href="http://unsplash.com/">Unsplash</a><span>&nbsp;for images. Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, blanditiis, esse nemo architecto veniam ipsam et in odit unde cumque. Quidem, sapiente, deserunt accusantium iure minus numquam velit beatae iste corrupti alias atque quisquam praesentium est autem voluptatibus? Magnam, repellendus id quidem reprehenderit eligendi. Voluptas, fugiat cumque earum similique suscipit at labore aut hic voluptatum deserunt aliquid dignissimos corporis facilis in provident atque nihil.</span>', 1),
(6, 14, '<span>Quibusdam, maxime, itaque, ut, eligendi consequuntur quasi placeat molestiae nam sunt amet ab officia voluptates dolore error repudiandae fugit aperiam quas facilis? Ipsa, perspiciatis, nam, modi ducimus esse assumenda aut quaerat commodi natus dolorem quo accusantium saepe officiis quasi porro. Possimus, asperiores, nihil, vitae, cumque aperiam perspiciatis velit sit aliquid consectetur neque quidem dolore voluptatem rerum omnis totam impedit sequi eius explicabo culpa facilis.&nbsp;</span>', 1),
(7, 15, '<span>Quibusdam, maxime, itaque, ut, eligendi consequuntur quasi placeat molestiae nam sunt amet ab officia voluptates dolore error repudiandae fugit aperiam quas facilis? Ipsa, perspiciatis, nam, modi ducimus esse assumenda aut quaerat commodi natus dolorem quo accusantium saepe officiis quasi porro. Possimus, asperiores, nihil, vitae, cumque aperiam perspiciatis velit sit aliquid consectetur neque quidem dolore voluptatem rerum omnis totam impedit sequi eius explicabo culpa facilis.&nbsp;</span>', 1),
(8, 16, '<span>dolorum molestiae omnis natus neque autem minus dicta magnam nobis ipsa ratione recusandae numquam modi asperiores adipisci repudiandae quis beatae placeat ullam atque pariatur expedita.</span><br>', 1),
(9, 17, '<span>dolorum molestiae omnis natus neque autem minus dicta magnam nobis ipsa ratione recusandae numquam modi asperiores adipisci repudiandae quis beatae placeat ullam atque pariatur expedita.</span><br>', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_artcore_parenttab`
--

INSERT INTO `cop_artcore_parenttab` (`parenttab_id`, `title`, `link`, `attribute`, `sequence`, `slug`) VALUES
(1, 'Home', 'home', NULL, 1, 'home'),
(2, 'Events', '#', NULL, 3, 'events'),
(3, 'Gallery', 'gallery', NULL, 4, 'gallery'),
(4, 'Sign in', 'login', NULL, 5, 'login'),
(5, 'Announcement', 'announcement/page/', NULL, 2, 'announcement');

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
(1, 'Community Engagement', 'Artcore is free HTML5 template by <b class="blue">template</b><b class="green">mo</b>. Credit goes to <a rel="nofollow" href="http://unsplash.com">Unsplash</a> for photos.', 1, '#', 'See More', 'slide1', './uploads/banner/', '.jpg', 'community-engagement'),
(2, 'University of Perpetual Help', 'We come with new fresh and unique ideas.', 2, '#', 'See more', 'slide2', './uploads/banner/', '.jpg', 'university-of-perpetual-help'),
(3, 'Natural 3d Architecture Design', 'Natural concrete is a material which is calm and clean.', 3, '#', 'See more', 'slide3', './uploads/banner/', '.jpg', 'natural-3da-achitecture-design');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_beneficiaries`
--

INSERT INTO `cop_beneficiaries` (`id`, `first_name`, `last_name`, `gender`, `date_entered`, `date_modified`, `phone`, `address_street`, `address_city_id`, `imagename`, `deleted`) VALUES
(6, 'Ransu', 'Caw', 'Male', '2015-02-05 00:37:33', '2015-02-05 00:37:33', '[]', 'asdasdas', 4, '', 0),
(8, 'Kevin', 'Valencia', 'Female', '2015-02-18 19:46:25', '2015-02-18 19:46:25', '[]', 'las pinas', 1, '', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_description`
--

INSERT INTO `cop_description` (`description_id`, `event_id`, `description`, `sequence`) VALUES
(31, 15, '', 1),
(32, 16, '', 1),
(40, 23, 'LOREM IPSUM DOLOR ESMET', 1),
(43, 20, '', 1),
(44, 22, 'Aug 12, 2013 -&nbsp;<span>my class.inc file:S<!--?php class logout{ public function logout(){ ... You have to call the function mentioned below on the top your logout function in ...</span--></span>', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_events`
--

INSERT INTO `cop_events` (`event_id`, `owner_id`, `title`, `status`, `category_id`, `date_entered`, `date_start`, `date_end`, `time_start`, `time_end`, `location`, `slug`) VALUES
(20, 1, 'TECH TUTOR 5', 'open', 1, '2015-02-19 19:35:08', '2015-02-09', '2015-02-09', '22:30:PM', '22:30:PM', 'Dasd', 'tech-tutor-5'),
(22, 1, 'TECH TUTOR 7', 'open', 1, '2015-02-19 19:35:15', '2015-02-16', '2015-02-16', '22:30:PM', '22:30:PM', 'Sdfsdf', 'tech-tutor-7'),
(23, 1, 'COP EVENTS', 'open', 1, '2015-02-18 17:49:35', '2015-02-19', '2015-02-19', '20:45:PM', '20:45:PM', 'Asssssssss', 'cop-events');

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
(14, 7, '2015-02-09 02:27:47', NULL),
(14, 6, '2015-02-09 02:48:23', NULL),
(23, 6, '2015-02-19 12:50:04', NULL),
(20, 6, '2015-02-19 12:52:15', NULL),
(23, 8, '2015-02-19 14:46:33', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_gallery`
--

INSERT INTO `cop_gallery` (`gallery_id`, `event_id`, `cover_photo_id`, `title`, `description`, `date_entered`, `date_modified`, `slug`) VALUES
(17, NULL, '3', 'SUPER', '', '2015-02-19 12:50:28', '2015-02-19 12:50:28', 'super'),
(21, NULL, '25', 'dfsdf', '', '2015-02-19 18:16:16', '2015-02-19 18:16:16', 'dfsdf'),
(22, NULL, '17', 'asd', '', '2015-02-19 18:04:51', '2015-02-19 18:04:51', 'asd'),
(23, NULL, NULL, 'ssasdasdasdddddddddddddddddddd', '', '2015-02-20 04:44:54', '2015-02-20 04:44:54', 'ssasdasdasdddddddddddddddddddd');

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cop_gallery_photos`
--

INSERT INTO `cop_gallery_photos` (`gallery_photos_id`, `gallery_id`, `raw_name`, `file_path`, `file_ext`) VALUES
(3, 17, '10505527_857203360988587_2455090279547794881_n', 'uploads/gallery/', '.jpg'),
(9, 17, '13973_clippy', 'uploads/gallery/', '.jpg'),
(17, 22, '13973_clippy4', 'uploads/gallery/', '.jpg'),
(25, 21, 'Pedo_Bear', 'uploads/gallery/', '.gif');

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
  `address_city_id` int(11) DEFAULT NULL,
  `imagename` varchar(250) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `crypt_type` varchar(20) NOT NULL DEFAULT 'MD5'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cop_users`
--

INSERT INTO `cop_users` (`id`, `user_name`, `user_password`, `first_name`, `last_name`, `gender`, `is_admin`, `date_entered`, `date_modified`, `phone`, `email`, `status`, `address_street`, `address_city_id`, `imagename`, `deleted`, `crypt_type`) VALUES
(1, 'admin', '$1$ad000000$hzXFXvL3XVlnUE/X.1n9t/', 'Zhara', 'Gonzales', 'female', 'on', '2015-02-19 13:08:20', '0000-00-00 00:00:00', '[]', 'admin@gmail.com', 'Active', 'L18 B3 Belisario Subd.', 1, NULL, 0, 'PHP5.3MD5'),
(2, 'ransu', '$1$ra000000$kcBJP2.AQzMo5mBLnowMw1', 'ransu', 'ransu', 'female', 'on', '2015-02-05 07:36:56', '2015-02-02 18:02:51', '[]', '', 'Inactive', '', 1, NULL, 1, 'PHP5.3MD5'),
(3, 'ransus', '$1$ra000000$kcBJP2.AQzMo5mBLnowMw1', 'ransu', 'ransu', 'female', 'on', '2015-02-05 07:36:58', '2015-02-03 18:46:02', '[]', '', 'Inactive', '', 1, NULL, 1, 'PHP5.3MD5'),
(4, 'ish', '$1$is000000$WJSzElarDohtazA863l5S.', 'ish', 'landrito', 'female', 'on', '2015-02-20 12:06:37', '2015-02-19 17:05:38', '[]', '', 'Inactive', '', 1, NULL, 1, 'PHP5.3MD5'),
(5, 'ish', '$1$is000000$WJSzElarDohtazA863l5S.', 'Ish', 'Landrito', 'female', 'on', '2015-02-19 17:08:03', '2015-02-19 17:08:03', '[]', '', 'Active', '', 3, NULL, 0, 'PHP5.3MD5');

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
MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `cop_announcement_description`
--
ALTER TABLE `cop_announcement_description`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `cop_artcore_parenttab`
--
ALTER TABLE `cop_artcore_parenttab`
MODIFY `parenttab_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
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
MODIFY `description_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `cop_events`
--
ALTER TABLE `cop_events`
MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `cop_gallery`
--
ALTER TABLE `cop_gallery`
MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `cop_gallery_photos`
--
ALTER TABLE `cop_gallery_photos`
MODIFY `gallery_photos_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `cop_users`
--
ALTER TABLE `cop_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
