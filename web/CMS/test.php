<?php 
header('Content-type: text/html; charset=iso-8859-1');
require_once("functions/documentBase.php");
require_once("functions/connect.php");
require_once("functions/listings.php");
require_once("functions/path.php");
require_once("functions/display.php");
require_once("functions/siteInfo.php");


$query = "SELECT * FROM  special_text_v order by langid, stid";
$result = mysql_query($query);

//refresh function :-)
if ($_POST){
	while ($row = mysql_fetch_assoc($result)){
		$postinfo = $row['stid'] . "" . $row['langid'];
		$item = $_POST[$postinfo];
		if ($item != ""){
			$query2 = "UPDATE special_text_v set value='" . $item . "' WHERE stid=" . $row['stid'] . " and langid=" . $row['langid'];
			mysql_query($query2);	
		}
	}
?>
<meta http-equiv="refresh" content="2;url=http://www.fundamentalism.dk/test.php">
<?
}else{

	echo "<form method='post'><table><tr>";
		while ($row = mysql_fetch_assoc($result)){
			if ($langidTjek != $row['langid']){
				
				echo "</tr>";
				$langidTjek = $row['langid'];
				echo $row['langid'] . "<tr>";
			}else{
				?>
				<td>
					<textarea name="<? echo $row['stid'] . "" . $row['langid'];?>" cols="40" rows="5"><? echo $row['value']; ?></textarea><br>
				</td>
				<?
			}
		}
echo "<table><input type='submit' value='Submit' /></form>";
}
?>




