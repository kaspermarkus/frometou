-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2013 at 02:57 PM
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

--
-- Dumping data for table `doc`
--

INSERT INTO `doc` (`did`, `module_signature`, `description_img`, `ident`, `priority`) VALUES
(0, 'normal_page', '', 'Home', 100),
(2, 'normal_page', '', 'Installation', 100),
(3, 'normal_page', '', 'Configuration', 100),
(4, 'normal_page', '', 'Documentation', 100),
(5, 'normal_page', '', 'Documentation: Modules', 100),
(6, 'normal_page', '', 'About', 100),
(7, 'normal_page', '', 'Documentation: Usage', 100),
(8, 'normal_page', '', 'Documentation: Developers', 100);

--
-- Dumping data for table `doc_general_v`
--

INSERT INTO `doc_general_v` (`did`, `langid`, `linktext`, `pagetitle`, `description`) VALUES
(0, 'uk', 'Home', 'Front Page', ''),
(0, 'dk', '', '', ''),
(2, 'uk', 'Installation', 'Installation instruction for frometou', ''),
(3, 'uk', 'Configuration', 'Configuration of frometou', ''),
(4, 'uk', 'Documentation', 'Documentation', ''),
(5, 'uk', 'Modules', 'Modules', ''),
(6, 'uk', 'About frometou', 'About frometou', ''),
(7, 'uk', 'Using the CMS system', 'How to use frometou CMS system', ''),
(8, 'uk', 'Developer documentation', 'Documentation for developers', '');

--
-- Dumping data for table `doc_module_v`
--

