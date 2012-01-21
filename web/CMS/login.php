<?php
	session_start();
    header("Cache-control: private"); // IE6 Fix. Why? Because it's rubbish

require_once("../functions/siteInfo.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
 <HTML>
  <HEAD>
  <TITLE>Please enter login and password to enter <?php echo $SITE_INFO_WEB_NAME; ?> adminstrative pages</TITLE>
   <LINK REL="stylesheet" type="text/css" href="css/general.css" >
   </HEAD>
<BODY>
<br><br><br>
<center><h1><?php echo $SITE_INFO_WEB_NAME; ?></h1>
<h2>Administration</h2>
<hr>
<br>
<?php
if ($_POST['name'] == "$SITE_INFO_CMS_UNAME" && $_POST['pw'] == "$SITE_INFO_CMS_PASS") {
	$_SESSION['uname'] = $_POST['name'];
	$_SESSION['pass'] = $_POST['pw'];

	echo "<script language='javascript'>";
	echo "window.location = 'index.php'";
	echo "</script>";
	die();
} else if ($_POST['name'] != null || $_POST['pw'] != null) {
	echo "<H3>Wrong username or pass... please try again</H3>";
 } else if ($_POST['errorMsg'] != null) {
	echo "<H3>$errorMsg</H3>";
 }
?>
<form method="POST" action="login.php">
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
