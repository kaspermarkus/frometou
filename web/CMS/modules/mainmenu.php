<?php
class mainmenu{
	function checkMainMenu($did) {
		$query = mysql_query("SELECT * FROM mainmenu WHERE did = '$did'");
		$row = mysql_fetch_assoc($query);

		//giving checkbox value
		if(isset($row['did'])) {
		 	$checked = "checked";
		} else {
			$checked = "";
		}

		//updating DB withpost results 
		if(isset($_POST['mainmenu'])) {
			if(!isset($row['did'])) {
				mysql_query("INSERT INTO mainmenu (did) VALUES ('$did')");
				$checked = "checked"; 
			}
		}elseif(isset($_POST['postCheck'])){
			mysql_query("DELETE FROM mainmenu WHERE did = '$did'");
			$checked = "";
		}
		echo "<input type='checkbox' name='mainmenu' value='mainmenuRes' $checked>Show main menu";
		echo "<input type='hidden' value='HiddenPost' name='postCheck' />";
	}

	//printing list of maintable documents!
	function printMainMenu($lang){
		$query = "SELECT mainmenu.did, doc_general_v.did, doc_general_v.pagetitle FROM mainmenu, doc_general_v WHERE mainmenu.did = doc_general_v.did AND langid = '$lang'";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result)){
			echo $row['pagetitle']."<br>";
			echo $row['did']."<br>";
		}
	}
}

//checkMainMenu(0);
?>