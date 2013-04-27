<?php
if (!class_exists('hierarchy')) {
	class hierarchy {
		function load($did) {
			$this->did = $did;
		}

		function printEditArea () {
			global $_GET, $_POST;

			//Delete child
			if(isset($_GET["hierarchy_del_child"])){
				$DeleteChild = $_GET["hierarchy_del_child"];
				$sql = "DELETE FROM `hierarchy` WHERE parent = '$this->did' AND did = '$DeleteChild'";
				mysql_query($sql);
				echo "<SCRIPT LANGUAGE='javascript'>\n";
				echo "document.location='doc_edit.php?did=$this->did';\n";
				echo "</SCRIPT>";
				//echo $sql;
			} 

			//Delete parent
			if(isset($_GET["hierarchy_del_parent"])){
				$DeleteParent = $_GET["hierarchy_del_parent"];
				$sql = "DELETE FROM `hierarchy` WHERE parent = '$DeleteParent' AND did = '$this->did'";
				mysql_query($sql);
				echo "<SCRIPT LANGUAGE='javascript'>\n";
				echo "document.location='doc_edit.php?did=$this->did';\n";
				echo "</SCRIPT>";
				//echo $sql;
			} 

			//adding child to database
			if(isset($_POST["possibleChildren"])){
				print_r($_POST["possibleChildren"]);
				$sql = "INSERT INTO hierarchy SET did = '".$_POST['possibleChildren']."', parent = '$this->did'";
				echo $sql;
				mysql_query($sql);
			}

			//adding parent to database
			if(isset($_POST["possibleParents"])){
				print_r($_POST["possibleParents"]);
				$sql = "INSERT INTO hierarchy SET parent = '".$_POST['possibleParents']."', did = '$this->did'";
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

			$docs = savingData("SELECT * FROM doc ORDER BY ident ASC");
			$children = savingData("SELECT ident, doc.did FROM hierarchy, doc WHERE doc.did = hierarchy.did AND hierarchy.parent = '$this->did' ORDER BY ident ASC");
			$parents = savingData("SELECT ident, doc.did FROM hierarchy, doc WHERE doc.did = hierarchy.parent AND hierarchy.did = '$this->did' ORDER BY ident ASC");


			//children
			$addedChildren = "";
			echo "<div style='border:5px; border-color:#C8C8C8;border-style:solid;width:200px;float:right;'>";
			echo "<form method='POST'>";
			echo "<select name='possibleChildren'>";
			foreach ($docs as $id => $ident) {echo "checking if $id in "; print_r($children); echo "in array ". in_array($id, $children);
				if (!in_array($ident, $children)) {
					echo "<option value='$id'>$ident</option>";
				} else {
					$addedChildren .= "<a href='doc_edit.php?did=$id'>".$ident."</a><a href='doc_edit.php?did=$this->did&hierarchy_del_child=$id'> del</a><br>";
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
			foreach ($docs as $id => $ident) {
				if (!in_array($ident, $parents)) {
					echo "<option value='$id'>$ident</option>";
				} else {
					$addedParents .= "<a href='doc_edit.php?did=$id'>".$ident."</a><a href='doc_edit.php?did=$this->did&hierarchy_del_parent=$id'> del</a><br>";
				}
			}
			echo "</select>";
			echo "<input type='submit' name='input' value='Add Parent'><br>";
			echo "</form>";
			echo $addedParents;
			echo "</div>";
		}

		function delete () {
			//delete did fra hierachy
			$sql = "DELETE FROM `hierarchy` WHERE parent = '$this->did' OR did = '$this->did'";
			echo $sql;
			mysql_query($sql);		
		}
	}
}

?>