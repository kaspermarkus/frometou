<?php

$SITE_INFO_LOCALROOT="/var/www/html/frometou/web/"; //set to your local path to website
$SITE_INFO_PUBLIC_ROOT="http://localhost/frometou/web/"; //set to you public facing url

$SITE_INFO_WEB_NAME="frometou"; //the name of the website. Only visible in the CMS system

$SITE_INFO_CMS_UNAME="editor"; //Set the username to log on to the CMS system - independent of db user/pass */
$SITE_INFO_CMS_PASS="frometou_secret"; //Set password to log on to CMS system - independent of db user/pass */ 

/* Logon info to database */
$SITE_INFO_DB_HOST="localhost";  //should generally stay as localhost - but can be changed
$SITE_INFO_DB_NAME="frometou_db";  //the name of the database you will use for the website
$SITE_INFO_DB_USER="frometou_user"; //database username
$SITE_INFO_DB_PASS="frometou_pass"; //database password

/* Set whether languages should be enabled */
$SITE_INFO_LANGS_ENABLED="0";    //set if multiple languages is enabled - can be changed later

$localCMSRoot = $SITE_INFO_LOCALROOT."CMS/";
$publicCMSRoot = $SITE_INFO_PUBLIC_ROOT."CMS/";

?>