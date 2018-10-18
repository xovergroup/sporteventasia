<?php 
session_start();
define("DBHOST", "localhost");
define("DBNAME", "xcowcom_sportevent"); 
define("DBUSER", "xcowcom_sprtevt"); 
define("DBPASS", "B?=_%XyVK&wv"); 
date_default_timezone_set("Asia/Kuala_Lumpur");
header('Content-Type: text/html; charset=utf-8');
$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);


if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//change character set to utf8
if (!$mysqli->set_charset("utf8")) {
	printf("Error loading character set utf8: %s\n", $mysqli->error);
}


?>