<?php
session_start();
// Activamos errores para ver todo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- CONFIGURACIÓN DE CONEXIÓN DIRECTA ---
$host = "bg7b1azbx9c4bjnmxvni-mysql.services.clever-cloud.com";
$user = "u9iiujwt53caa5zg";
$pass = "YlzWGw7nsQRZH82UKg7p";
$db   = "bg7b1azbx9c4bjnmxvni";
$port = 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Fallo de conexión directo: " . mysqli_connect_error());
}
// ------------------------------------------

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = trim($_POST['usuario'] ?? '');
    $pass_input = $_POST['contraseña'] ?? '';

    // Ahora $conn SÍ o SÍ existe porque está definida arriba
    $sql = "SELECT id, contraseña, rol FROM usuario WHERE usuario = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $user_input);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $db_id, $db_hash, $db_rol);

        if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($pass_input, $db_hash)) {
                $_SESSION['usuario'] = $user_input;
                $_SESSION['id'] = $db_id;
                $_SESSION['rol'] = $db_rol;

                if ($db_rol == "entrenador") {
                    header("Location: panel_entrenador.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $mensaje = "Contraseña incorrecta.";
            }
        } else {
            $mensaje = "El usuario no existe.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gimnasio - Ingreso</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Roboto', sans-serif; }

        body {
            background-color: #000; /* Fondo negro puro */
            background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop'); /* Imagen de gym de fondo opcional */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: rgba(26, 26, 26, 0.95); /* Gris muy oscuro con transparencia */
            border: 2px solid #d32f2f; /* Borde Rojo Gimnasio */
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 20px rgba(211, 47, 47, 0.3); /* Brillo rojo suave */
            text-align: center;
        }

        h2 {
            color: white;
            font-family: 'Bebas Neue', cursive;
            font-size: 2.5rem;
            letter-spacing: 2px;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        .error {
            background-color: #d32f2f;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        input {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #444;
            background-color: #2b2b2b;
            color: white;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #d32f2f;
            box-shadow: 0 0 5px rgba(211, 47, 47, 0.5);
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #d32f2f;
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Bebas Neue', cursive;
            font-size: 1.5rem;
            cursor: pointer;
            transition: 0.3s;
            letter-spacing: 1px;
        }

        button:hover {
            background-color: #b71c1c;
            transform: translateY(-2px);
        }

        a {
            display: block;
            margin-top: 20px;
            color: #aaa;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        a:hover {
            color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="form-container shadow-lg">
        <h2>Bienvenido</h2>
        
        <?php if ($mensaje): ?> 
            <p class="error"><?php echo $mensaje ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <button type="submit">ENTRAR AL BOX</button>
        </form>

        <a href="./registro.php">¿No tienes cuenta? Regístrate aquí</a>
    </div>
</body>
</html>