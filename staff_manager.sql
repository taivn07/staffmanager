-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2015 at 11:52 AM
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `month_confirm`
--

INSERT INTO `month_confirm` (`id`, `month_accept`, `user_id`, `status`, `is_view`, `time_accept`) VALUES
(2, '2015-10-01', 1, 0, 0, '2015-10-28 08:44:23'),
(5, '2015-07-01', 1, 2, 1, '2015-10-28 11:47:23'),
(7, '2015-08-01', 1, 0, 1, '2015-10-28 11:46:39');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `staff_time`
--

INSERT INTO `staff_time` (`id`, `user_id`, `time_start`, `time_end`, `time_OT`) VALUES
(4, 1, '2015-10-22 08:30:00', '2015-10-22 17:25:00', '01:13:00'),
(5, 1, '2015-10-21 08:00:00', '2015-10-21 17:00:00', '00:00:00'),
(11, 1, '2015-10-02 08:00:00', '2015-10-02 17:00:00', '00:00:00'),
(15, 1, '2015-10-01 08:00:00', '2015-10-01 17:00:00', '02:00:00'),
(16, 1, '2015-10-03 08:10:00', '2015-10-03 18:10:00', '00:00:00'),
(17, 1, '2015-10-04 00:00:00', '2015-10-04 00:00:00', '01:00:00');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `user_pass`, `name`, `status`, `luong`, `image`) VALUES
(1, 'malever', 'fcea920f7412b5da7be0cf42b8c93759', 'Hà Minh Tuấn', 1, 75000000, 'uploadfile/010.jpg'),
(2, 'malever1', 'e10adc3949ba59abbe56e057f20f883e', '', 2, 0, 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpa1/v/t1.0-1/c0.14.160.160/p160x160/1625676_726343844057059_204737600_n.jpg?oh=3e16379088cdf072855cbd903ac23041&oe=56CDC27F&__gda__=1454699434_4b78896a8cefb295e0eada5ed96d3137');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
