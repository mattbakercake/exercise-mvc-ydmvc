-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2014 at 05:39 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `framework`
--

-- --------------------------------------------------------

--
-- Table structure for table `fruit`
--

CREATE TABLE IF NOT EXISTS `fruit` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `fruit`
--

INSERT INTO `fruit` (`id`, `name`) VALUES
(2, 'Apple'),
(1, 'Banana'),
(3, 'Pear'),
(4, 'Plum');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `surname` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `fruit` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fruit` (`fruit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=20 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `surname`, `fruit`) VALUES
(1, 'Han', 'Solo', 3),
(2, 'Joe', 'Blogs', 1),
(3, 'Frank', 'Smith', 3),
(4, 'Jane', 'Jones', 4),
(5, 'Fred', 'Smith', 3),
(6, 'Janice', 'Blogs', 2),
(7, 'Jon', 'Jones', 3),
(8, 'Joseph', 'Blah', 1),
(9, 'Mike', 'Stead', 2),
(10, 'John', 'Smith', 3),
(11, 'Luke', 'Skywalker', 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`fruit`) REFERENCES `fruit` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
