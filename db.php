<?php
$host = "sql203.infinityfree.com"; // Revisa en tu panel si es sql203 o sql301
$user = "if0_41479032";            // Tu nombre de usuario de vPanel
$pass = "TuPasswordDeInfinity";    // El password de tu cuenta de hosting (no el de GitHub)
$db   = "if0_41479032_entrenador_personal";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>