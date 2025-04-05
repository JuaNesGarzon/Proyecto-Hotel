<?php
include __DIR__ . '/../controllers/encriptar_desencriptar.php';
include __DIR__ . '/../config/conexion.php';

if (!empty($_POST['enviar'])) {
    if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['documento']) && !empty($_POST['telefono']) && !empty($_POST['correo']) && !empty($_POST['horario']) && !empty($_POST['cargo'])) {
        $id_empleado = $_POST['id_empleado'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $documento = $_POST['documento'];
        $correo = $_POST['correo'];
        $horario = $_POST['horario'];
        $cargo = $_POST['cargo'];

        $encriptarDesencriptar = new EncriptarDesencriptar();
        $clave = "d3j4vu_H0t3l"; // Clave para encriptar

        // Preparar la consulta SQL base
        if (!empty($_POST['password'])) {
            // Si hay contraseña, incluirla en la actualización
            $password = $encriptarDesencriptar->encrypt($_POST['password'], $clave);
            $sql = "UPDATE empleados SET nombre=?, apellido=?, documento=?, telefono=?, correo=?, contraseña=?, horario=?, cargo=? WHERE id_empleado=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssssssssi", $nombre, $apellido, $documento, $telefono, $correo, $password, $horario, $cargo, $id_empleado);
        } else {
            // Si no hay contraseña, no incluirla en la actualización
            $sql = "UPDATE empleados SET nombre=?, apellido=?, documento=?, telefono=?, correo=?, horario=?, cargo=? WHERE id_empleado=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssssssi", $nombre, $apellido, $documento, $telefono, $correo, $horario, $cargo, $id_empleado);
        }

        // Ejecutar la consulta
        if ($stmt->execute()) {
            header("Location: ../form/Editempleado.php?id_empleado=$id_empleado&success=1");
            exit();
        } else {
            header("Location: ../form/Editempleado.php?id_empleado=$id_empleado&error=" . urlencode($stmt->error));
            exit();
        }
        $stmt->close();
    } else {
        header("Location: ../form/Editempleado.php?id_empleado={$_POST['id_empleado']}&error=campos_vacios");
        exit();
    }
}
?>