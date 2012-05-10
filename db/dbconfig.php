<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', ' '); // Your DB Username goes here
define('DB_PASSWORD', ' '); // Your DB PassWord Goes here
define('DB_DATABASE', ' '); // The name of the DB goes here
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
?>