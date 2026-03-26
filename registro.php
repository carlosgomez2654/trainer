<?php
    require 'db.php';
    $mensaje="";
    if ($_SERVER["REQUEST_METHOD"]== "POST"){
        $usuario=trim($_POST['usuario']);
        $contraseña=password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
        
        // Nota: Asegúrate de que tu tabla 'usuario' tenga una columna 'rol' 
        // con un valor por defecto (como 'cliente') para que esto no falle.
        $sql="INSERT INTO usuario (usuario,contraseña) VALUES (?,?)";
        $stmt= mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss",$usuario,$contraseña);

        if(mysqli_stmt_execute($stmt)){
            header("location:ingreso.php");
            exit();
        }else{
            $mensaje="Error: El usuario ya existe ❌";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gimnasio - Registro</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Roboto', sans-serif; }

        body {
            background-color: #000;
            /* Usamos la misma imagen de fondo que el ingreso para que parezca la misma app */
            background-image: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: rgba(20, 20, 20, 0.95);
            border: 2px solid #d32f2f; /* Rojo intenso */
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 0 25px rgba(211, 47, 47, 0.4);
            text-align: center;
            transition: 0.3s;
        }

        h2 {
            color: white;
            font-family: 'Bebas Neue', cursive;
            font-size: 2.8rem;
            letter-spacing: 2px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        p.subtitulo {
            color: #888;
            margin-bottom: 25px;
            font-size: 0.9rem;
        }

        .error {
            background-color: rgba(211, 47, 47, 0.2);
            color: #ff5252;
            padding: 12px;
            border-left: 4px solid #d32f2f;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #333;
            background-color: #1a1a1a;
            color: white;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #d32f2f;
            background-color: #222;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #d32f2f;
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Bebas Neue', cursive;
            font-size: 1.6rem;
            cursor: pointer;
            transition: 0.3s;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        button:hover {
            background-color: #b71c1c;
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(211, 47, 47, 0.4);
        }

        a {
            display: block;
            margin-top: 25px;
            color: #d32f2f;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        a:hover {
            text-decoration: underline;
            color: #ff5252;
        }

        /* Pequeño detalle: decoración inferior */
        .decoration {
            width: 50px;
            height: 3px;
            background-color: #d32f2f;
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Únete al Equipo</h2>
        <div class="decoration"></div>
        <p class="subtitulo">Crea tu cuenta y empieza a entrenar hoy mismo.</p>
        
        <?php if ($mensaje): ?> 
            <p class="error"><?php echo $mensaje ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <input type="text" name="usuario" placeholder="Elige un nombre de usuario" required>
            <input type="password" name="contraseña" placeholder="Crea una contraseña segura" required>
            <button type="submit">UNIRME AHORA</button>
        </form>

        <a href="./ingreso.php">¿Ya eres miembro? Inicia Sesión</a>
    </div>
</body>
</html>