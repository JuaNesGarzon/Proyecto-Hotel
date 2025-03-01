<?php
include __DIR__ . '/../controllers/encriptar_desencriptar.php';
include __DIR__ . '/../config/conexion.php';

if (!empty($_POST['enviar'])) {
    if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['documento']) && !empty($_POST['telefono']) && !empty($_POST['nacionalidad']) && !empty($_POST['correo'])) {
        $id_huesped = $_POST['id_huesped'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $documento = $_POST['documento'];
        $telefono = $_POST['telefono'];
        $nacionalidad = $_POST['nacionalidad'];
        $correo = $_POST['correo'];

        $encriptarDesencriptar = new EncriptarDesencriptar();
        $clave = "d3j4vu_H0t3l"; // Asegúrate de que esta clave sea la misma que se usa para encriptar al registrar

        $sql = "UPDATE huespedes SET nombre=?, apellido=?, documento=?, telefono=?, nacionalidad=?, correo=?";
        $params = [$nombre, $apellido, $documento, $telefono, $nacionalidad, $correo];
        $types = "ssssss";

        if (!empty($_POST['password'])) {
            $password = $encriptarDesencriptar->encrypt($_POST['password'], $clave);
            $sql .= ", contraseña=?";
            $params[] = $password;
            $types .= "s";
        }

        $sql .= " WHERE id_huesped=?";
        $params[] = $id_huesped;
        $types .= "i";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            header("Location: ../form/Edithuesped.php?id_huesped=$id_huesped&success=1");
            exit();
        } else {
            header("Location: ../form/Edithuesped.php?id_huesped=$id_huesped&error=" . urlencode($stmt->error));
            exit();
        }
        $stmt->close();
    } else {
        header("Location: ../form/Edithuesped.php?id_huesped=$id_huesped&error=campos_vacios");
        exit();
    }
}
?>