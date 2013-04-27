-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 26, 2013 at 02:23 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `frometou_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `defaultlangs`
--

CREATE TABLE IF NOT EXISTS `defaultlangs` (
  `langid` char(3) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`langid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `doc`
--

CREATE TABLE IF NOT EXISTS `doc` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `module_signature` char(20) COLLATE utf8_bin NOT NULL,
  `description_img` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `ident` varchar(200) COLLATE utf8_bin NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`did`),
  KEY `priority` (`priority`),
  KEY `ident` (`ident`),
  KEY `description_img` (`description_img`(333))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `doc_general_v`
--

CREATE TABLE IF NOT EXISTS `doc_general_v` (
  `did` int(11) NOT NULL,
  `langid` char(3) COLLATE utf8_bin NOT NULL,
  `linktext` varchar(150) COLLATE utf8_bin NOT NULL,
  `pagetitle` varchar(150) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `did_2` (`did`,`langid`),
  KEY `did` (`did`),
  KEY `langid` (`langid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `doc_module_v`
--

CREATE TABLE IF NOT EXISTS `doc_module_v` (
  `did` int(11) NOT NULL,
  `module` varchar(50) COLLATE utf8_bin NOT NULL,
  `prop_signature` varchar(50) COLLATE utf8_bin NOT NULL,
  `langid` char(3) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `did` (`did`,`prop_signature`,`langid`),
  KEY `text_signature` (`prop_signature`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `lang`
--

CREATE TABLE IF NOT EXISTS `lang` (
  `lname` varchar(30) COLLATE utf8_bin NOT NULL,
  `id` char(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `flagtext` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `thumbnail_path` varchar(70) COLLATE utf8_bin NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `shorthand` (`id`),
  UNIQUE KEY `langName` (`lname`),
  KEY `priority` (`priority`),
  KEY `flagpath` (`thumbnail_path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mapping`
--

CREATE TABLE IF NOT EXISTS `mapping` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL,
  `path` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `did` (`did`,`path`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `module_signature` varchar(20) COLLATE utf8_bin NOT NULL,
  `module_name` varchar(70) COLLATE utf8_bin NOT NULL,
  `display_path` varchar(150) COLLATE utf8_bin NOT NULL,
  `cms_path` varchar(100) COLLATE utf8_bin NOT NULL,
  `module_type` enum('page','general') COLLATE utf8_bin NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`module_signature`),
  UNIQUE KEY `module_signature` (`module_signature`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `module_props`
--

CREATE TABLE IF NOT EXISTS `module_props` (
  `module_signature` varchar(20) COLLATE utf8_bin NOT NULL,
  `signature` varchar(50) COLLATE utf8_bin NOT NULL,
  `property_name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`signature`),
  UNIQUE KEY `module_id_2` (`module_signature`,`property_name`),
  KEY `module_id` (`module_signature`),
  KEY `signature` (`signature`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
