<?php
	session_start();
    header("Cache-control: private"); // IE6 Fix. Why? Because it's rubbish
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
 <HTML>
  <HEAD>
  <TITLE>Please enter login and password to enter Beijing2000.nets adminstrative pages</TITLE>
   <LINK REL="stylesheet" type="text/css" href="css/default.css" >
   </HEAD>
<BODY>
<br><br><br>
<center><h1>Beijing2000.net</h1>
<h2>Administration</h2>
<hr>
<br>
<?php
if ($_GET['name'] == "vagn" && $_GET['pw'] == "tuborg08") {
	echo "ABC";
	//phpinfo();
	$_SESSION['uname'] = $_GET['name'];
	$_SESSION['pass'] = $_GET['pw'];

	echo "<script language='javascript'>";
	echo "document.location = 'index.php'";
	echo "</script>";
	die();
} else if ($_GET['name'] != null || $_get['pw'] != null) {
	echo "<H3>Wrong username or pass... please try again</H3>";
 } else if ($_GET['errorMsg'] != null) {
	echo "<H3>$errorMsg</H3>";
 }
?>
<form method="GET" action="login.php">
<TABLE>
   <tr><td>Username: </TD><TD><input type="text" name="name" size="14"></TD></TR><br><BR>
   <tr><td>Password: </TD><TD><input type="password" name="pw" size="14"></TD></TR><br><BR>
   </TABLE>
<BR><BR>
<input type="submit" value="log in">
</form>
</CENTER>

</BODY>
</HTML>