INSERT INTO `doc_module_v` (`did`, `module`, `prop_signature`, `langid`, `value`) VALUES
(0, 'normal_page', 'normal_page_header', 'dk', ''),
(0, 'normal_page', 'normal_page_post_header', 'dk', ''),
(0, 'normal_page', 'normal_page_body_content', 'dk', 0x2e),
(0, 'normal_page', 'normal_page_header', 'uk', 0x66726f6d65746f75),
(0, 'normal_page', 'normal_page_post_header', 'uk', 0x612073696d706c6520616e6420657874656e6461626c6520434d532073797374656d),
(0, 'normal_page', 'normal_page_body_content', 'uk', 0x3c703e0d0a09626c61626c61626c613c2f703e0d0a),
(2, 'normal_page', 'normal_page_header', 'uk', 0x496e7374616c6c6174696f6e),
(2, 'normal_page', 'normal_page_post_header', 'uk', ''),
(2, 'normal_page', 'normal_page_body_content', 'uk', 0x3c68333e0d0a09526571756972656d656e74733a3c2f68333e0d0a3c756c3e0d0a093c6c693e0d0a0909706870202667743b3d20352e783c2f6c693e0d0a093c6c693e0d0a09096d7973716c2064617461626173653c2f6c693e0d0a093c6c693e0d0a09097765622073657276657220737570706f7274696e67202e687461636365737320646f6373202865672e206170616368652032293c2f6c693e0d0a3c2f756c3e0d0a3c68333e0d0a0947657474696e672066726f6d65746f753c2f68333e0d0a3c756c3e0d0a093c6c693e0d0a0909446f776e6c6f616420746865207a69702066696c6520666f756e6420686572653a203c6120687265663d2768747470733a2f2f6769746875622e636f6d2f6b61737065726d61726b75732f66726f6d65746f752f617263686976652f6d61737465722e7a6970273e68747470733a2f2f6769746875622e636f6d2f6b61737065726d61726b75732f66726f6d65746f752f617263686976652f6d61737465722e7a69703c2f613e3c2f6c693e0d0a093c6c693e0d0a0909556e7a6970207468652066696c6520616e6420636f707920697420746f2074686520776562207365727665722e20596f752077696c6c2077616e742074686520726f6f74206f6620746865207765627369746520746f20706f696e7420746f207468652077656220666f6c646572206f662066726f6d65746f753c2f6c693e0d0a3c2f756c3e0d0a3c68333e0d0a0953697465496e666f2e706870202f20436f6e6669677572696e6720796f757220776562736974653c2f68333e0d0a3c756c3e0d0a093c6c693e0d0a090954686520636f6e66696775726174696f6e206f662074686520434d532073797374656d20697320646f6e65207573696e6720612066696c652063616c6c65642073697465496e666f2e7068702e20546869732066696c652074656c6c73207468652073797374656d2061626f75742074686520646174616261736528732920746f207573652c20757365726e616d657320616e642070617373776f7264732c2072656c6576616e742070617468732c206574632e3c2f6c693e0d0a093c6c693e0d0a09095468652073697465496e666f2066696c65207265736964657320696e2074686520666f6c6465723a203c656d3e66756e6374696f6e732f73797374656d2f3c2f656d3e2e204865726520796f752063616e2066696e6420616e206578616d706c652066696c65206e616d65643a2073697465496e666f2e7068702e6578616d706c652e20436f7079206f722072656e616d6520746869732066696c6520746f2073697465496e666f2e70687020616e642065646974206974206163636f7264696e6720746f20796f757220707265666572656e6365732e3c2f6c693e0d0a093c6c693e0d0a09094d616b652073757265207468617420796f7520636f7079207468652066696c6520746f20796f75722077656273657276657220696620796f75206d6f64696679206974206c6f63616c6c793c2f6c693e0d0a093c6c693e0d0a0909666f72206d6f726520696e666f726d6174696f6e206f6e20636f6e66696775726174696f6e2c207365653a203f3f3f3c2f6c693e0d0a3c2f756c3e0d0a3c68333e0d0a094372656174696e672075736572732f6461746162617365733a3c2f68333e0d0a3c756c3e0d0a093c6c693e0d0a0909416674657220796f75262333393b766520736574207570207468652073697465496e666f2e7068702066696c652c207573652061207765622d62726f7773657220746f20676f20746f266e6273703b3c656d3e434d532f73797374656d2f696e697469616c697a6174696f6e2f696e697469616c697a652e7068703c2f656d3e266e6273703b616e6420666f6c6c6f77207468652074687265652073696d706c6520737465707320746f20736574207570207468652064617461626173652c206574632e3c2f6c693e0d0a3c2f756c3e0d0a3c68333e0d0a092e2e2e20416e6420796f75262333393b726520646f6e653c2f68333e0d0a3c6469763e0d0a09266e6273703b3c2f6469763e0d0a),
(3, 'normal_page', 'normal_page_header', 'uk', 0x436f6e66696775726174696f6e),
(3, 'normal_page', 'normal_page_post_header', 'uk', 0x53657474696e672075702066726f6d65746f75),
(3, 'normal_page', 'normal_page_body_content', 'uk', 0x3c703e0d0a092e3c2f703e0d0a),
(4, 'normal_page', 'normal_page_header', 'uk', 0x446f63756d656e746174696f6e),
(4, 'normal_page', 'normal_page_post_header', 'uk', ''),
(4, 'normal_page', 'normal_page_body_content', 'uk', 0x2e),
(5, 'normal_page', 'normal_page_header', 'uk', 0x4d6f64756c6573),
(5, 'normal_page', 'normal_page_post_header', 'uk', ''),
(5, 'normal_page', 'normal_page_body_content', 'uk', 0x3c703e0d0a092e3c2f703e0d0a),
(6, 'normal_page', 'normal_page_header', 'uk', 0x41626f75742066726f6d65746f75),
(6, 'normal_page', 'normal_page_post_header', 'uk', ''),
(6, 'normal_page', 'normal_page_body_content', 'uk', 0x2e),
(7, 'normal_page', 'normal_page_header', 'uk', 0x486f7720746f20757365207468652066726f6d65746f7520434d532073797374656d),
(7, 'normal_page', 'normal_page_post_header', 'uk', ''),
(7, 'normal_page', 'normal_page_body_content', 'uk', 0x2e),
(8, 'normal_page', 'normal_page_header', 'uk', 0x446f63756d656e746174696f6e20666f7220646576656c6f70657273),
(8, 'normal_page', 'normal_page_post_header', 'uk', ''),
(8, 'normal_page', 'normal_page_body_content', 'uk', 0x2e);

--
-- Dumping data for table `hierarchy`
--

INSERT INTO `hierarchy` (`hid`, `parent`, `did`) VALUES
(2, 4, 8),
(3, 4, 5),
(4, 4, 7);

--
-- Dumping data for table `lang`
--

INSERT INTO `lang` (`lname`, `id`, `flagtext`, `thumbnail_path`, `priority`) VALUES
('Dansk', 'dk', 'Dansk version', 'layout/imgs/dkflag.gif', 1000),
('English', 'uk', 'English Version', 'layout/imgs/ukflag.gif', 120);

--
-- Dumping data for table `mainmenu`
--

INSERT INTO `mainmenu` (`did`) VALUES
(0),
(2),
(3),
(4),
(6);

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_signature`, `module_name`, `display_path`, `cms_path`, `module_type`, `enabled`) VALUES
('normal_page', 'Regular Page', 'modules/normal_page.php', 'modules/normal_page.php', 'page', 1),
('mod_hierarchy', 'hierarchy', 'modules/hierarchy.php', 'modules/hierarchy.php', 'general', 1),
('mod_mainmenu', 'mainmenu', 'modules/mainmenu.php', 'modules/mainmenu.php', 'general', 1);

--
-- Dumping data for table `module_props`
--

INSERT INTO `module_props` (`module_signature`, `signature`, `property_name`) VALUES
('normal_page', 'normal_page_header', 'Header'),
('normal_page', 'normal_page_post_header', 'Post Header'),
('normal_page', 'normal_page_body_content', 'Body');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
