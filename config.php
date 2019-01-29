<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // vuskeedo_shop
define('DB_PASSWORD', 'mysql'); // mysql123
define('DB_NAME', 'shop'); // vuskeedo_shop
ini_set('max_execution_time', 300);
ini_set('memory_limit','2048M');
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>