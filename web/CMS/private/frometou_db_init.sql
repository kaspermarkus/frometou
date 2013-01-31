-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2013 at 09:33 PM
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
  `langid` int(11) NOT NULL,
  PRIMARY KEY (`langid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `defaultlangs`
--

INSERT INTO `defaultlangs` (`langid`) VALUES
(1),
(2);

-- --------------------------------------------------------

--
-- Table structure for table `doc`
--

CREATE TABLE IF NOT EXISTS `doc` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `module_signature` char(20) COLLATE utf8_bin NOT NULL,
  `typeid` int(11) NOT NULL,
  `description_img` int(11) NOT NULL DEFAULT '-1',
  `ident` varchar(200) COLLATE utf8_bin NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`did`),
  KEY `priority` (`priority`),
  KEY `typeid` (`typeid`),
  KEY `ident` (`ident`),
  KEY `description_img` (`description_img`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `doc`
--

INSERT INTO `doc` (`did`, `module_signature`, `typeid`, `description_img`, `ident`, `priority`) VALUES
(0, 'normal_page', 1, 0, 'home', 200);

-- --------------------------------------------------------

--
-- Table structure for table `doc_general_v`
--

CREATE TABLE IF NOT EXISTS `doc_general_v` (
  `did` int(11) NOT NULL,
  `langid` int(11) NOT NULL,
  `linktext` varchar(150) COLLATE utf8_bin NOT NULL,
  `pagetitle` varchar(150) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `did_2` (`did`,`langid`),
  KEY `did` (`did`),
  KEY `langid` (`langid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `doc_general_v`
--

INSERT INTO `doc_general_v` (`did`, `langid`, `linktext`, `pagetitle`, `description`) VALUES
(0, 1, 'Link hjemadimod', 'Dette er FORSIDEN', 'Saa koerer vi lige en DANSKERE'),
(0, 2, 'Link to Home', 'The Main Page', 'Some english descriptionses');

-- --------------------------------------------------------

--
-- Table structure for table `doc_module_v`
--

CREATE TABLE IF NOT EXISTS `doc_module_v` (
  `did` int(11) NOT NULL,
  `prop_signature` varchar(50) COLLATE utf8_bin NOT NULL,
  `langid` int(11) NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `did` (`did`,`prop_signature`,`langid`),
  KEY `text_signature` (`prop_signature`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `doc_module_v`
--

INSERT INTO `doc_module_v` (`did`, `prop_signature`, `langid`, `value`) VALUES
(0, 'normal_page_post_header', 1, 'Dette er den foerste sides'),
(0, 'normal_page_body_content', 1, '<p>	HALLO HALLO! Hallow</p><p>	&nbsp;</p><p>	##descriptionIndex##</p>'),
(0, 'normal_page_header', 1, 'Forsiden'),
(0, 'normal_page_header', 2, 'Hello Worldses'),
(0, 'normal_page_post_header', 2, 'Yes Hello Indeed'),
(0, 'normal_page_body_content', 2, '<p>	Yes, You might say that</p>');

-- --------------------------------------------------------

--
-- Table structure for table `dtype`
--

CREATE TABLE IF NOT EXISTS `dtype` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `ident` varchar(150) COLLATE utf8_bin NOT NULL,
  `priority` smallint(6) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `tid` (`tid`,`priority`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dtype`
--

INSERT INTO `dtype` (`tid`, `ident`, `priority`) VALUES
(1, 'Page', 100);

-- --------------------------------------------------------

--
-- Table structure for table `dtype_v`
--

CREATE TABLE IF NOT EXISTS `dtype_v` (
  `tid` int(11) NOT NULL,
  `langid` int(11) NOT NULL,
  `tname` varchar(100) COLLATE utf8_bin NOT NULL,
  KEY `langid` (`langid`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `dtype_v`
--

INSERT INTO `dtype_v` (`tid`, `langid`, `tname`) VALUES
(1, 2, 'Side');

-- --------------------------------------------------------

--
-- Table structure for table `hierarchy`
--

CREATE TABLE IF NOT EXISTS `hierarchy` (
  `hid` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `did` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`hid`),
  KEY `parent` (`parent`,`did`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Table structure for table `lang`
--

CREATE TABLE IF NOT EXISTS `lang` (
  `langid` smallint(6) NOT NULL AUTO_INCREMENT,
  `lname` varchar(30) COLLATE utf8_bin NOT NULL,
  `shorthand` char(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `flagtext` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `thumbnail_path` varchar(70) COLLATE utf8_bin NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`langid`),
  UNIQUE KEY `shorthand` (`shorthand`),
  UNIQUE KEY `langName` (`lname`),
  KEY `priority` (`priority`),
  KEY `flagpath` (`thumbnail_path`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `lang`
--

INSERT INTO `lang` (`langid`, `lname`, `shorthand`, `flagtext`, `thumbnail_path`, `priority`) VALUES
(1, 'Dansk', 'dk', 'Dansk version', 'imgs/dkflag.gif', 1000),
(2, 'English', 'uk', 'English Version', 'imgs/ukflag.gif', 120);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mapping`
--

INSERT INTO `mapping` (`mid`, `did`, `path`) VALUES
(1, 0, 'home');

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

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_signature`, `module_name`, `display_path`, `cms_path`, `module_type`, `enabled`) VALUES
('normal_page', 'Regular Page', 'modules/normal_page.php', 'modules/normal_page.php', 'page', 1),
('mod_subscription', 'Subscription Form', 'modules/mod_subscription.php', 'modules/mod_subscription_cms.php', 'page', 0);

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

--
-- Dumping data for table `module_props`
--

INSERT INTO `module_props` (`module_signature`, `signature`, `property_name`) VALUES
('mod_subscription', 'mod_subscription_header', 'Header'),
('normal_page', 'normal_page_post_header', 'Post Header'),
('normal_page', 'normal_page_body_content', 'Body'),
('normal_page', 'normal_page_header', 'Header'),
('mod_subscription', 'mod_subscription_success_text', 'Text displayed after subscription is made'),
('mod_subscription', 'mod_subscription_text_after_form', 'Text After Form'),
('mod_subscription', 'mod_subscription_reset_button_text', 'Text on Reset Button'),
('mod_subscription', 'mod_subscription_submit_button_text', 'Text on Submit Button'),
('mod_subscription', 'mod_subscription_email', 'Email Address Label'),
('mod_subscription', 'mod_subscription_fullname', 'Fullname Label'),
('mod_subscription', 'mod_subscription_form_header', 'Form Header'),
('mod_subscription', 'mod_subscription_text_before_form', 'Text Before Form'),
('mod_subscription', 'mod_subscription_post_header', 'Post Header'),
('mod_subscription', 'mod_subscription_email_subject', 'Text for email subject line'),
('mod_subscription', 'mod_subscription_email_body', 'The message that should go in the email');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
