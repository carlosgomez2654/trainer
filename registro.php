<?php
// registro.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// CONEXIÓN DIRECTA A CLEVER CLOUD
$host = "bg7b1azbx9c4bjnmxvni-mysql.services.clever-cloud.com";
$user = "u9iiujwt53caa5zg";
$pass = "YlzWGw7nsQRZH82UKg7p";
$db   = "bg7b1azbx9c4bjnmxvni";
$port = 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $password_plain = $_POST['contraseña']; // Lo que escribe el usuario
    $rol = "cliente"; // Rol por defecto para nuevos registros

    // 1. ENCRIPTAR LA CONTRASEÑA (Obligatorio para que el login funcione)
    $password_hash = password_hash($password_plain, PASSWORD_BCRYPT);

    // 2. INSERTAR EN LA TABLA (Asegúrate que la tabla se llame 'usuario')
    $sql = "INSERT INTO usuario (usuario, contraseña, rol) VALUES (?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $usuario, $password_hash, $rol);
        
        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "¡Registro exitoso! Ya puedes iniciar sesión.";
            // Opcional: Redirigir al login tras 2 segundos
            header("refresh:2; url=ingreso.php");
        } else {
            $mensaje = "Error al registrar: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Error en la base de datos: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gimnasio - Registro</title>
    </head>
<body>
    <div class="form-container">
        <h2>Crear Cuenta</h2>
        <?php if($mensaje) echo "<p>$mensaje</p>"; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <button type="submit">REGISTRARSE</button>
        </form>
        <a href="ingreso.php">¿Ya tienes cuenta? Ingresa aquí</a>
    </div>
</body>
</html>