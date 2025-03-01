<?php
include __DIR__ . '/../config/conexion.php';

if (!empty($_POST['enviar'])) {
    if (!empty($_POST['numero_habitacion']) && !empty($_POST['tipo']) && !empty($_POST['precio']) && !empty($_POST['estado']) && !empty($_POST['numero_personas']) && !empty($_POST['descripcion'])) {
        $numero_habitacion = $_POST['numero_habitacion'];
        $tipo = $_POST['tipo'];
        $precio = $_POST['precio'];
        $estado = $_POST['estado'];
        $numero_personas = $_POST['numero_personas'];
        $descripcion = $_POST['descripcion'];

        // Manejo de la imagen
        $imagen_path = null;
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $target_dir = "../../public/images/";
            $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Verificar si es una imagen real
            $check = getimagesize($_FILES["imagen"]["tmp_name"]);
            if($check !== false) {
                // Permitir ciertos formatos de archivo
                if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) {
                    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                        $imagen_path = $target_file;
                    }
                }
            }
        }

        $sql = "INSERT INTO habitaciones (numero_habitacion, tipo, precio, estado, numero_personas, descripcion, imagen_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isdsiss", $numero_habitacion, $tipo, $precio, $estado, $numero_personas, $descripcion, $imagen_path);

        if ($stmt->execute()) {
            header("Location: ../form/Createhabitacion.php?success=1");
            exit();
        } else {
            header("Location: ../form/Createhabitacion.php?error=" . urlencode($stmt->error));
            exit();
        }
        $stmt->close();
    } else {
        header("Location: ../form/Createhabitacion.php?error=campos_vacios");
        exit();
    }
}
?>