<?php 
include __DIR__ . '/../config/conexion.php';
session_start();
if (!isset($_SESSION['id_empleado']) || $_SESSION['cargo'] != 1) {
    header("Location: ../form/formEmpleado.php");
    exit();
}

// cierre de sesion 
if (isset($_POST['cierre_sesion'])) {
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
    <title>Administrador</title>
</head>
<body>
<h1 class="text-center">Bienvenido, administrador <?php echo $_SESSION['nombre']; ?></h1>

<button class="cerrar_sesion" id="cerrar_sesion">Cerrar sesión</button>
</body>
</html>