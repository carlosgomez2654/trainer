<?php
session_start();
require 'db.php';

// 1. SEGURIDAD: Si no hay sesión, mandarlo al login
if (!isset($_SESSION['id'])) {
    header("Location: ingreso.php");
    exit();
}

$id_usuario = $_SESSION['id'];

// 2. CONSULTA: Traemos las reservas de este usuario específico
// Usamos JOIN para mostrar el nombre del curso en lugar del ID
$sql = "SELECT r.id_reserva, c.nombre_curso, r.fecha_cita, r.hora_cita, r.estado 
        FROM reservas r 
        INNER JOIN cursos c ON r.id_curso = c.id_curso 
        WHERE r.id_usuario = ? 
        ORDER BY r.fecha_cita DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas - Gimnasio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #121212; color: white; padding: 40px; }
        .tabla-reservas { background-color: #1e1e1e; border-radius: 10px; padding: 20px; }
        .table { color: white; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-delete { background-color: #dc3545; color: white; }
        .estado-pendiente { color: #ffc107; font-weight: bold; }
        .estado-confirmada { color: #28a745; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>🗓️ Mis Citas Agendadas</h1>
        <a href="courses.php" class="btn btn-outline-light">Agendar otra</a>
    </div>

    <?php if(isset($_GET['mensaje'])): ?>
        <div class="alert alert-success">Acción realizada con éxito.</div>
    <?php endif; ?>

    <div class="tabla-reservas shadow">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?php echo $row['nombre_curso']; ?></td>
                    <td><?php echo $row['fecha_cita']; ?></td>
                    <td><?php echo $row['hora_cita']; ?></td>
                    <td>
                        <span class="<?php echo ($row['estado'] == 'pendiente') ? 'estado-pendiente' : 'estado-confirmada'; ?>">
                            <?php echo ucfirst($row['estado']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="editar_reserva.php?id=<?php echo $row['id_reserva']; ?>" class="btn btn-sm btn-edit">Editar</a>
                        
                        <a href="eliminar_reserva.php?id=<?php echo $row['id_reserva']; ?>" 
                           class="btn btn-sm btn-delete" 
                           onclick="return confirm('¿Estás seguro de que quieres cancelar esta reserva?')">
                           Cancelar
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>

                <?php if(mysqli_num_rows($resultado) == 0): ?>
                <tr>
                    <td colspan="5" class="text-center">Aún no tienes ninguna reserva.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="mt-4 text-center">
        <a href="index.php" class="text-white">← Volver al inicio</a>
    </div>
</div>

</body>
</html>