<?php 


if (!empty($_GET['id_empleado'])) {
    $id_empleado = $_GET['id_empleado'];

    $sql = $conexion->query("DELETE FROM empleados WHERE id_empleado='$id_empleado'");
    if ($sql == 1) {
        header('Location: CRUDempleado.php');
        echo '<div class="alert alert-success">Eliminación exitosa</div>';
    } else {
        echo '<div class="alert alert-danger">Error al eliminar</div>';
    }
}
?>