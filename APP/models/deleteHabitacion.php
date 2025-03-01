<?php 


if (!empty($_GET['id_habitacion'])) {
    $id_habitacion = $_GET['id_habitacion'];

    $sql = $conexion->query("DELETE FROM habitaciones WHERE id_habitacion='$id_habitacion'");
    if ($sql == 1) {
        header('Location: CRUDhabitacion.php');
        echo '<div class="alert alert-success">Eliminación exitosa</div>';
    } else {
        echo '<div class="alert alert-danger">Error al eliminar</div>';
    }
}
?>