-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 07, 2013 at 04:23 PM
-- Server version: 5.1.42
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `dept` int(3) NOT NULL,
  `course_number` int(3) NOT NULL DEFAULT '0',
  `section_number` int(2) NOT NULL DEFAULT '0',
  `course_title` varchar(255) DEFAULT NULL,
  `prereqs` varchar(255) DEFAULT NULL,
  `netid` varchar(30) NOT NULL,
  `num_spn` int(11) NOT NULL DEFAULT '10',
  `room_size` int(3) NOT NULL DEFAULT '50',
  `given` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`dept`,`course_number`,`section_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_requests`
--

CREATE TABLE IF NOT EXISTS `course_requests` (
  `requestid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `ruid` int(11) DEFAULT NULL,
  `netid` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dept` varchar(100) DEFAULT NULL,
  `course_number` int(11) DEFAULT NULL,
  `section_number` int(11) DEFAULT NULL,
  `course_title` varchar(255) DEFAULT NULL,
  `gpa` float DEFAULT NULL,
  `grad_year` year(4) DEFAULT NULL,
  `is_retaking` tinyint(4) DEFAULT NULL,
  `major` varchar(100) DEFAULT NULL,
  `is_required` tinyint(4) DEFAULT NULL,
  `prereqs` varchar(255) DEFAULT NULL,
  `explanation` varchar(1000) DEFAULT NULL,
  `comments` varchar(1000) DEFAULT NULL,
  `submission_time` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '-1',
  `special_permission_number` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`requestid`),
  KEY `name` (`name`),
  KEY `ruid` (`ruid`),
  KEY `netid` (`netid`),
  KEY `email` (`email`),
  KEY `dept` (`dept`),
  KEY `course_number` (`course_number`),
  KEY `section_number` (`section_number`),
  KEY `course_title` (`course_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to` varchar(255) NOT NULL DEFAULT 'MySQL Default',
  `from` varchar(255) NOT NULL DEFAULT 'Rutgers SPN System Default MySQL Value',
  `subject` varchar(255) NOT NULL DEFAULT 'Default Subject',
  `message` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
  `ruid` int(11) NOT NULL,
  `dept` int(3) NOT NULL,
  `course_number` int(3) NOT NULL,
  `section_number` int(2) NOT NULL,
  `grade` varchar(2) NOT NULL DEFAULT 'IP'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `netid` varchar(30) NOT NULL DEFAULT '',
  `ruid` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `auth` int(1) NOT NULL,
  PRIMARY KEY (`netid`,`ruid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
