<?php 
require_once("functions/authorize.php");
?>

<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
        <LINK REL="stylesheet" type="text/css" href="css/general.css">

<title><?php echo $SITE_INFO_WEB_NAME; ?>  - administrative pages</title>
</head>
<frameset cols="200, *">
<frame name="navigation" src="navigator.php" marginheight="0" marginwidth="0">
<?php 
$rightFrameContent = "main.php";
if (isset($_SESSION['ThisDid'])) {
    $rightFrameContent = "editDocs.php?did=".$_SESSION['ThisDid'];
}
?>
<frame name="main" src="<?php echo $rightFrameContent; ?>">
</html>
