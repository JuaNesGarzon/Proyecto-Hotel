<?php

if (!empty($_POST['enviar'])) {
    if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['documento']) && !empty($_POST['telefono']) && !empty($_POST['nacionalidad']) && !empty($_POST['correo']) && !empty($_POST['password'])) {
        $id_huesped = $_POST['id_huesped'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $documento = $_POST['documento'];
        $telefono = $_POST['telefono'];
        $nacionalidad = $_POST['nacionalidad'];
        $correo = $_POST['correo'];
        $password = ($_POST['password']);

        $sql = $conexion->query("UPDATE huespedes SET nombre='$nombre', apellido='$apellido', documento='$documento', telefono='$telefono', nacionalidad='$nacionalidad', correo='$correo', contraseña='$password' WHERE id_huesped='$id_huesped'");
        if ($sql == 1) {
            // header('Location: ../CRUDadmin.php');
            echo '<div id="successMessage" class="fixed top-0 left-0 right-0 bg-green-500 text-white p-4 text-center transform -translate-y-full transition-transform duration-500 ease-in-out">Modificación exitosa</div>';
        } else {
            echo '<div class="fixed top-0 left-0 right-0 bg-red-500 text-white p-4 text-center">Error al modificar: ' . $sql->error . '</div>';
    }
  } else {
    echo '<div class="fixed top-0 left-0 right-0 bg-red-500 text-white p-4 text-center">Todos los campos son obligatorios</div>';
  }
}
?>