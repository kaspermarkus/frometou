<?php
require_once("../../functions/system/siteInfo.php");
?>
<html>
<head><title>Frometou Initialization</title></head>
<body>

<h1>Frometou Initialization</h1>
<hr>
<h3>1. User and Database creation</h3>
If the database(s) and user(s) of the siteInfo.php file already exist, you do not have to do the below step.

1.1: Enter Username and password for a user with priviliges to create new users and databases (eg. root)
<input size="25" name="user" />
<input size="25" name="pass" />

1.2: Create user(s) and database(s):
<input type="submit" value="save" name="dbcreation" />

<?php

function doquery($sql, $success, $error) {
    mysql_query("CREATE database IF NOT EXISTS frometou_db; ", $link);
echo mysql_errno($link) . ": " . mysql_error($link) . "\n";
};

if (isset($_POST['dbcreation']) && isset($_POST['dbcreation']) && isset($_POST['dbcreation'])) {
    $link = mysql_connect("localhost", "mysql_user", "mysql_password");
    if ($link) {
        mysql_query("SELECT * FROM nonexistenttable", $link);
        echo mysql_errno($link) . ": " . mysql_error($link) . "\n";
    } else {
        echo "<div class='errormsg'>Unable to connect to database with the given credentials</div>"
    }
    //user felt
//pass felt
//if (set user+pass), create db + users and report results
}
?>

<h3>Create database tables and data</h3>
<?php
if (_session NOT) before you go any further you need to log in: LINK OPEN NEW WINDOW

ELSE 
//Knap -> koer SQL script for initializering

//header: Reset database (wipe clean) -- BIG WARNINGS
?>

<h3>
</body>
</html>