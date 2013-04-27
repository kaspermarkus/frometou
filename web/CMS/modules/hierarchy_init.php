<?php
//Ensure we have the required entry in the module table
ensure_module("mod_hierarchy", "hierarchy", "modules/hierarchy.php", "modules/hierarchy.php", "general"); 

$query = "CREATE TABLE IF NOT EXISTS `hierarchy` (". 
	"`hid` int(11) NOT NULL AUTO_INCREMENT, ".
	"`parent` int(11) NOT NULL, ".
	"`did` int(11) NOT NULL, ".
	"PRIMARY KEY (`hid`), ".
    "UNIQUE KEY `parent_2` (`parent`,`did`),".
	"KEY `parent` (`parent`,`did`)".
    ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
mysql_query($query);
?>