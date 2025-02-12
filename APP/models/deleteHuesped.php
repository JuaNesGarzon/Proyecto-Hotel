<?php 

if (!empty($_GET['id_huesped'])) {
    $id_huesped = $_GET['id_huesped'];

    $sql = $conexion->query("DELETE FROM huespedes WHERE id_huesped='$id_huesped'");
    if ($sql == 1) {
        header('Location: CRUDadmin.php');
        echo '<div class="alert alert-success">Eliminación exitosa</div>';
    } else {
        echo '<div class="alert alert-danger">Error al eliminar</div>';
    }
}
?>