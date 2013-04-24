-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2013 at 04:43 PM
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

--
-- Dumping data for table `defaultlangs`
--

INSERT INTO `defaultlangs` (`langid`) VALUES
('dk'),
('uk');

-- --------------------------------------------------------

--
-- Table structure for table `doc`
--

CREATE TABLE IF NOT EXISTS `doc` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `module_signature` char(20) COLLATE utf8_bin NOT NULL,
  `description_img` int(11) NOT NULL DEFAULT '-1',
  `ident` varchar(200) COLLATE utf8_bin NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`did`),
  KEY `priority` (`priority`),
  KEY `ident` (`ident`),
  KEY `description_img` (`description_img`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=111 ;

--
-- Dumping data for table `doc`
--

INSERT INTO `doc` (`did`, `module_signature`, `description_img`, `ident`, `priority`) VALUES
(107, 'normal_page', 0, 'new document', 100),
(105, 'normal_page', 0, '.pp.', 100),
(106, 'normal_page', 0, 'new documoeent', 100),
(103, 'normal_page', 0, 'sub1,2', 100),
(104, 'normal_page', 0, 'sub1/2', 100),
(0, 'normal_page', 0, 'DeleteMe', 100),
(102, 'normal_page', 0, 'sub2', 100),
(101, 'normal_page', 0, 'sub1', 100),
(92, 'normal_page', 0, 'page 3', 100),
(91, 'normal_page', 0, 'page 2', 100),
(90, 'normal_page', 0, 'page 1', 100),
(108, 'normal_page', 0, 'new document', 100),
(109, 'normal_page', 0, 'new document', 100),
(110, 'normal_page', 0, 'new document', 100);

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

--
-- Dumping data for table `doc_general_v`
--

INSERT INTO `doc_general_v` (`did`, `langid`, `linktext`, `pagetitle`, `description`) VALUES
(0, 'dk', 'Link hjem og dette er en lang link titel', 'Dette er FORSIDEN', 0x536161206b6f65726572207669206c69676520656e2044414e534b455245),
(0, 'uk', 'Link to Home', 'The Main Page', 0x536f6d6520656e676c697368206465736372697074696f6e7365),
(106, 'dk', '', '', ''),
(92, 'uk', 'page 3', 'page 3', 0x706167652033),
(105, 'dk', '', '.p', ''),
(104, 'dk', 'sub1/2', 'sub1/2', 0x737562312f32),
(101, 'dk', 'sub1', 'sub1', 0x73756231),
(90, 'dk', 'page 1', 'page 1', 0x706167652031),
(91, 'dk', 'page 2', 'page 2', 0x706167652032),
(92, 'dk', 'page 3', 'page 3', 0x706167652033),
(94, 'dk', 'newbe', 'newbe', 0x6e65776265),
(93, 'dk', '', '', ''),
(96, 'dk', 'DeleteMe', 'DeleteMe', 0x44656c6574654d65),
(102, 'dk', 'sub2', 'sub2', 0x73756232),
(103, 'dk', 'sub1,2o', 'sub1,2', 0x737562312c32);

-- --------------------------------------------------------

--
-- Table structure for table `doc_module_v`
--

CREATE TABLE IF NOT EXISTS `doc_module_v` (
  `did` int(11) NOT NULL,
  `prop_signature` varchar(50) COLLATE utf8_bin NOT NULL,
  `langid` char(3) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `did` (`did`,`prop_signature`,`langid`),
  KEY `text_signature` (`prop_signature`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `doc_module_v`
--

INSERT INTO `doc_module_v` (`did`, `prop_signature`, `langid`, `value`) VALUES
(0, 'normal_page_header', 'uk', 0x48656c6c6f20576f726c6473),
(0, 'normal_page_post_header', 'uk', 0x5965732048656c6c6f20496e64656564),
(0, 'normal_page_body_content', 'uk', 0x3c703e0d0a095965732c20596f75206d696768742073617920746861743c2f703e0d0a),
(106, 'normal_page_body_content', 'dk', 0x3c703e0d0a092e3c2f703e0d0a),
(0, 'normal_page_header', 'dk', 0x466f72736964653f),
(0, 'normal_page_post_header', 'dk', 0x6e657720646f63756d656e74),
(0, 'normal_page_body_content', 'dk', 0x3c703e0d0a096e657720646f63756d656e743c2f703e0d0a),
(106, 'normal_page_post_header', 'dk', ''),
(106, 'normal_page_header', 'dk', ''),
(101, 'normal_page_body_content', 'dk', 0x3c703e0d0a09737562313c2f703e0d0a),
(102, 'normal_page_header', 'dk', 0x73756232),
(102, 'normal_page_post_header', 'dk', 0x73756232),
(102, 'normal_page_body_content', 'dk', 0x3c703e0d0a09737562323c2f703e0d0a),
(103, 'normal_page_header', 'dk', 0x737562312c32),
(103, 'normal_page_post_header', 'dk', 0x737562312c32),
(103, 'normal_page_body_content', 'dk', 0x3c703e0d0a09737562312c323c2f703e0d0a),
(104, 'normal_page_header', 'dk', 0x737562312f32),
(104, 'normal_page_post_header', 'dk', 0x737562312f32),
(104, 'normal_page_body_content', 'dk', 0x3c703e0d0a09737562312f323c2f703e0d0a),
(105, 'normal_page_header', 'dk', ''),
(105, 'normal_page_post_header', 'dk', ''),
(105, 'normal_page_body_content', 'dk', 0x3c703e0d0a092e3f3c2f703e0d0a),
(90, 'normal_page_header', 'dk', ''),
(90, 'normal_page_post_header', 'dk', ''),
(92, 'normal_page_header', 'uk', 0x706167652033),
(92, 'normal_page_post_header', 'uk', 0x706167652033),
(92, 'normal_page_body_content', 'uk', 0x3c703e0d0a097061676520333c2f703e0d0a),
(101, 'normal_page_post_header', 'dk', 0x73756231),
(101, 'normal_page_header', 'dk', 0x73756231),
(90, 'normal_page_body_content', 'dk', 0x3c703e0d0a097061676520313c2f703e0d0a),
(91, 'normal_page_header', 'dk', 0x706167652032),
(91, 'normal_page_post_header', 'dk', 0x706167652032),
(91, 'normal_page_body_content', 'dk', 0x3c703e0d0a097061676520323c2f703e0d0a),
(92, 'normal_page_header', 'dk', 0x706167652033),
(92, 'normal_page_post_header', 'dk', 0x706167652033),
(92, 'normal_page_body_content', 'dk', 0x3c703e0d0a097061676520333c2f703e0d0a),
(97, 'normal_page_header', 'uk', 0x6e657720646f63756d656e747320656e67),
(97, 'normal_page_header', 'dk', 0x6e657720646f63756d656e7473),
(97, 'normal_page_post_header', 'dk', 0x6e657720646f63756d656e74),
(97, 'normal_page_body_content', 'dk', 0x3c703e0d0a096e657720646f63756d656e743c2f703e0d0a),
(96, 'normal_page_header', 'dk', 0x44656c6574654d65),
(96, 'normal_page_post_header', 'dk', 0x44656c6574654d65),
(96, 'normal_page_body_content', 'dk', 0x3c703e0d0a0944656c6574654d653c2f703e0d0a);

-- --------------------------------------------------------

--
-- Table structure for table `hierarchy`
--

CREATE TABLE IF NOT EXISTS `hierarchy` (
  `hid` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `did` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`hid`),
  UNIQUE KEY `parent_2` (`parent`,`did`),
  KEY `parent` (`parent`,`did`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=149 ;

--
-- Dumping data for table `hierarchy`
--

INSERT INTO `hierarchy` (`hid`, `parent`, `did`) VALUES
(133, 90, 0),
(130, 90, 101),
(124, 90, 100),
(148, 103, 105),
(131, 90, 104),
(147, 105, 105),
(126, 90, 97),
(129, 91, 102);

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

--
-- Dumping data for table `lang`
--

INSERT INTO `lang` (`lname`, `id`, `flagtext`, `thumbnail_path`, `priority`) VALUES
('Dansk', 'dk', 'Dansk version', 'imgs/dkflag.gif', 1000),
('English', 'uk', 'English Version', 'imgs/ukflag.gif', 120);

-- --------------------------------------------------------

--
-- Table structure for table `mainmenu`
--

CREATE TABLE IF NOT EXISTS `mainmenu` (
  `did` int(11) NOT NULL,
  PRIMARY KEY (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mainmenu`
--

INSERT INTO `mainmenu` (`did`) VALUES
(90),
(91),
(92),
(103),
(104);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mapping`
--

INSERT INTO `mapping` (`mid`, `did`, `path`) VALUES
(1, 0, 'home'),
(2, 92, 'tester'),
(3, 105, 'adsfdsa'),
(4, 105, 'asfdsasfd');

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
('mod_subscription', 'Subscription Form', 'modules/mod_subscription.php', 'modules/mod_subscription_cms.php', 'page', 0),
('mod_hierarchy', 'hierarchy', 'modules/hierarchy.php', 'modules/hierarchy.php', 'general', 1),
('mod_mainmenu', 'mainmenu', 'modules/mainmenu.php', 'modules/mainmenu.php', 'general', 1);

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
