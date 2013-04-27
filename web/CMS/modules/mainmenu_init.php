<?php
//Ensure we have the required entry in the module table
ensure_module("mod_mainmenu", "mainmenu", "modules/mainmenu.php", "modules/mainmenu.php", "general"); 
//create main menu table
$query = "CREATE TABLE IF NOT EXISTS `mainmenu` (".
		"`did` int(11) NOT NULL,".
		"PRIMARY KEY (`did`)".
		") ENGINE=InnoDB DEFAULT CHARSET=latin1;";
mysql_query($query);
?>
