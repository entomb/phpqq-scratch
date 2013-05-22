-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2013 at 08:55 PM
-- Server version: 5.5.31-0ubuntu0.12.10.1
-- PHP Version: 5.4.6-1ubuntu1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `qqserver`
--

-- --------------------------------------------------------

--
-- Table structure for table `qq_run`
--

CREATE TABLE IF NOT EXISTS `qq_run` (
  `qq_run_id` int(11) NOT NULL AUTO_INCREMENT,
  `qq_server_id` int(11) DEFAULT '0',
  `time_start` varchar(100) DEFAULT '',
  `time_end` varchar(100) DEFAULT '',
  `_SERVER` text NOT NULL,
  `_POST` text NOT NULL,
  `_GET` text NOT NULL,
  `_ENV` text NOT NULL,
  PRIMARY KEY (`qq_run_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `qq_run_event`
--

CREATE TABLE IF NOT EXISTS `qq_run_event` (
  `qq_run_event_id` int(11) NOT NULL AUTO_INCREMENT,
  `qq_run_id` int(11) NOT NULL DEFAULT '0',
  `time` varchar(100) DEFAULT NULL,
  `block` varchar(100) DEFAULT NULL,
  `event` varchar(100) DEFAULT NULL,
  `value` varchar(100) NOT NULL DEFAULT '',
  `id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`qq_run_event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=492 ;


-- --------------------------------------------------------

--
-- Table structure for table `qq_server`
--

CREATE TABLE IF NOT EXISTS `qq_server` (
  `qq_server_id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(200) NOT NULL DEFAULT '',
  `server` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`qq_server_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `qq_server`
--

INSERT INTO `qq_server` (`qq_server_id`, `api_key`, `server`) VALUES
(1, 'ab045a04c73f32ae92f3b0690ed98aeb', 'testing');

-- --------------------------------------------------------

--
-- Table structure for table `qq_server_payload`
--

CREATE TABLE IF NOT EXISTS `qq_server_payload` (
  `qq_server_payload_id` int(11) NOT NULL AUTO_INCREMENT,
  `qq_server_id` int(11) DEFAULT NULL,
  `payload` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `flag_processed` int(1) NOT NULL DEFAULT '0',
  `qq_run_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`qq_server_payload_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=35 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;