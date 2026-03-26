<?php
    // Datos REALES de tu cuenta de InfinityFree
    $host = "sql208.infinityfree.com"; 
    $user = "if0_41479032";
    $pass = "WPzFxg2afZx4E";
    $db   = "if0_41479032_XXX"; // <-- IMPORTANTE: Cambia XXX por el nombre que creaste

    // Validar conexion
    $conn = mysqli_connect($host, $user, $pass, $db);

    if ($conn) {
        // Conexión exitosa (lo dejamos en silencio para la web)
    } else {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Configuración para subir imágenes
    $upload_dir = "assets/img/";
    $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
    $max_size = 5 * 1024 * 1024; // 5 MB
?>