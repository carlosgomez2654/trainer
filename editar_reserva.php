<?php
session_start();
require 'db.php';

$id_r = $_GET['id'];
$sql = "SELECT fecha_cita, hora_cita FROM reservas WHERE id_reserva = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_r);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $fecha_actual, $hora_actual);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar mi Cita</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #121212; color: white; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card-edit { background-color: #1e1e1e; border: 2px solid #d32f2f; border-radius: 15px; padding: 30px; width: 100%; max-width: 400px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .form-control { background-color: #2b2b2b; border: 1px solid #444; color: white; }
        .form-control:focus { background-color: #333; color: white; border-color: #d32f2f; box-shadow: none; }
        label { color: #aaa; font-size: 0.9rem; margin-top: 15px; }
        .btn-update { background-color: #d32f2f; color: white; border: none; font-weight: bold; width: 100%; margin-top: 25px; padding: 10px; transition: 0.3s; }
        .btn-update:hover { background-color: #b71c1c; transform: translateY(-2px); }
        .volver { color: #888; display: block; text-align: center; margin-top: 15px; font-size: 0.8rem; }
    </style>
</head>
<body>

<div class="card-edit">
    <h2 class="text-center mb-4">Modificar Cita</h2>
    <form action="actualizar_logica.php" method="POST">
        <input type="hidden" name="id_reserva" value="<?php echo $id_r; ?>">

        <label>Nueva Fecha</label>
        <input type="date" name="nueva_fecha" class="form-control" value="<?php echo $fecha_actual; ?>" required min="<?php echo date('Y-m-d'); ?>">

        <label>Nueva Hora</label>
        <select name="nueva_hora" class="form-control">
            <option value="08:00:00" <?php echo ($hora_actual == "08:00:00") ? "selected" : ""; ?>>08:00 AM</option>
            <option value="10:00:00" <?php echo ($hora_actual == "10:00:00") ? "selected" : ""; ?>>10:00 AM</option>
            <option value="14:00:00" <?php echo ($hora_actual == "14:00:00") ? "selected" : ""; ?>>02:00 PM</option>
            <option value="16:00:00" <?php echo ($hora_actual == "16:00:00") ? "selected" : ""; ?>>04:00 PM</option>
        </select>

        <button type="submit" class="btn-update">GUARDAR CAMBIOS</button>
        <a href="mis_reservas.php" class="volver">Cancelar y volver</a>
    </form>
</div>

</body>
</html>