<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$db_name    = "e_commmerces";  // EXACT name from MySQL

$conns = mysqli_connect($servername, $username, $password, $db_name);

if (!$conns) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
