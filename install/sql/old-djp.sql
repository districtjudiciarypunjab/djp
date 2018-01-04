-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2017 at 11:19 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `djp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_preferences`
--

CREATE TABLE `admin_preferences` (
  `id` tinyint(1) NOT NULL,
  `user_panel` tinyint(1) NOT NULL DEFAULT '0',
  `sidebar_form` tinyint(1) NOT NULL DEFAULT '0',
  `messages_menu` tinyint(1) NOT NULL DEFAULT '0',
  `notifications_menu` tinyint(1) NOT NULL DEFAULT '0',
  `tasks_menu` tinyint(1) NOT NULL DEFAULT '0',
  `user_menu` tinyint(1) NOT NULL DEFAULT '1',
  `ctrl_sidebar` tinyint(1) NOT NULL DEFAULT '0',
  `transition_page` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_preferences`
--

INSERT INTO `admin_preferences` (`id`, `user_panel`, `sidebar_form`, `messages_menu`, `notifications_menu`, `tasks_menu`, `user_menu`, `ctrl_sidebar`, `transition_page`) VALUES
(1, 0, 0, 0, 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cases_type`
--

CREATE TABLE `cases_type` (
  `id` int(11) NOT NULL,
  `case_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cases_type`
--

INSERT INTO `cases_type` (`id`, `case_type`) VALUES
(1, 'Criminal'),
(2, 'Civil');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(50) DEFAULT NULL,
  `court_type_id` int(11) DEFAULT NULL,
  `case_type_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `active` varchar(10) DEFAULT NULL,
  `sorting` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`, `court_type_id`, `case_type_id`, `cat_id`, `active`, `sorting`) VALUES
(15, 'Sessions Murder', 1, 1, NULL, 'Yes', 2),
(16, 'Sessions Other', 1, 1, NULL, 'Yes', 3),
(17, 'Women Cases', NULL, 1, 15, 'Yes', 0),
(18, 'Juvenile Cases', NULL, 1, 15, 'Yes', 0),
(19, 'Narcotics Cases', 1, 1, NULL, 'Yes', 4),
(20, 'Appeal', 1, 2, NULL, 'Yes', 0),
(21, 'Family Appeal', NULL, 2, 20, 'Yes', 0),
(22, 'Bail Application', 1, 1, NULL, 'Yes', 1),
(23, 'Post-arrest', NULL, 1, 22, 'Yes', 0),
(24, 'Pre-arrest', NULL, 1, 22, 'Yes', 0),
(25, 'Cancellation of bail', NULL, 1, 22, 'Yes', 0),
(26, 'Illegal Dispossession Act', 1, 1, NULL, 'Yes', 8),
(63, 'Other Cases', 1, 1, NULL, 'Yes', 0),
(64, 'Other Cases', 2, 1, NULL, 'Yes', 0),
(65, 'Other Cases', 1, 2, NULL, 'Yes', 0),
(66, 'Other Cases', 2, 2, NULL, 'Yes', 0);

-- --------------------------------------------------------

--
-- Table structure for table `courts`
--

CREATE TABLE `courts` (
  `id` int(11) NOT NULL,
  `court_number` varchar(30) NOT NULL,
  `judge_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `court_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `sorting` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courts`
--

INSERT INTO `courts` (`id`, `court_number`, `judge_id`, `city_id`, `court_type_id`, `user_id`, `sorting`) VALUES
(27, 'Fsd 1', 3, 7, 1, 8, 0),
(28, 'Fsd 2', 14, 5, 1, 25, 0),
(30, 'Fsd 3', 14, 4, 1, 4, 0),
(31, 'Fsd 122', 14, 15, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `courts_type`
--

CREATE TABLE `courts_type` (
  `id` int(11) NOT NULL,
  `court_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courts_type`
--

INSERT INTO `courts_type` (`id`, `court_type`) VALUES
(1, 'Sessions'),
(2, 'Civil');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(11) NOT NULL,
  `desgn_name` varchar(100) NOT NULL,
  `desgn_short_name` varchar(10) NOT NULL,
  `sorting` smallint(6) DEFAULT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `desgn_name`, `desgn_short_name`, `sorting`, `active`) VALUES
(6, 'District & Sessions Judge', 'D & SJ', 1, 'Yes'),
(7, 'Addl: District & Sessions Judge', 'ASJ', 2, 'Yes'),
(8, 'Senior Civil Judge', 'Senior CJ', 3, 'Yes'),
(9, 'Civil Judge', 'CJ', 4, 'Yes'),
(10, 'Magistrate Section-30 (Class-I)', 'Class-I', 5, 'Yes'),
(11, 'Judicial Magistrate (Class-I)', 'Class-I', 6, 'Yes'),
(12, 'Judicial Magistrate', 'CJ', 7, 'Yes'),
(13, 'Civil Judge Family Court', 'CJ', 8, 'Yes'),
(14, 'Civil Judge (Class-I)', 'Class-I', 5, 'Yes'),
(15, 'Civil Judge (Class-II)', 'Class-II', 6, 'Yes'),
(16, 'Civil Judge (Class-III)', 'Class-III', 10, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `city_name` varchar(50) NOT NULL,
  `teh_id` int(11) DEFAULT NULL,
  `active` varchar(10) NOT NULL,
  `sorting` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `city_name`, `teh_id`, `active`, `sorting`) VALUES
(1, 'Lahore', NULL, 'Yes', 1),
(2, 'Faisalabad', NULL, 'Yes', 2),
(3, 'Multan', NULL, 'Yes', 3),
(4, 'Sumandari', 2, 'Yes', 1),
(5, 'Jaranwala', 2, 'Yes', 2),
(6, 'Tandlianwala', 2, 'Yes', 3),
(7, 'Faisalabad', 2, 'Yes', 0),
(8, 'Lahore Tehsil 1', 1, 'Yes', 1),
(9, 'L Tehsil-2', 1, 'Yes', 2),
(10, 'L Tehsil-3', 1, 'Yes', 3),
(11, 'M Tehsil-1', 3, 'Yes', 1),
(12, 'M Tehsil-2', 3, 'Yes', 2),
(13, 'M Tehsil-3', 3, 'Yes', 3),
(14, 'Jhang', NULL, 'Yes', 3),
(15, 'Jhang', 14, 'Yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `bgcolor` char(7) NOT NULL DEFAULT '#607D8B'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `bgcolor`) VALUES
(1, 'admin', 'Administrator', '#f44336'),
(2, 'members', 'General User', '#2196F3'),
(3, 'super', 'Super Users', '#ff5722'),
(4, 'district', 'Admin user of districts', '#009688');

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `id` int(11) NOT NULL,
  `judge_name` varchar(100) DEFAULT NULL,
  `cnic` varchar(16) NOT NULL,
  `desgn_id` int(11) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `date_of_retirement` date DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `seniority` int(11) DEFAULT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`id`, `judge_name`, `cnic`, `desgn_id`, `date_of_birth`, `date_of_joining`, `date_of_retirement`, `city_id`, `gender`, `seniority`, `active`) VALUES
(1, 'Rai Aftab Ahmad', '33299-8887776-6', 7, '2017-12-11', '2017-12-11', '2017-12-11', 3, 'Male', 11, 'No'),
(2, 'Abid Hussain Quraishi', '', 6, '2017-12-11', '2017-12-11', '2017-12-11', 3, 'Male', 331, 'Yes'),
(3, 'Abid Hussain Quraishi', '33100-3333333-1', 6, '2017-12-11', '2017-12-11', '2017-12-11', 1, 'Male', 121, 'Yes'),
(7, 'Shafqat Abbass', '', 9, '2017-12-14', '2017-12-14', '2017-12-14', NULL, 'Male', 0, ''),
(8, 'Rana Shoukat Ali', '33122-2666666-6', 7, '2017-12-14', '2017-12-14', '2017-12-14', 1, 'Male', 0, 'No'),
(9, 'Rana Shoukat Ali', '', 7, '2017-12-14', '2017-12-14', '2017-12-14', NULL, 'Male', 111, ''),
(10, 'Abid Hussain Quraishi', '', 6, '2017-12-11', '2017-12-11', '2017-12-11', NULL, 'Male', 121, 'Yes'),
(11, 'Abid Ali', '', 8, '2017-12-14', '2017-12-14', '0000-00-00', 3, 'Male', 0, 'Yes'),
(12, 'Shahid Khan', '', 7, '0000-00-00', '0000-00-00', '0000-00-00', NULL, 'Male', 0, 'Yes'),
(13, 'Shafqat Abbass', '', 9, '2017-12-14', '2017-12-14', '2017-12-14', 3, 'Male', 0, 'Yes'),
(14, 'Abid Hussain Quraishi', '33100-3333333-3', 6, '2017-12-11', '2017-12-11', '2017-12-11', 1, 'Male', 121, 'Yes'),
(19, 'Qamar Yaseen', '', 7, '0000-00-00', '0000-00-00', '0000-00-00', 2, 'Male', 0, 'Yes'),
(20, 'Muhammad Ilyas Rehan', '', 7, '0000-00-00', '0000-00-00', '0000-00-00', 2, 'Male', 0, 'Yes'),
(21, 'Muhammad Usman', '', 7, '0000-00-00', '0000-00-00', '0000-00-00', 1, 'Male', 0, 'Yes'),
(22, 'Muhammad Waris', '31000-3333333-3', 7, '0000-00-00', '0000-00-00', '0000-00-00', 2, 'Male', 0, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `public_preferences`
--

CREATE TABLE `public_preferences` (
  `id` int(1) NOT NULL,
  `transition_page` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `public_preferences`
--

INSERT INTO `public_preferences` (`id`, `transition_page`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `city_id` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `city_id`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, 'ubbKewRMYv31hKaEQcspdO', 1268889823, 1514280922, 1, 'Admin', 'istrator', 'ADMIN', '0', 0),
(2, '::1', 'waris', '$2y$08$T/J0wxK/karJnDpatdPCs.ddOj49k35Nel9Gc73MDa69O4w9/lcNO', NULL, 'user@admin.com', NULL, NULL, NULL, 'TkFkFCz9BRUYpPf7zEoGsO', 1512553577, 1512663067, 1, 'Malik1', 'Waris1', 'DSC Fsd1', '03007201629', 0),
(3, '::1', '', '$2y$08$ufAZIb7A2O.EgRidvi0a1OLQifH5T0JdbAdXF/X3GLd0T3OZCzxh2', NULL, 'super@admin.com', NULL, NULL, NULL, 'U9F82jQp08YIHehPODXfue', 1512570361, 1512581093, 1, 'User', 'Super', 'DSC Fsd', '03139201629', 0),
(4, '::1', 'Faisalabad', '$2y$08$HhsSGBETyiSCbBM0Xz2ugOh5xA2akfxaH0oTa/yeaqdU1802IYshO', NULL, 'fsd@admin.com', NULL, NULL, NULL, NULL, 1512972787, 1513810943, 1, 'Faisalabad', 'User', '', '0300-7201629', 2),
(5, '::1', 'ishfaq', '$2y$08$aFiAevMocfM9cabNMIICGugvGLnlwYmkY9G5itGQxzOJtEjN3ZE12', NULL, 'ishfaq11@admin.com', NULL, NULL, NULL, NULL, 1512976414, NULL, 1, 'Muhammad', 'Ishfaq', 'Jhang', '03007373777', 12),
(6, '::1', '', '$2y$08$wD.8saaPyFHXtlDYA9712Ol7sabVkPCZ6/NWcVXq5sNNOabbw0qzK', NULL, 'ishfaq1@admin.com', NULL, NULL, NULL, NULL, 1512977238, NULL, 1, 'Ali', 'Raza', 'Faisalabad', '9999-9999999', 1),
(7, '::1', '', '$2y$08$SRjNmGHFsx90/bGRrrd/0uOlJyY28e/mG8EAxPfkwrhgX7gwTD72i', NULL, 'user1@admin.com', NULL, NULL, NULL, NULL, 1513012412, NULL, 1, 'Malik', 'Waris', 'DSC Fsd', '888888888', 0),
(8, '::1', 'Bilal Raza', '$2y$08$0O6iZLmGQ/fzh7faBc6Jhe9URKwPoBE5XL7wgjF/M5xawKbCF8Qyy', NULL, 'bilal@admin.com', NULL, NULL, NULL, NULL, 1513012492, 1513834708, 1, 'Bilal', 'raza', 'Lahore', '8888-8888822', 2),
(9, '::1', 'sdfsadf', '$2y$08$7b0ZvKvdbZSBnIJoKRLXrepiP19ClybeS/3yf1f2kplL9rVxT5RnS', NULL, 'dsr@admin.com', NULL, NULL, NULL, NULL, 1513012567, NULL, 1, 'sdfsadf', 'sdfsdaf', 'sadfsdaf', '55555555555', 0),
(10, '::1', '1111', '$2y$08$9v7Ncof6cLVqFSJS7Xor8uuAW9W/KoWpB0foMiktZZR/u3pNHOnaC', NULL, 'fasd@gmail.com', NULL, NULL, NULL, NULL, 1513013150, NULL, 1, 'Bilal', 'akhtar', 'fasd', '1111222211', 0),
(11, '::1', '111', '$2y$08$5FdMq.MaltWruddzcGqPRuZxbgmXcJBHl5K5nLZZJqx1kB.FBUtZG', NULL, 'bilalbs@admin.com', NULL, NULL, NULL, NULL, 1513013456, NULL, 1, 'Malik', 'Fsd', 'DSC Fsd', '999999999', 0),
(12, '::1', 'sdfsdf', '$2y$08$zozL7ZbyC/YU7D2wr7h4JOc9bixvUxaZUzhXzfb2Yizk1jXVoi4O2', NULL, 'user111@admin.com', NULL, NULL, NULL, NULL, 1513013677, NULL, 1, 'Malik', 'Waris', 'DSC Fsd', '55555555555', 0),
(13, '::1', '111aaa', '$2y$08$.6Y26DLAKBSQBbF/pGUa5e5okwi2Dd7D1xVnk8HZWQlCfeDMgjk9O', NULL, 'sdfsdf555@gmail.com', NULL, NULL, NULL, NULL, 1513013897, NULL, 1, 'sadfsadf', 'sadfsadf', 'sdfsdf', '555555554', 0),
(14, '::1', '', '$2y$08$5RQla3U.TO6RXT8PMhfvPuuIx1m.6s4Q0I1alje1eeHGQ1Y7GvjY2', NULL, 'faisalabad1111@admin.com', NULL, NULL, NULL, NULL, 1513017648, NULL, 1, 'Bilal', 'Waris', 'DSC Fsd', '09999998888', 1),
(15, '::1', 'ds170400054', '$2y$08$Z0ldKDRogI/r33R1L/86CunwWlrjyJWEJ7JHwuNxrxmCShALnNEce', NULL, 'user@admin111.com', NULL, NULL, NULL, NULL, 1513024357, NULL, 1, 'Malik', 'Waris', 'DSC Fsd', '8887777776', 0),
(16, '::1', '', '$2y$08$qa.8JKh3bnQGjX8ziUwcbuFHr7b0l7XXt9YnpI./2.j/85w0LYPem', NULL, 'bila11l@admin.com', NULL, NULL, NULL, NULL, 1513024508, NULL, 1, 'Malik', 'Waris', 'DSC Fsd', '999999999', 0),
(17, '::1', '', '$2y$08$Lado4e3zhn9Pk1ue.tZoHOkcjCZvEZXc3E8rTOYB.D21qR1qmKa2a', NULL, 'dsr11@admin.com', NULL, NULL, NULL, NULL, 1513024677, NULL, 1, 'Bilal', 'Super', 'DSC Fsd', '6666555555', 0),
(18, '::1', '', '$2y$08$ccrT091D57Zdt/1nfuAfRu8UVwdm1ErWU7dJECnxPl0opDvSgOopq', NULL, 'dsr111@admin.com', NULL, NULL, NULL, NULL, 1513024743, NULL, 1, 'Bilal', 'Super', 'DSC Fsd', '6666555555', 0),
(19, '::1', 'ds1704000541111', '$2y$08$W6mE/PTfPGTmwtwJXrkSZOStrxhJeWdU4WkEKL4qPDJDtEf.fJI02', NULL, 'ds1111r1111@admin.com', NULL, NULL, NULL, NULL, 1513025649, NULL, 1, 'Bilal', 'Super', 'DSC Fsd', '6666-5555551', 13),
(20, '::1', 'shahid malik1', '$2y$08$m1NELWhqgcyo9iCAYYcYfud.BV1CM3Eu8q/1FDVb428/GpyOifwvy', NULL, 'shahidmalik@admin.com', NULL, NULL, NULL, NULL, 1513025711, NULL, 1, 'Shahid', 'Malik', 'Faisalabad', '03007201629', 0),
(21, '::1', 'shahid khan', '$2y$08$dv6z677FkVAKFIHS8Is2Ou3FdbUhNUVVmgjw5fxbTAOAwWOKuOfsa', NULL, 'shahidkhan@wix.com', NULL, NULL, NULL, NULL, 1513070287, NULL, 1, 'Mian Shahid', 'Khan', 'wix', '9999999999999', 0),
(22, '::1', 'ghulam mustafa', '$2y$08$t6/HUFkDfdPLgpRZDin.XuhteAiRM4v7bVb2J0RlkhqsbaYIKar5C', NULL, 'ghulammustafa@admin.com', NULL, NULL, NULL, NULL, 1513070723, NULL, 1, 'Ghulam', 'Mustafa', 'Faisalabad', '9999999999', 0),
(23, '::1', 'muhammad shahid', '$2y$08$QNbbAga07OO7wm/U1uT5eurGD5hB24bicq/ie43bDzjNJ9m5CbefS', NULL, 'shahid@admin.com', NULL, NULL, NULL, NULL, 1513098143, NULL, 1, 'Muhammad', 'Shahid', '3', '1111-1111111', 0),
(24, '::1', 'ghulam qadir', '$2y$08$VvF0TJWri1v7xcz.FAvGdupRXG5fzKVxKnvwrVFlVoRe6w4FhjBkK', NULL, 'ghulam@gmail.com', NULL, NULL, NULL, NULL, 1513098721, NULL, 1, 'Ghulam', 'Qadir', 'Wix Zoon', '0300-8888222', 0),
(25, '::1', 'ghulam qadir1', '$2y$08$u9dqKwTBifC8u4UuiMfUKOwW9QNlWX9EYUTJLwRUPABX7pjJIwyia', NULL, 'itbest@admin.com', NULL, NULL, NULL, NULL, 1513098876, NULL, 1, 'Ghualm', 'Qadir', 'wiz dev', '7777-7777777', 2),
(26, '::1', 'malik asghar', '$2y$08$oW/H4WuEZzjcxuO3NsCpgedrxmVipMlpmsn7B3EHrHOcE5vNnVNFW', NULL, 'asghar@admin.com', NULL, NULL, NULL, NULL, 1513115323, NULL, 1, 'Malik', 'Asghar', 'Colleges Department', '0313-8776622', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(7, 2, 2),
(5, 3, 3),
(55, 4, 4),
(49, 5, 4),
(59, 6, 2),
(18, 7, 2),
(58, 8, 2),
(21, 9, 2),
(27, 10, 2),
(26, 11, 2),
(25, 12, 2),
(29, 13, 2),
(50, 14, 2),
(32, 15, 2),
(33, 16, 2),
(34, 17, 2),
(35, 18, 2),
(51, 19, 2),
(38, 20, 2),
(39, 21, 2),
(40, 22, 2),
(41, 23, 2),
(42, 24, 2),
(60, 25, 2),
(53, 26, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_preferences`
--
ALTER TABLE `admin_preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cases_type`
--
ALTER TABLE `cases_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `court_type_id` (`court_type_id`),
  ADD KEY `case_type_id` (`case_type_id`);

--
-- Indexes for table `courts`
--
ALTER TABLE `courts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `court_type_id` (`court_type_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `courts_type`
--
ALTER TABLE `courts_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teh_id` (`teh_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `judges`
--
ALTER TABLE `judges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `desgn_id` (`desgn_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `public_preferences`
--
ALTER TABLE `public_preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_preferences`
--
ALTER TABLE `admin_preferences`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cases_type`
--
ALTER TABLE `cases_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `courts`
--
ALTER TABLE `courts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `courts_type`
--
ALTER TABLE `courts_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `public_preferences`
--
ALTER TABLE `public_preferences`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_casest_fk` FOREIGN KEY (`case_type_id`) REFERENCES `cases_type` (`id`),
  ADD CONSTRAINT `categories_courtst_fk` FOREIGN KEY (`court_type_id`) REFERENCES `courts_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_id_fk` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courts`
--
ALTER TABLE `courts`
  ADD CONSTRAINT `courts_city_fk` FOREIGN KEY (`city_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `courts_courtst_fk` FOREIGN KEY (`court_type_id`) REFERENCES `courts_type` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `courts_judge_fk` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `courts_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `tehsil_fk` FOREIGN KEY (`teh_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `judges`
--
ALTER TABLE `judges`
  ADD CONSTRAINT `judges_designation_fk` FOREIGN KEY (`desgn_id`) REFERENCES `designation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `judges_domicile_fk` FOREIGN KEY (`city_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
