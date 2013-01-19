-- --------------------------------------------------------

--
-- Table structure for table `defaultlangs`
--
DROP TABLE IF EXISTS defaultlangs;

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
DROP TABLE IF EXISTS doc;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `doc`
--

INSERT INTO `doc` (`did`, `module_signature`, `typeid`, `description_img`, `ident`, `priority`) VALUES
(0, 'regular', 1, 0, 'home', 200);

-- --------------------------------------------------------

--
-- Table structure for table `doc_general_v`
--
DROP TABLE IF EXISTS doc_general_v;
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
(0, 1, 'forside', '', 'This is the Front Page');

-- --------------------------------------------------------

--
-- Table structure for table `doc_reference`
--
DROP TABLE IF EXISTS doc_reference;
CREATE TABLE IF NOT EXISTS `doc_reference` (
  `did` int(11) NOT NULL,
  `reference` varchar(150) COLLATE utf8_bin NOT NULL,
  KEY `did` (`did`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `dtype`
--
DROP TABLE IF EXISTS dtype;
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
DROP TABLE IF EXISTS dtype_v;
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
DROP TABLE IF EXISTS hierarchy;
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

DROP TABLE IF EXISTS lang;
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
-- Table structure for table `layout`
--

DROP TABLE IF EXISTS layout;
CREATE TABLE IF NOT EXISTS `layout` (
  `layout_used` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `layout`
--

INSERT INTO `layout` (`layout_used`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `layout_properties`
--

DROP TABLE IF EXISTS layout_properties;
CREATE TABLE IF NOT EXISTS `layout_properties` (
  `pid` bigint(20) NOT NULL AUTO_INCREMENT,
  `layoutID` int(11) NOT NULL,
  `element` varchar(100) COLLATE utf8_bin NOT NULL,
  `property` varchar(50) COLLATE utf8_bin NOT NULL,
  `value` varchar(150) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`pid`),
  UNIQUE KEY `layoutID_2` (`layoutID`,`element`,`property`),
  KEY `layoutID` (`layoutID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=480 ;

--
-- Dumping data for table `layout_properties`
--

INSERT INTO `layout_properties` (`pid`, `layoutID`, `element`, `property`, `value`, `description`, `priority`) VALUES
(1, 1, 'TR, TH, TD, TABLE', 'border', '0px', '', 500),
(2, 1, 'TR, TH, TD, TABLE', 'border-collapse', 'collapse', '', 500),
(3, 1, 'TR, TH, TD, TABLE', 'margin', '0px', '', 500),
(4, 1, 'TR, TH, TD, TABLE', 'padding', '0px', '', 500),
(5, 1, 'TR, TH, TD, TABLE', 'border-spacing', '0px', '', 500),
(6, 1, 'TR, TH, TD, TABLE', 'text-align', 'left', '', 500),
(7, 1, 'TABLE.maintable', 'width', '965px', '', 500),
(8, 1, 'TABLE.maintable', 'border', '0px', '', 500),
(9, 1, 'TABLE.maintable', 'padding', '0px', '', 500),
(10, 1, 'TABLE.maintable', 'margin', '0px', '', 500),
(11, 1, 'TD.maintableTopLeft', 'height', '126px', '', 400),
(12, 1, 'TD.maintableTopLeft', 'background-color', '#580101', '', 400),
(13, 1, 'TD.maintableTopLeft', 'color', 'white', '', 400),
(14, 1, 'TD.maintableTopLeft', 'text-decoration', 'none', '', 400),
(15, 1, 'TD.maintableTopLeft', 'font-size', '11px', '', 400),
(16, 1, 'TD.maintableTopLeft', 'text-align', 'center', '', 400),
(17, 1, 'IMG.maintableTopLeft', 'height', '95px', '', 500),
(18, 1, 'TD.maintableTopMain', 'height', '126px', '', 500),
(19, 1, 'TD.maintableTopMain', 'background-color', '#580101', '', 500),
(20, 1, 'TD.maintableTopMain', 'color', 'white', '', 500),
(21, 1, 'TD.maintableTopMain', 'text-decoration', 'none', '', 500),
(22, 1, 'TD.maintableTopMain', 'font-size', '11px', '', 500),
(23, 1, 'TD.maintableTopMain', 'text-align', 'center', '', 500),
(24, 1, 'TD.maintableBottom', 'height', '16px', '', 500),
(25, 1, 'TD.maintableBottom', 'background-color', '#580101', '', 500),
(26, 1, 'TD.maintableBottom', 'color', 'white', '', 500),
(27, 1, 'TD.maintableBottom', 'text-decoration', 'none', '', 500),
(28, 1, 'TD.maintableBottom', 'font-size', '11px', '', 500),
(29, 1, 'TD.maintableBottom', 'text-align', 'center', '', 500),
(30, 1, 'TD.maintableMain', 'background-color', '#F1F1F1', '', 500),
(31, 1, 'TD.maintableMain', 'color', '#292222', '', 500),
(32, 1, 'TD.maintableMain', 'font-family', 'verdana', '', 500),
(33, 1, 'TD.maintableMain', 'font-size', '11px', '', 500),
(34, 1, 'TD.maintableMain', 'padding', '0px 40px 0px 40px', '', 500),
(35, 1, 'TD.maintableMain', 'vertical-align', 'top', '', 500),
(36, 1, 'TD.maintableLeft', 'width', '163px', '', 500),
(37, 1, 'TD.maintableLeft', 'height', '400px', '', 500),
(38, 1, 'TD.maintableLeft', 'background-color', '#916262', '', 500),
(39, 1, 'A.leftmenu-links', 'color', 'white', '', 500),
(40, 1, 'A.leftmenu-links', 'font-size', '11px', '', 500),
(41, 1, 'A.leftmenu-links', 'font-weight', 'bold', '', 500),
(42, 1, 'A.leftmenu-links', 'text-decoration', 'none', '', 500),
(43, 1, 'A.leftmenu-links', 'font-family', 'verdana', '', 500),
(44, 1, '.leftmenu-links A:HOVER', 'color', '#F8DB38', '', 500),
(45, 1, 'TD.leftmenu-links', 'padding', '0px 10px 5px 10px', '', 500),
(46, 1, 'TD.leftmenu-links IMG', 'padding', '0px 3px 0px 0px', '', 500),
(47, 1, 'TD.dots', 'background', 'url(/layout/schemes/basic1/spacer1.gif)', '', 500),
(48, 1, 'TD.dots', 'background-repeat', 'repeat-x', '', 500),
(49, 1, 'TD.dots', 'height', '1px', '', 500),
(50, 1, 'TABLE.leftmenu-spacer', 'width', '100%', '', 500),
(51, 1, 'TD.leftmenu-spacer', 'height', '10px', '', 500),
(52, 1, 'TD.leftmenu-spacer', 'padding', '0px 7px 3px 7px', '', 500),
(65, 1, 'TD.maintableLeft', 'vertical-align', 'top', '', 500),
(67, 1, ' .maintableBottom A', 'color', 'gray', '', 500),
(68, 1, '.maintableBottom A', 'text-decoration', 'none', '', 500),
(145, 2, '.maintableRight A', 'color', 'white', '', 500),
(134, 2, 'TD.maintableRight', 'background-color', '#916262', '', 500),
(69, 1, '.maintableBottom A:HOVER', 'color', '#F8DB38', '', 500),
(70, 1, '.maintableMain A', ' color', 'black', '', 500),
(71, 1, '.maintableMain A', 'text-decoration', 'none', '', 500),
(73, 1, '.maintableMain A:HOVER', 'font-weight', 'bold', '', 500),
(74, 2, 'TR, TH, TD, TABLE', 'border', '0px', '', 500),
(75, 2, 'TR, TH, TD, TABLE', 'border-collapse', 'collapse', '', 500),
(76, 2, 'TR, TH, TD, TABLE', 'margin', '0px', '', 500),
(77, 2, 'TR, TH, TD, TABLE', 'padding', '0px', '', 500),
(78, 2, 'TR, TH, TD, TABLE', 'border-spacing', '0px', '', 500),
(79, 2, 'TR, TH, TD, TABLE', 'text-align', 'left', '', 500),
(80, 2, 'TABLE.maintable', 'width', '1008px', '', 500),
(81, 2, 'TABLE.maintable', 'border', '0px', '', 500),
(82, 2, 'TABLE.maintable', 'padding', '0px', '', 500),
(83, 2, 'TABLE.maintable', 'margin', '0px', '', 500),
(84, 2, 'TD.maintableTopLeft', 'height', '126px', '', 400),
(85, 2, 'TD.maintableTopLeft', 'background-color', '#580101', '', 400),
(86, 2, 'TD.maintableTopLeft', 'color', 'white', '', 400),
(87, 2, 'TD.maintableTopLeft', 'text-decoration', 'none', '', 400),
(88, 2, 'TD.maintableTopLeft', 'font-size', '11px', '', 400),
(89, 2, 'TD.maintableTopLeft', 'text-align', 'center', '', 400),
(90, 2, 'IMG.maintableTopLeft', 'height', '95px', '', 500),
(91, 2, 'TD.maintableTopMain', 'height', '126px', '', 500),
(92, 2, 'TD.maintableTopMain', 'background-color', '#580101', '', 500),
(93, 2, 'TD.maintableTopMain', 'color', 'white', '', 500),
(94, 2, 'TD.maintableTopMain', 'text-decoration', 'none', '', 500),
(95, 2, 'TD.maintableTopMain', 'font-size', '11px', '', 500),
(96, 2, 'TD.maintableTopMain', 'text-align', 'center', '', 500),
(97, 2, 'TD.maintableBottom', 'height', '16px', '', 500),
(98, 2, 'TD.maintableBottom', 'background-color', '#580101', '', 500),
(99, 2, 'TD.maintableBottom', 'color', 'white', '', 500),
(100, 2, 'TD.maintableBottom', 'text-decoration', 'none', '', 500),
(101, 2, 'TD.maintableBottom', 'font-size', '11px', '', 500),
(102, 2, 'TD.maintableBottom', 'text-align', 'center', '', 500),
(103, 2, 'TD.maintableMain', 'background-color', '#F1F1F1', '', 500),
(104, 2, 'TD.maintableMain', 'color', '#292222', '', 500),
(105, 2, 'TD.maintableMain', 'font-family', 'verdana', '', 500),
(106, 2, 'TD.maintableMain', 'font-size', '11px', '', 500),
(107, 2, 'TD.maintableMain', 'padding', '0px 40px 0px 40px', '', 500),
(108, 2, 'TD.maintableMain', 'vertical-align', 'top', '', 500),
(109, 2, 'TD.maintableLeft', 'width', '163px', '', 500),
(110, 2, 'TD.maintableLeft', 'height', '400px', '', 500),
(111, 2, 'TD.maintableLeft', 'background-color', '#916262', '', 500),
(112, 2, 'A.leftmenu-links', 'color', 'white', '', 500),
(113, 2, 'A.leftmenu-links', 'font-size', '11px', '', 500),
(114, 2, 'A.leftmenu-links', 'font-weight', 'bold', '', 500),
(115, 2, 'A.leftmenu-links', 'text-decoration', 'none', '', 500),
(116, 2, 'A.leftmenu-links', 'font-family', 'verdana', '', 500),
(117, 2, '.leftmenu-links A:HOVER', 'color', '#F8DB38', '', 500),
(118, 2, 'TD.leftmenu-links', 'padding', '0px 10px 5px 10px', '', 500),
(119, 2, 'TD.leftmenu-links IMG', 'padding', '0px 3px 0px 0px', '', 500),
(120, 2, 'TD.dots', 'background', 'url(/layout/schemes/basic1/spacer1.gif)', '', 500),
(121, 2, 'TD.dots', 'background-repeat', 'repeat-x', '', 500),
(122, 2, 'TD.dots', 'height', '1px', '', 500),
(123, 2, 'TABLE.leftmenu-spacer', 'width', '100%', '', 500),
(124, 2, 'TD.leftmenu-spacer', 'height', '10px', '', 500),
(125, 2, 'TD.leftmenu-spacer', 'padding', '0px 7px 3px 7px', '', 500),
(126, 2, 'TD.maintableLeft', 'vertical-align', 'top', '', 500),
(127, 2, ' .maintableBottom A', 'color', 'gray', '', 500),
(128, 2, '.maintableBottom A', 'text-decoration', 'none', '', 500),
(129, 2, '.maintableBottom A:HOVER', 'color', '#F8DB38', '', 500),
(130, 2, '.maintableMain A', ' color', 'black', '', 500),
(131, 2, '.maintableMain A', 'text-decoration', 'none', '', 500),
(132, 2, '.maintableMain A:HOVER', 'font-weight', 'bold', '', 500),
(135, 2, 'TD.maintableRight', 'vertical-align', 'top', '', 500),
(137, 2, 'TD.maintableRight', 'color', 'white', '', 500),
(138, 2, 'TD.maintableRight', 'font-family', 'verdana', '', 500),
(139, 2, 'TD.maintableRight', 'font-size', '11px', '', 500),
(142, 2, 'TD.maintableRight', 'padding', '12px', '', 500),
(144, 2, 'TD.maintableMain', 'width', '545px', '', 500),
(146, 2, '.maintableRight A:HOVER', 'font-weight', 'bold', '', 500),
(419, -1, 'TR, TH, TD, TABLE', 'text-align', 'left', '', 500),
(479, -1, '.maintable', 'border-collapse', 'separate', '', 1000),
(417, -1, 'TR, TH, TD, TABLE', 'margin', '0px', '', 500),
(418, -1, 'TR, TH, TD, TABLE', 'padding', '0px', '', 500),
(416, -1, 'TR, TH, TD, TABLE', 'border-spacing', '0px', '', 500),
(415, -1, 'TR, TH, TD, TABLE', 'border-collapse', 'collapse', '', 500),
(413, -1, 'TD.maintableTopMain', 'text-decoration', 'none', '', 500),
(414, -1, 'TR, TH, TD, TABLE', 'border', '0px', '', 500),
(411, -1, 'TD.maintableTopMain', 'height', '200px', '', 500),
(412, -1, 'TD.maintableTopMain', 'text-align', 'center', '', 500),
(409, -1, 'TD.maintableTopMain', 'color', 'white', '', 500),
(410, -1, 'TD.maintableTopMain', 'font-size', '15px', '', 500),
(407, -1, 'TD.maintableTopLeft', 'text-decoration', 'none', '', 400),
(406, -1, 'TD.maintableTopLeft', 'text-align', 'center', '', 400),
(405, -1, 'TD.maintableTopLeft', 'height', '126px', '', 400),
(403, -1, 'TD.maintableTopLeft', 'color', 'white', '', 400),
(404, -1, 'TD.maintableTopLeft', 'font-size', '11px', '', 400),
(402, -1, 'TD.maintableTopLeft', 'background-color', '#a99c9c', '', 400),
(401, -1, 'TD.maintableRight', 'vertical-align', 'top', '', 500),
(400, -1, 'TD.maintableRight', 'padding', '12px', '', 500),
(397, -1, 'TD.maintableRight', 'color', 'white', '', 500),
(398, -1, 'TD.maintableRight', 'font-family', 'verdana', '', 500),
(399, -1, 'TD.maintableRight', 'font-size', '11px', '', 500),
(396, -1, 'TD.maintableRight', 'background-color', '#a3623b', '', 500),
(394, -1, 'TD.maintableMain', 'vertical-align', 'top', '', 500),
(395, -1, 'TD.maintableMain', 'width', '560px', '', 500),
(393, -1, 'TD.maintableMain', 'padding', '0px 40px 0px 40px', '', 500),
(390, -1, 'TD.maintableMain', 'color', 'url(/frometou/web/layout/schemes/4WayBasic/menu-left.png)', '', 500),
(391, -1, 'TD.maintableMain', 'font-family', 'verdana', '', 500),
(392, -1, 'TD.maintableMain', 'font-size', '11px', '', 500),
(389, -1, 'TD.maintableMain', 'background-color', '#FFFFFF', '', 500),
(387, -1, 'TD.maintableLeft', 'vertical-align', 'top', '', 500),
(388, -1, 'TD.maintableLeft', 'width', '200px', '', 500),
(460, -1, 'TD.maintableTopMain', 'background-color', '#a99c9c', '', 500),
(384, -1, 'TD.maintableBottom', 'text-decoration', 'none', '', 500),
(459, -1, 'TD.maintableLeft', 'background-color', '#cfbfbf', '', 500),
(382, -1, 'TD.maintableBottom', 'height', '16px', '', 500),
(383, -1, 'TD.maintableBottom', 'text-align', 'center', '', 500),
(380, -1, 'TD.maintableBottom', 'color', '#FFFFFF', '', 500),
(381, -1, 'TD.maintableBottom', 'font-size', '12px', '', 500),
(379, -1, 'TD.maintableBottom', 'background-color', '#a99c9c', '', 500),
(378, -1, 'TD.leftmenu-spacer', 'padding', '0px 7px 3px 7px', '', 500),
(376, -1, 'TD.leftmenu-links IMG', 'padding', '0px 3px 0px 0px', '', 500),
(377, -1, 'TD.leftmenu-spacer', 'height', '10px', '', 500),
(375, -1, 'TD.leftmenu-links', 'padding', '0px 10px 5px 10px', '', 500),
(374, -1, 'TD.dots', 'height', '1px', '', 500),
(373, -1, 'TD.dots', 'background-repeat', 'repeat-y', '', 500),
(371, -1, 'TABLE.maintable', 'width', '1100px', '', 500),
(372, -1, 'TD.dots', 'background', 'url(/frometou/web/images/green-colette.jpg)', '', 500),
(370, -1, 'TABLE.maintable', 'padding', '0px', '', 500),
(369, -1, 'TABLE.maintable', 'margin', '0px', '', 500),
(368, -1, 'TABLE.maintable', 'border', '0px', '', 500),
(367, -1, 'TABLE.leftmenu-spacer', 'width', '100%', '', 500),
(365, -1, 'A.leftmenu-links', 'text-decoration', 'none', '', 500),
(366, -1, 'IMG.maintableTopLeft', 'height', '95px', '', 500),
(364, -1, 'A.leftmenu-links', 'font-weight', 'bold', '', 500),
(363, -1, 'A.leftmenu-links', 'font-size', '12px', '', 500),
(362, -1, 'A.leftmenu-links', 'font-family', 'verdana', '', 500),
(361, -1, 'A.leftmenu-links', 'color', 'white', '', 500),
(360, -1, '.maintableRight A:HOVER', 'font-weight', 'bold', '', 500),
(359, -1, '.maintableRight A', 'color', 'white', '', 500),
(357, -1, '.maintableMain A', 'text-decoration', 'underline', '', 500),
(358, -1, '.maintableMain A:HOVER', 'font-weight', 'bold', '', 500),
(356, -1, '.maintableMain A', ' color', 'black', '', 500),
(355, -1, '.maintableBottom A:HOVER', 'color', 'black', '', 500),
(354, -1, '.maintableBottom A', 'text-decoration', 'none', '', 500),
(353, -1, '.leftmenu-links A:HOVER', 'color', 'black', '', 500),
(352, -1, ' .maintableBottom A', 'color', 'black', '', 500),
(424, -1, 'TD.maintableRight', 'background-image', 'url(/frometou/web/layout/schemes/4WayBasic/menu-right.png)', '', 500),
(425, -1, 'TD.maintableRight', 'background-repeat', 'repeat', '', 500),
(428, -1, 'TD.maintableLeft', 'background-repeat', 'repeat-y', '', 500),
(430, -1, 'TD.maintableRight', 'width', '180px', '', 500),
(456, -1, 'TD.outherTableCenterRight', 'background-color', 'black', '', 500),
(446, -1, '.maintableBottom', 'border-top', '1px solid white', '', 500),
(457, -1, 'TD.outherTableTopCenter', 'background-color', 'black', '', 500),
(454, -1, 'TD.outherTableTopLeft', 'background-color', 'black', '', 500),
(451, -1, 'TD.outherTableBottomLeft', 'background-color', 'black', '', 500),
(455, -1, 'TD.outherTableTopRight', 'background-color', 'black', '', 500),
(453, -1, 'TD.outherTableCenterLeft', 'background-color', 'black', '', 500),
(452, -1, 'TD.outherTableBottomRight', 'background-color', 'black', '', 500),
(443, -1, 'TD.maintableTopMain', 'border-bottom', '', '', 500),
(447, -1, 'body', 'background-color', '#DDDDDD', '', 500),
(448, -1, '.maintableMain A', 'font-weight', 'bold', '', 500),
(449, -1, 'TD.maintableLeft', 'color', 'white', '', 500),
(450, -1, 'TD.outherTableBottomCenter', 'background-color', 'black', '', 500),
(461, -1, 'TD.maintableTopMain', 'position', 'relative', '', 500),
(466, -1, '.maintablerTopRight', 'background-color', '#a99c9c', '', 500),
(467, -1, '.topLang', 'background-color', 'black', '', 500),
(468, -1, '.topLang A', 'color', 'white', '', 500),
(471, -1, '.topLang', 'position', 'absolute', '', 500),
(470, -1, '.topLang', 'right', '10px', '', 500),
(472, -1, '.topLang', 'top', '5px', '', 500),
(475, -1, '.body', 'color', 'white', '', 500),
(476, -1, '.maintable', 'border', '2', '', 500);

-- --------------------------------------------------------

--
-- Table structure for table `layout_template`
--
DROP TABLE IF EXISTS layout_template;
CREATE TABLE IF NOT EXISTS `layout_template` (
  `lid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `layoutname` varchar(150) COLLATE utf8_bin NOT NULL,
  `filename` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `layout_template`
--

INSERT INTO `layout_template` (`lid`, `layoutname`, `filename`) VALUES
(1, 'Colette Simpelt', 'layout/schemes/basic1/basic1.php'),
(2, '4way basic', 'layout/schemes/4WayBasic/4WayBasic.php');

-- --------------------------------------------------------

--
-- Table structure for table `mapping`
--

DROP TABLE IF EXISTS mapping;
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
DROP TABLE IF EXISTS module;
CREATE TABLE IF NOT EXISTS `module` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `module_signature` varchar(20) COLLATE utf8_bin NOT NULL,
  `module_name` varchar(70) COLLATE utf8_bin NOT NULL,
  `display_path` varchar(150) COLLATE utf8_bin NOT NULL,
  `cms_path` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`mid`),
  UNIQUE KEY `module_signature` (`module_signature`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`mid`, `module_signature`, `module_name`, `display_path`, `cms_path`) VALUES
(1, 'normal_page', 'Regular Page', 'modules/normal_page.php', 'modules/normal_page.php'),
(2, 'mod_subscription', 'Subscription Form', 'modules/mod_subscription.php', 'modules/mod_subscription_cms.php');

-- --------------------------------------------------------

--
-- Table structure for table `module_text`
--
DROP TABLE IF EXISTS module_text;
CREATE TABLE IF NOT EXISTS `module_text` (
  `prop_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_signature` varchar(20) COLLATE utf8_bin NOT NULL,
  `signature` varchar(50) COLLATE utf8_bin NOT NULL,
  `property_name` varchar(100) COLLATE utf8_bin NOT NULL,
  `input_type` enum('text','html') COLLATE utf8_bin NOT NULL DEFAULT 'text',
  `shown` tinyint(1) NOT NULL DEFAULT '1',
  `priority` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`prop_id`),
  UNIQUE KEY `module_id_2` (`module_signature`,`property_name`),
  KEY `module_id` (`module_signature`),
  KEY `input_type` (`input_type`),
  KEY `priority` (`priority`),
  KEY `signature` (`signature`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `module_text`
--

INSERT INTO `module_text` (`prop_id`, `module_signature`, `signature`, `property_name`, `input_type`, `shown`, `priority`) VALUES
(NULL, 'mod_subscription', 'header', 'Header', 'text', 1, 670),
(NULL, 'normal_page', 'post_header', 'Post Header', 'text', 1, 200),
(NULL, 'normal_page', 'body_content', 'Body', 'html', 1, 100),
(NULL, 'normal_page', 'header', 'Header', 'text', 1, 300),
(NULL, 'mod_subscription', 'success_text', 'Text displayed after subscription is made', 'html', 2, 315),
(NULL, 'mod_subscription', 'text_after_form', 'Text After Form', 'html', 1, 320),
(NULL, 'mod_subscription', 'reset_button_text', 'Text on Reset Button', 'text', 1, 325),
(NULL, 'mod_subscription', 'submit_button_text', 'Text on Submit Button', 'text', 1, 330),
(NULL, 'mod_subscription', 'email', 'Email Address Label', 'text', 1, 335),
(NULL, 'mod_subscription', 'fullname', 'Fullname Label', 'text', 1, 340),
(NULL, 'mod_subscription', 'form_header', 'Form Header', 'text', 1, 345),
(NULL, 'mod_subscription', 'text_before_form', 'Text Before Form', 'html', 1, 350),
(NULL, 'mod_subscription', 'post_header', 'Post Header', 'text', 1, 360),
(NULL, 'mod_subscription', 'email_subject', 'Text for email subject line', 'text', 2, 310),
(NULL, 'mod_subscription', 'email_body', 'The message that should go in the email', 'html', 2, 305);

-- --------------------------------------------------------

--
-- Table structure for table `module_text_v`
--
DROP TABLE IF EXISTS module_text_v;
CREATE TABLE IF NOT EXISTS `module_text_v` (
  `did` int(11) NOT NULL,
  `text_signature` varchar(50) COLLATE utf8_bin NOT NULL,
  `lang_id` int(11) NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `did` (`did`,`text_signature`,`lang_id`),
  KEY `text_signature` (`text_signature`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `module_text_v` (did, text_signature, lang_id, value) VALUES 
(0, 'header', 1, 'Front Page');

