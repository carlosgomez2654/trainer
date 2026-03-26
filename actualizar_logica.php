<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_r = $_POST['id_reserva'];
    $fecha = $_POST['nueva_fecha'];
    $hora = $_POST['nueva_hora'];

    // Al editar, el estado vuelve a 'pendiente' para que el entrenador lo apruebe de nuevo
    $sql = "UPDATE reservas SET fecha_cita = ?, hora_cita = ?, estado = 'pendiente' WHERE id_reserva = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $fecha, $hora, $id_r);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: mis_reservas.php?mensaje=actualizado");
        exit();
    }
}
?>