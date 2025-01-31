<?php 
include __DIR__ . '/../config/conexion.php';
session_start();
if (!isset($_SESSION['id_empleado']) || $_SESSION['cargo'] != 3) {
    header("Location: ../form/formEmpleado.php");
    exit();
}

// cierre de sesion 
if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("Location: ../form/formEmpleado.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento</title>
</head>
<body>
<h1 class="text-center">Bienvenido, empleado de mantenimiento <?php echo $_SESSION['nombre']; ?></h1>
<a href="../../logout.php">Cerrar sesión</a>
</body>
</html>