<?php
require_once("../../../functions/system/siteInfo.php");
session_start();

?>
<html>
<head><title>Frometou Initialization</title></head>
<body>

<h1>Frometou Initialization</h1>
<hr>
<h3>1. User and Database creation</h3>
If the database(s) and user(s) of the siteInfo.php file already exist, you do not have to do the below step.

<h4>1.1: Enter Username and password for a user with priviliges to create new users and databases (eg. root)</h4>
<form method="POST">
<label for='user'>User</label><input size="25" id='user' name="user" /><br />
<label for='pass'>Pass</label><input size="25" id='pass' name="pass" /><br />
<input type="submit" value="save" name="dbcreation" />
</form>

<?php
//Form handling for User and Database creation
function doquery($link, $query, $successmsg, $errormsg) {
    if (mysql_query($query, $link)) {
        echo "<div class='successmsg'>$successmsg</div>";
        return true;
    } else {
        echo "<div class='errormsg'>ERROR: $errormsg<br />".mysql_errno($link).": ".mysql_error($link)."</div>";
        return false;
    }
};

if (isset($_POST['dbcreation']) && isset($_POST['user']) && isset($_POST['pass'])) {
    $link = mysql_connect("localhost", $_POST['user'], $_POST['pass']);
    if ($link) {
        $query = "CREATE database IF NOT EXISTS $SITE_INFO_DB_NAME";
        $ok = doquery($link, $query, "Successfully created database", "Error creating the database with name: $SITE_INFO_DB_NAME");

        $query = "grant usage on $SITE_INFO_DB_NAME.* to $SITE_INFO_DB_USER@localhost identified by '$SITE_INFO_DB_PASS';";
        $ok = doquery($link, $query, "Successfully created user $SITE_INFO_DB_USER", "Error creating the user with name: $SITE_INFO_DB_NAME");

        $query = "grant all privileges on $SITE_INFO_DB_NAME.* to $SITE_INFO_DB_USER@localhost";
        $ok = doquery($link, $query, "Successfully gave user privileges to the database", "Failed giving user priviliges to user database");
    } else {
        echo "<div class='errormsg'>Unable to connect to database with the given credentials - try again</div>";
    }
}
?>

<h3>2. Create database tables and example data</h3>
NB: You need to have 'mysql' installed as command line utility on the machine

<?php

$loggedIn = ($_SESSION['uname'] == "$SITE_INFO_CMS_UNAME" && $_SESSION['pass'] == "$SITE_INFO_CMS_PASS");

if (!$loggedIn) {
    echo "<div class='warningmsg'>You need to log in to the system before you can go any further - ".
        "the link will open a new window with the login screen. Log in, then go back to this page and refresh. <a href='../../login.php' target='_blank'>Log in here</a></div>";
} else {
    echo "You are all set to create the database tables. Click the below button to start table creation."
    ?>
    <form method="POST">
        <input type="submit" name="createTables" value="Create Tables">
    </form>
    <?php
    if (isset($_POST['createTables'])) {
        $command = "mysql -u$SITE_INFO_DB_USER -p$SITE_INFO_DB_PASS -h $SITE_INFO_DB_HOST -D $SITE_INFO_DB_NAME < ".dirname(__FILE__)."/frometou_db_init.sql";
        $output = shell_exec($command);
        //the authorize script will ensure that modules are created in database
        require_once("../authorize.php");
        //Create the front page document:

        // $query = "REPLACE INTO doc SET did=0, module_signature='normal_page', description_img=NULL, ident='Front Page', priority='100'";
        // mysql_query($query);
        // $query = "REPLACE INTO doc_general_v SET did=0, langid='uk', linktext='Home', pagetitle='Front Page', description='This is the front page of your website'";
        // mysql_query($query);
        $command = "mysql -u$SITE_INFO_DB_USER -p$SITE_INFO_DB_PASS -h $SITE_INFO_DB_HOST -D $SITE_INFO_DB_NAME < ".dirname(__FILE__)."/frometou_db_data.sql";
        $output = shell_exec($command);
    }
}

//Knap -> koer SQL script for initializering

//header: Reset database (wipe clean) -- BIG WARNINGS
?>

<h3>
</body>
</html>