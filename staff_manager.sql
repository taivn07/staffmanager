-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2015 at 05:22 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `staff_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `month_confirm`
--

CREATE TABLE IF NOT EXISTS `month_confirm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month_accept` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `is_view` tinyint(4) NOT NULL,
  `time_accept` datetime NOT NULL,
  `luong_inmonth` float NOT NULL,
  `reason` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `month_confirm`
--

INSERT INTO `month_confirm` (`id`, `month_accept`, `user_id`, `status`, `is_view`, `time_accept`, `luong_inmonth`, `reason`) VALUES
(10, '2015-10-01', 1, 0, 1, '2015-10-30 10:21:22', 19705300, ''),
(11, '2015-09-01', 1, 2, 1, '2015-10-30 11:37:19', 0, 'sida'),
(12, '2015-11-01', 1, 2, 0, '0000-00-00 00:00:00', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `staff_time`
--

CREATE TABLE IF NOT EXISTS `staff_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time_start` datetime NOT NULL,
  `time_end` datetime NOT NULL,
  `time_OT` time NOT NULL,
  `is_day_leave` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `staff_time`
--

INSERT INTO `staff_time` (`id`, `user_id`, `time_start`, `time_end`, `time_OT`, `is_day_leave`) VALUES
(4, 1, '2015-10-22 08:30:00', '2015-10-22 17:25:00', '01:13:00', 0),
(5, 1, '2015-10-21 08:00:00', '2015-10-21 17:00:00', '00:00:00', 0),
(11, 1, '2015-10-02 08:00:00', '2015-10-02 17:00:00', '00:00:00', 0),
(15, 1, '2015-10-01 08:00:00', '2015-10-01 17:00:00', '02:00:00', 0),
(16, 1, '2015-10-03 08:10:00', '2015-10-03 18:10:00', '00:00:00', 0),
(17, 1, '2015-10-04 00:00:00', '2015-10-04 00:00:00', '01:00:00', 0),
(18, 1, '2015-10-23 08:00:00', '2015-10-23 18:00:00', '00:00:00', 0),
(23, 1, '2015-11-03 08:00:00', '2015-11-03 17:00:00', '00:00:00', 0),
(24, 1, '2015-11-09 12:34:00', '2015-11-09 12:34:00', '01:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `user_pass` varchar(32) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `luong` double NOT NULL,
  `image` varchar(500) NOT NULL,
  `day_leave` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `user_pass`, `name`, `status`, `luong`, `image`, `day_leave`, `email`) VALUES
(1, 'malever', 'fcea920f7412b5da7be0cf42b8c93759', 'Hà Minh Tuấn', 1, 75000000, 'uploadfile/dac07e2573045635cc294059c02cee74paper-571937_1920.jpg', 5, 'baquevn17@gmail.com'),
(2, 'malever1', 'e10adc3949ba59abbe56e057f20f883e', '', 2, 0, 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpa1/v/t1.0-1/c0.14.160.160/p160x160/1625676_726343844057059_204737600_n.jpg?oh=3e16379088cdf072855cbd903ac23041&oe=56CDC27F&__gda__=1454699434_4b78896a8cefb295e0eada5ed96d3137', 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
