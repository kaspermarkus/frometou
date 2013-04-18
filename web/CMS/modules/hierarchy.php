<?php


class hierarchy {
	function insertEditDocHTML () {
		global $_GET, $_POST, $data;

		//Delete child
		if(isset($_GET["hierarchy_del_child"])){
			$DeleteChild = $_GET["hierarchy_del_child"];
			$sql = "DELETE FROM `hierarchy` WHERE parent = '". $data->get('did') ."' AND did = '$DeleteChild'";
			mysql_query($sql);
			echo "<SCRIPT LANGUAGE='javascript'>\n";
			echo "document.location='editDocs.php?did=".$data->get('did')."';\n";
			echo "</SCRIPT>";
			//echo $sql;
		} 

		//Delete parent
		if(isset($_GET["hierarchy_del_parent"])){
			$DeleteParent = $_GET["hierarchy_del_parent"];
			$sql = "DELETE FROM `hierarchy` WHERE parent = '$DeleteParent' AND did = '". $data->get('did') ."'";
			mysql_query($sql);
			echo "<SCRIPT LANGUAGE='javascript'>\n";
			echo "document.location='editDocs.php?did=".$data->get('did')."';\n";
			echo "</SCRIPT>";
			//echo $sql;
		} 

		//adding child to database
		if(isset($_POST["possibleChildren"])){
			print_r($_POST["possibleChildren"]);
			$sql = "INSERT INTO hierarchy SET did = '".$_POST['possibleChildren']."', parent = '".$data->get('did')."'";
			echo $sql;
			mysql_query($sql);
		}

		//adding parent to database
		if(isset($_POST["possibleParents"])){
			print_r($_POST["possibleParents"]);
			$sql = "INSERT INTO hierarchy SET parent = '".$_POST['possibleParents']."', did = '".$data->get('did')."'";
			echo "<br>".$sql."<br>";
			mysql_query($sql);
		}

		function savingData ($query) {
		// saving data of all documents in $docs[]
			$docs = [];
			$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$docs[$row["did"]] = $row["ident"];
			}
		return $docs;
		}

		$docs = savingData("SELECT * FROM doc");
		$children = savingData("SELECT ident, doc.did FROM hierarchy, doc WHERE doc.did = hierarchy.did AND hierarchy.parent = '". $data->get('did') ."' ORDER BY ident ASC");
		$parents = savingData("SELECT ident, doc.did FROM hierarchy, doc WHERE doc.did = hierarchy.parent AND hierarchy.did = '". $data->get('did') ."' ORDER BY ident ASC");


		//children
		$addedChildren = "";
		echo "<div style='border:5px; border-color:#C8C8C8;border-style:solid;width:200px;float:right;'>";
		echo "<form method='POST'>";
		echo "<select name='possibleChildren'>";
		foreach ($docs as $id => $ident) {echo "checking if $id in "; print_r($children); echo "in array ". in_array($id, $children);
			if (!in_array($ident, $children)) {
				echo "<option value='$id'>$ident</option>";
			} else {
				$addedChildren .= "<a href='editDocs.php?did=$id'>".$ident."</a><a href='editDocs.php?did=".$data->get('did')."&hierarchy_del_child=$id'> del</a><br>";
			}
		}
		echo "</select>";
		echo "<input type='submit' name='input' value='Add Child'><br>";
		echo "</form>";
		echo $addedChildren;
		echo "</div>";



		//Parents
		$addedParents = "";
		echo "<div style='border:5px; border-color:#C8C8C8;border-style:solid;width:200px;'>";
		echo "<form method='POST'>";
		echo "<select name='possibleParents'>";
		foreach ($ as $id => $ident) {
			if (!in_array($ident, $parents)) {
				echo "<option value='$id'>$ident</option>";
			} else {
				$addedParents .= "<a href='editDocs.php?did=$id'>".$ident."</a><a href='editDocs.php?did=".$data->get('did')."&hierarchy_del_parent=$id'> del</a><br>";
			}
		}
		echo "</select>";
		echo "<input type='submit' name='input' value='Add Parent'><br>";
		echo "</form>";
		echo $addedParents;
		echo "</div>";
	}

	function deleteDoc ($did) {
		//delete did fra hierachy
			$sql = "DELETE FROM `hierarchy` WHERE parent = '$did' OR did = '$did'";
			mysql_query($sql);		
	}
}

?>