<?php
$host = "bg7b1azbx9c4bjnmxvni-mysql.services.clever-cloud.com";
$user = "u9iiujwt53caa5zg";
$pass = "YlzWGw7nsQRZH82UKg7p";
$db   = "bg7b1azbx9c4bjnmxvni";
$port = 3306;

// Conexión incluyendo el puerto para mayor seguridad
$conexion = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Esto es para que las tildes y la 'ñ' se vean bien en tu página
mysqli_set_charset($conexion, "utf8");
?>