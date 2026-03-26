<?php
session_start();
require 'db.php';

// 1. Verificar sesión
if (!isset($_SESSION['id'])) {
    header("Location: ingreso.php?error=Inicia sesión para agendar");
    exit();
}

// 2. Obtener el ID del curso
$id_curso = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_curso) {
    header("Location: courses.php");
    exit();
}

// 3. Consultar el nombre del curso
$sql_curso = "SELECT nombre_curso FROM cursos WHERE id_curso = ?";
$stmt = mysqli_prepare($conn, $sql_curso);
mysqli_stmt_bind_param($stmt, "i", $id_curso);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nombre_actual);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Sesión - Gym</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Roboto', sans-serif; }

        body {
            background-color: #000;
            background-image: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1540497077202-7c8a3999166f?q=80&w=1470&auto=format&fit=crop');
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
            border: 2px solid #d32f2f;
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 0 25px rgba(211, 47, 47, 0.4);
            text-align: center;
        }

        h2 {
            color: white;
            font-family: 'Bebas Neue', cursive;
            font-size: 2.5rem;
            letter-spacing: 1px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .curso-nombre {
            color: #d32f2f;
            font-family: 'Bebas Neue', cursive;
            font-size: 1.8rem;
            margin-bottom: 25px;
            display: block;
        }

        label {
            display: block;
            text-align: left;
            color: #aaa;
            margin-bottom: 8px;
            font-size: 0.9rem;
            text-transform: uppercase;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #333;
            background-color: #1a1a1a;
            color: white;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        input:focus, select:focus {
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

        .btn-volver {
            display: inline-block;
            margin-top: 20px;
            color: #888;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-volver:hover {
            color: white;
        }

        /* Estilo para el icono de calendario en el input date */
        ::-webkit-calendar-picker-indicator {
            filter: invert(1); /* Hace que el icono del calendario sea blanco */
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>RESERVAR CUPO</h2>
        <span class="curso-nombre"><?php echo htmlspecialchars($nombre_actual); ?></span>
        
        <form action="procesar_reserva.php" method="POST">
            <input type="hidden" name="id_curso" value="<?php echo $id_curso; ?>">

            <label for="fecha">Fecha del Entrenamiento</label>
            <input type="date" name="fecha_cita" id="fecha" required 
                   min="<?php echo date('Y-m-d'); ?>">

            <label for="hora">Selecciona tu Horario</label>
            <select name="hora_cita" id="hora" required>
                <option value="" disabled selected>-- Elige una hora --</option>
                <option value="08:00">08:00 AM (Mañana)</option>
                <option value="10:00">10:00 AM (Mañana)</option>
                <option value="14:00">02:00 PM (Tarde)</option>
                <option value="16:00">04:00 PM (Tarde)</option>
                <option value="18:00">06:00 PM (Noche)</option>
            </select>

            <button type="submit">CONFIRMAR MI SESIÓN</button>
        </form>
        
        <a href="courses.php" class="btn-volver">← Volver a Cursos</a>
    </div>
</body>
</html>