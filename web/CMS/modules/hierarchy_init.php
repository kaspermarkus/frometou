<?php
//Ensure we have the required entry in the module table
ensure_module("mod_hierarchy", "hierarchy", "modules/hierarchy.php", "modules/hierarchy.php", "general"); 

$query = "CREATE TABLE IF NOT EXISTS `hierarchy` (". 
	"`hid` int(11) NOT NULL AUTO_INCREMENT, ".
	"`parent` int(11) NOT NULL, ".
	"`did` int(11) NOT NULL, ".
	"PRIMARY KEY (`hid`), ".
	"KEY `parent`".
	" (`parent`,`did`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=51 ;";
mysql_query($query);

?>	