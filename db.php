<?php
$host = "bg7b1azbx9c4bjnmxvni-mysql.services.clever-cloud.com";
$user = "u9iiujwt53caa5zg";
$pass = "YlzWGw7nsQRZH82UKg7p";
$db   = "bg7b1azbx9c4bjnmxvni";
$port = 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Error: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");