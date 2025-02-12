<?php

if (!empty($_POST['enviar'])) {
    if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['documento']) && !empty($_POST['telefono']) && !empty($_POST['correo']) && !empty($_POST['password']) && !empty($_POST['horario']) && !empty($_POST['cargo'])) {
        $id_empleado = $_POST['id_empleado'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $documento = $_POST['documento'];
        $correo = $_POST['correo'];
        $password = ($_POST['password']);
        $horario = $_POST['horario'];
        $cargo = $_POST['cargo'];

        $sql = $conexion->query("UPDATE empleados SET nombre='$nombre', apellido='$apellido', documento='$documento', telefono='$telefono', correo='$correo', contraseña='$password', horario='$horario', cargo='$cargo' WHERE id_empleado='$id_empleado'");
        if ($sql == 1) {
            echo '<div id="successMessage" class="fixed top-0 left-0 right-0 bg-green-500 text-white p-4 text-center transform -translate-y-full transition-transform duration-500 ease-in-out">Modificación exitosa</div>';
        } else {
            echo '<div class="fixed top-0 left-0 right-0 bg-red-500 text-white p-4 text-center">Error al modificar: ' . $sql->error . '</div>';
    }
  } else {
    echo '<div class="fixed top-0 left-0 right-0 bg-red-500 text-white p-4 text-center">Todos los campos son obligatorios</div>';
  }
}
?>