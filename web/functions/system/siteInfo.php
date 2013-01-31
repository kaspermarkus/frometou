<?php
$SITE_INFO_LOCAL_ROOT="/var/www/html/frometou/web/"; //set to your local path to website
$SITE_INFO_PUBLIC_ROOT="http://localhost/frometou/web/"; //set to you public facing url

//NOTICE!!!! No slash on the end
$SITE_INFO_PUBLIC_UPLOADS=$SITE_INFO_PUBLIC_ROOT."/uploads";
$SITE_INFO_LOCAL_UPLOADS=$SITE_INFO_LOCAL_ROOT."/uploads";

$SITE_INFO_WEB_NAME="frometou"; //the name of the website. Only visible in the CMS system

$SITE_INFO_CMS_UNAME="editor"; //Set the username to log on to the CMS system - independent of db user/pass */
$SITE_INFO_CMS_PASS="frometou_secret"; //Set password to log on to CMS system - independent of db user/pass */ 

/* Logon info to database */
$SITE_INFO_DB_HOST="localhost";  //should generally stay as localhost - but can be changed
$SITE_INFO_DB_NAME="frometou_db";  //the name of the database you will use for the website
$SITE_INFO_DB_USER="frometou_user"; //database username
$SITE_INFO_DB_PASS="frometou_pass"; //database password

/* Set whether languages should be enabled */
$SITE_INFO_LANGS_ENABLED=1;    //1 or 0 .. set if multiple languages is enabled - can be changed later


$SHOW_PAGE_TRANSLATIONS=0;  //1 or 0
/*If enabled, two things will happen:
1) When on a page, if other translations of that page exists, a little flag will show that will bring you to the page
2) For autogenerated lists of pages, a flag will show for each translation available.
*/
$SITE_INFO_SHOW_PAGE_TRANSLATIONS=1;  //1 or 0

/* MODULES ENABLING: */
$SITE_INFO_MODULES_ENABLED = [
	"normal_page"
	// "subscription", // function(name,street,city) - subscribe members of a group
	// "hierarchy",
	// "navigator"
];

$SITE_INFO_MODULE_SETTINGS["normal_page"] = [1, 0, 0, 0, 0]; 

/* KFM set up:
KFM is the filemanager used by the system. It uses mysql as a database, so we need to provide it with information on connection and where to store files (incl. images). Further settings can be set directly in the CMS/kfm/configuration.php file.

You can use the same database as your frometou uses, you just need to make sure that the variable $kfm_db_prefix is set to something in the kfm/configuration.php file:
$SITE_INFO_KFM_HOST=$SITE_INFO_DB_HOST;
$SITE_INFO_KFM_NAME=$SITE_INFO_DB_NAME;
$SITE_INFO_KFM_USER=$SITE_INFO_DB_USER;
$SITE_INFO_KFM_PASS=$SITE_INFO_DB_PASS;
$SITE_INFO_KFM_PREFIX="kfm_";

Or use a separate database:
$SITE_INFO_KFM_HOST='localhost';
$SITE_INFO_KFM_NAME='frometou_kfm';
$SITE_INFO_KFM_USER='frometou_kfm_u';
$SITE_INFO_KFM_PASS='frometou_kfm_p';
$SITE_INFO_KFM_PREFIX="kfm_"; 
*/
$SITE_INFO_KFM_HOST='localhost';
$SITE_INFO_KFM_NAME='frometou_kfm';
$SITE_INFO_KFM_USER='frometou_kfm_u';
$SITE_INFO_KFM_PASS='frometou_kfm_p';
$SITE_INFO_KFM_PREFIX="kfm_"; 

?>
