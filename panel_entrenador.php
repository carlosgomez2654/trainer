<?php
include 'db.php';
session_start();

// 1. PROTECCIÓN
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'entrenador') {
    header("Location: ingreso.php");
    exit();
}

// 2. LÓGICA PARA ACEPTAR RESERVA (Con Consultas Preparadas para más seguridad)
if (isset($_GET['aceptar'])) {
    $id_r = $_GET['aceptar'];
    $stmt = mysqli_prepare($conn, "UPDATE reservas SET estado = 'confirmada' WHERE id_reserva = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_r);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: panel_entrenador.php?msg=confirmada");
        exit();
    }
}

// 3. CONSULTA DE RESERVAS (Traemos todas para separarlas en el HTML)
$query = "SELECT r.id_reserva, u.usuario, c.nombre_curso, r.fecha_cita, r.hora_cita, r.estado 
          FROM reservas r
          INNER JOIN usuario u ON r.id_usuario = u.id
          INNER JOIN cursos c ON r.id_curso = c.id_curso
          ORDER BY r.fecha_cita ASC";

$resultado = mysqli_query($conn, $query);

// Separamos los resultados en dos arrays para mostrarlos en tablas distintas
$pendientes = [];
$confirmadas = [];

while($row = mysqli_fetch_assoc($resultado)) {
    if($row['estado'] == 'pendiente') {
        $pendientes[] = $row;
    } else {
        $confirmadas[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Entrenador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #121212; color: #e0e0e0; padding: 30px; }
        .card-gym { background-color: #1e1e1e; border: 1px solid #333; border-radius: 10px; padding: 20px; margin-bottom: 30px; }
        table { color: white !important; }
        .thead-dark th { background-color: #d32f2f; border: none; }
        .btn-accept { background-color: #2e7d32; color: white; border: none; padding: 5px 15px; border-radius: 4px; transition: 0.3s; }
        .btn-accept:hover { background-color: #1b5e20; text-decoration: none; color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>🏋️ Panel de Gestión</h1>
        <div>
            <span class="mr-3">Bienvenido, <strong><?php echo $_SESSION['usuario']; ?></strong></span>
            <a href="cerrar_sesion.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
        </div>
    </div>

    <div class="card-gym">
        <h3 class="text-warning">Reservas por Confirmar</h3>
        <table class="table table-hover mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Curso</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pendientes as $p): ?>
                <tr>
                    <td><?php echo $p['usuario']; ?></td>
                    <td><?php echo $p['nombre_curso']; ?></td>
                    <td><?php echo $p['fecha_cita']; ?></td>
                    <td><?php echo $p['hora_cita']; ?></td>
                    <td>
                        <a href="panel_entrenador.php?aceptar=<?php echo $p['id_reserva']; ?>" 
                           class="btn-accept" onclick="return confirm('¿Confirmar esta cita?')">
                           Confirmar
                        </a>
                    </td>
                </tr>
                <?php endforeach; if(empty($pendientes)) echo "<tr><td colspan='5' class='text-center'>No hay citas pendientes.</td></tr>"; ?>
            </tbody>
        </table>
    </div>

    <div class="card-gym">
        <h3 class="text-success">Agenda Confirmada</h3>
        <table class="table table-sm table-dark table-striped mt-3">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Curso</th>
                    <th>Fecha / Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($confirmadas as $c): ?>
                <tr>
                    <td><?php echo $c['usuario']; ?></td>
                    <td><?php echo $c['nombre_curso']; ?></td>
                    <td><?php echo $c['fecha_cita'] . " - " . $c['hora_cita']; ?></td>
                </tr>
                <?php endforeach; if(empty($confirmadas)) echo "<tr><td colspan='3' class='text-center'>Aún no has confirmado ninguna cita.</td></tr>"; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>