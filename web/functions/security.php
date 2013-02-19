<?php
function secureInput($input) {
	foreach($input as $key=>$val) {
		//echo $key."=>".$val."<br>";
	    $input[$key] = mysql_real_escape_string($val);
	}
	return $input;
}
?>