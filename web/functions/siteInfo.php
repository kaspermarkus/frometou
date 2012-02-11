<?php

$SITE_INFO_LOCALROOT="/var/www/html/frometou/web/";
$SITE_INFO_PUBLIC_ROOT="http://localhost/frometou/web/";

$SITE_INFO_WEB_NAME="frometou";

$SITE_INFO_CMS_UNAME="editor"; /*   To log on to CMS system - independent of db user/pass */
$SITE_INFO_CMS_PASS="frometou_secret"; /* To log on to CMS system - independent of db user/pass */ 

/* Logon info to database */
$SITE_INFO_DB_HOST="localhost"; 
$SITE_INFO_DB_NAME="frometou_db";
$SITE_INFO_DB_USER="frometou_user";
$SITE_INFO_DB_PASS="frometou_pass";

/* Set whether languages should be enabled */
$SITE_INFO_LANGS_ENABLED="0";

$localCMSRoot = $SITE_INFO_LOCALROOT."CMS/";
$publicCMSRoot = $SITE_INFO_PUBLIC_ROOT."CMS/";

$relativeFileDir = "files/";
$relativeImageDir = "images/";

$localImageDir = $SITE_INFO_LOCALROOT.$relativeImageDir;
$publicImageDir = $SITE_INFO_PUBLIC_ROOT.$relativeImageDir;

$localFileDir = $SITE_INFO_LOCALROOT.$relativeFileDir;
$publicFileDir = $SITE_INFO_PUBLIC_ROOT.$relativeFileDir;

/* KFM database properties */
$SITE_INFO_KFM_DB_NAME     = 'frometou_kfm';
$SITE_INFO_KFM_DB_USERNAME = 'frometou_kfm_u';
$SITE_INFO_KFM_DB_PASSWORD = 'frometou_kfm_p';
?>
