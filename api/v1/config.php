<?php
//DO NOT CHANGE!!
define("VERSION", "v1");

//MAINTENANCE
//Will block ALL connections if TRUE
define("MAINTENANCE", false);

//MySQL Configuration
define("MYSQL_HOST", "localhost");
define("MYSQL_DBNAME", "soaringtaskbrowser");
define("MYSQL_USERNAME", "root");
define("MYSQL_PASSWORD", "");

$pdo = new PDO('mysql:host=' .MYSQL_HOST .';dbname=' .MYSQL_DBNAME, MYSQL_USERNAME, MYSQL_PASSWORD);

//Authentication Configuration

//IF THIS IS FALSE, EVERYONE CAN POST A TASK TO THE DB!!
define("USE_AUTHENTICATION", true);
define("AUTH_METHOD", "ACCOUNT");
?>