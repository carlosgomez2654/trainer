<?php
include 'db.php';
session_start();

// 1. Verificamos que el usuario esté logueado
if(!isset($_SESSION['usuario'])){
    header("location: ingreso.php");
    exit();
}

// 2. Atrapamos el ID que viene en la URL
if(isset($_GET['id_plan'])) {
    $id_plan = $_GET['id_plan'];
    $usuario_logueado = $_SESSION['usuario'];

    // 3. Buscamos el ID real del usuario en la tabla 'usuarios'
    $res_user = mysqli_query($conn, "SELECT id FROM usuario WHERE usuario = '$usuario_logueado'");
    $user_data = mysqli_fetch_assoc($res_user);
    $id_usuario = $user_data['id'];

    // 4. Consultamos cuántos meses dura el plan elegido (1, 2 o 3)
    $res_plan = mysqli_query($conn, "SELECT duracion_meses FROM planes WHERE id_plan = $id_plan");
    $plan_data = mysqli_fetch_assoc($res_plan);
    $meses = $plan_data['duracion_meses'];

    // 5. CALCULO DE FECHAS (La parte automática)
    $fecha_inicio = date('Y-m-d'); // Hoy
    $fecha_fin = date('Y-m-d', strtotime("+$meses months")); // Hoy + los meses del plan

    // 6. Insertamos en la tabla membresias
    $sql = "INSERT INTO membresias (id_usuario, id_plan, fecha_inicio, fecha_fin, estado) 
            VALUES ($id_usuario, $id_plan, '$fecha_inicio', '$fecha_fin', 'activa')";

    if(mysqli_query($conn, $sql)) {
        echo "<script>
                alert('¡Pago Simulado Exitoso! Tu membresía vence el: $fecha_fin');
                window.location='courses.php'; 
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>