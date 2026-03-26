<?php
session_start();
require 'db.php';

if (isset($_GET['id'])) {
    $id_r = $_GET['id'];
    $id_u = $_SESSION['id'];

    $sql = "DELETE FROM reservas WHERE id_reserva = ? AND id_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_r, $id_u);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: mis_reservas.php?mensaje=eliminado");
        exit();
    } else {
        // Estilo de error en caso de fallo
        echo "<body style='background:#121212; color:white; font-family:sans-serif; display:flex; justify-content:center; align-items:center; height:100vh;'>";
        echo "<div style='text-align:center; border:1px solid #d32f2f; padding:20px; border-radius:10px;'>";
        echo "<h2>Opps! Algo salió mal.</h2>";
        echo "<p>No pudimos cancelar la reserva.</p>";
        echo "<a href='mis_reservas.php' style='color:#d32f2f;'>Volver</a>";
        echo "</div></body>";
    }
}
?>  