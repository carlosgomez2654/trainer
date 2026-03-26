<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION['id'];
    $id_curso = $_POST['id_curso'];
    $fecha = $_POST['fecha_cita'];
    $hora = $_POST['hora_cita'];
    
    // Por ahora, como solo tienes un entrenador, pongamos el ID 1 por defecto
    $id_entrenador = 1; 

    // Insertamos en tu tabla 'reservas' con los campos que mencionaste
    $sql = "INSERT INTO reservas (id_usuario, id_curso, id_entrenador, fecha_cita, hora_cita, estado) 
            VALUES (?, ?, ?, ?, ?, 'pendiente')";
    
    $stmt = mysqli_prepare($conn, $sql);
    // "iiiss" -> int, int, int, string, string
    mysqli_stmt_bind_param($stmt, "iiiss", $id_usuario, $id_curso, $id_entrenador, $fecha, $hora);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('¡Cita agendada correctamente!');
                window.location.href='index.php';
              </script>";
    } else {
        echo "Error al reservar: " . mysqli_error($conn);
    }
}
?>